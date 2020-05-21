<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Form\CoverImageType;
use App\Repository\ImageRepository;
use App\Service\FileUploaderService;
use App\Service\ImageManagementService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoverImageController extends AbstractController
{
    /**
     * Displays the editing form for the cover image of a trick
     *
     * @Route("/cover/{id}/edit", name="cover_edit")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param Trick $trick
     * @param EntityManagerInterface $manager
     * @param FileUploaderService $fileUploaderService
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Trick $trick, EntityManagerInterface $manager, FileUploaderService $fileUploaderService)
    {
        $form = $this->createForm(CoverImageType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $coverImage = $form['coverImage']->getData();
            if ($coverImage) {
                $coverImageName = $fileUploaderService->upload($coverImage);
                $trick->setCoverImage($coverImageName);
            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'image de couverture de la figure <strong>{$trick->getName()}</strong> a bien été modifiée !"
            );

            return $this->redirectToRoute('tricks_show', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('coverImage/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * Allows to delete the cover image of a trick
     *
     * @Route("/cover/{id}/delete", name="cover_delete")
     * @IsGranted("ROLE_USER")
     * @param Trick $trick
     * @param EntityManagerInterface $manager
     * @param ImageRepository $imageRepository
     * @param ImageManagementService $imageManagementService
     * @return RedirectResponse
     */
    public function delete(Trick $trick, EntityManagerInterface $manager, ImageRepository $imageRepository, ImageManagementService $imageManagementService)
    {
        if ($trick->getImages()->count() > 0)
        {
            $imageManagementService->deleteAnImageFromTheUploadDirectory($trick->getCoverImage());

            /** @var Image $newCoverImage */
            $newCoverImage = $imageRepository->findOneByTrick($trick->getId());
            $trick->setCoverImage($newCoverImage->getName());

            $manager->remove($newCoverImage);
            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'image de couverture de la figure <strong>{$trick->getName()}</strong> a bien été supprimée !"
            );

        } else {
            $this->addFlash(
                'warning',
                "L'image de couverture de la figure <strong>{$trick->getName()}</strong> n'a pas pu être supprimée car il n'y a pas d'autre image pour la remplacer !"
            );
        }

        return $this->redirectToRoute('tricks_show', [
            'slug' => $trick->getSlug()
        ]);
    }
}
