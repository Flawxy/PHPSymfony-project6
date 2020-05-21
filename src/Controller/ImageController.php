<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Service\FileUploaderService;
use App\Service\ImageManagementService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * Allows to replace an image with another one
     *
     * @Route("/images/{id}/edit", name="image_edit")
     * @IsGranted("ROLE_USER")
     * @param Image $image
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param FileUploaderService $fileUploaderService
     * @param ImageManagementService $imageManagementService
     * @return Response
     */
    public function edit(Image $image, Request $request, EntityManagerInterface $manager, FileUploaderService $fileUploaderService, ImageManagementService $imageManagementService)
    {
        $form = $this->createForm(ImageType::class, $image);
        $trick = $image->getTrick();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $newImage = new Image();
            $imageName = $fileUploaderService->upload($form['name']->getData());
            $newImage->setTrick($trick);
            $newImage->setName($imageName);
            $trick->addImage($newImage);

            /* Deletes the old image from the DB and the upload directory */
            $imageManagementService->deleteAnImageFromTheUploadDirectory($image->getName());
            $manager->remove($image);

            $manager->persist($newImage);
            $manager->persist($trick);
        
            $manager->flush();

            $this->addFlash(
                'success',
                "L'image a bien été modifiée !"
            );

            return $this->redirectToRoute('tricks_show', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('image/edit.html.twig', [
            'form' => $form->createView(),
            'image' => $image
        ]);
    }

    /**
     * Allows to delete an image from a trick
     *
     * @Route("/images/{id}/delete", name="image_delete")
     * @IsGranted("ROLE_USER")
     * @param Image $image
     * @param EntityManagerInterface $manager
     * @param ImageManagementService $imageManagementService
     * @return RedirectResponse
     */
    public function delete(Image $image, EntityManagerInterface $manager, ImageManagementService $imageManagementService)
    {
        /* Deletes the old image from the DB and the upload directory */
        $imageManagementService->deleteAnImageFromTheUploadDirectory($image->getName());
        $manager->remove($image);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'image a bien été supprimée de la figure <strong>{$image->getTrick()->getName()}</strong> !"
        );

        return $this->redirectToRoute('tricks_show', [
            'slug' => $image->getTrick()->getSlug()
        ]);
    }
}
