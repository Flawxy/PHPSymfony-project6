<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\Service\FileUploaderService;
use App\Service\ImageManagementService;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * Displays the creating form for a trick
     *
     * @Route("tricks/new", name="tricks_create")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param FileUploaderService $fileUploaderService
     * @param ImageManagementService $imageManagementService
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager, FileUploaderService $fileUploaderService, ImageManagementService $imageManagementService)
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $images = $form['images']->getData();
            if ($images) {
                foreach ($images as $image) {
                    $imageName = $fileUploaderService->upload($image);
                    if  (!$imageManagementService->isFileAnImage($imageName)) {
                        $imageManagementService->deleteAnImageFromTheUploadDirectory($imageName);
                        $this->addFlash(
                            'warning',
                            "Le fichier que vous avez choisi n'est pas une image !"
                        );

                        return $this->render('trick/new.html.twig', [
                            'form' => $form->createView()
                        ]);
                    }
                    $img = new Image();
                    $img->setTrick($trick);
                    $img->setName($imageName);
                    $trick->addImage($img);
                    $manager->persist($img);
                }
            }

            foreach ($trick->getMedias() as $media) {
                $media->setTrick($trick);
                $manager->persist($media);
            }

            $trick->setCreator($this->getUser());

            $coverImage = $form['coverImage']->getData();
            if ($coverImage) {
               $coverImageName = $fileUploaderService->upload($coverImage);
               $trick->setCoverImage($coverImageName);
            } else {
                $this->addFlash(
                    'warning',
                    "Vous devez sélectionner une image de couverture pour la figure !"
                );

                return $this->render('trick/new.html.twig', [
                    'form' => $form->createView()
                ]);
            }


            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                "La figure <strong>{$trick->getName()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('trick/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Displays one particular trick
     *
     * @Route("/tricks/{slug}/{page<\d+>?1}", name="tricks_show")
     * @param Trick $trick
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param CommentRepository $commentRepository
     * @param PaginationService $paginationService
     * @param int $page
     * @return Response
     */
    public function show(Trick $trick, Request $request, EntityManagerInterface $manager, CommentRepository $commentRepository, PaginationService $paginationService, $page)
    {
        $paginationService
            ->setEntityClass(Comment::class)
            ->setPropertyName('trick')
            ->setPropertyValue($trick->getId())
            ->setPropertyToOrderBy('date')
            ->setCurrentPage($page);

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $comment->setTrick($trick);

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre commentaire a bien été publié !"
            );

            return $this->redirectToRoute('tricks_show', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
            'pagination' => $paginationService
        ]);
    }

    /**
     * Displays the editing form of a trick
     *
     * @Route("/tricks/{slug}/edit", name="tricks_edit")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param Trick $trick
     * @param EntityManagerInterface $manager
     * @param FileUploaderService $fileUploaderService
     * @param ImageManagementService $imageManagementService
     * @return Response
     */
    public function edit(Request $request, Trick $trick, EntityManagerInterface $manager, FileUploaderService $fileUploaderService, ImageManagementService $imageManagementService)
    {
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            foreach ($trick->getMedias() as $media) {
                $media->setTrick($trick);
                $manager->persist($media);
            }
            $trick->updateDate();

            $coverImage = $form['coverImage']->getData();
            if ($coverImage) {
                $coverImageName = $fileUploaderService->upload($coverImage);
                $trick->setCoverImage($coverImageName);
            }

            $images = $form['images']->getData();
            if ($images) {
                foreach ($images as $image) {
                    $imageName = $fileUploaderService->upload($image);
                    if  (!$imageManagementService->isFileAnImage($imageName)) {
                        $imageManagementService->deleteAnImageFromTheUploadDirectory($imageName);
                        $this->addFlash(
                            'warning',
                            "Le fichier que vous avez choisi n'est pas une image !"
                        );

                        return $this->render('trick/edit.html.twig', [
                            'form' => $form->createView(),
                            'trick' => $trick
                        ]);
                    }
                    $img = new Image();
                    $img->setTrick($trick);
                    $img->setName($imageName);
                    $trick->addImage($img);
                    $manager->persist($img);
                }
            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de la figure <strong>{$trick->getName()}</strong> ont bien été enregistrées !"
            );

            return $this->redirectToRoute('tricks_show', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * Allows an user to delete a trick
     * @Route("/tricks/{slug}/delete", name="tricks_delete")
     * @IsGranted("ROLE_USER")
     * @param Trick $trick
     * @param EntityManagerInterface $manager
     * @param ImageManagementService $imageManagementService
     * @return RedirectResponse
     */
    public function delete(Trick $trick, EntityManagerInterface $manager, ImageManagementService $imageManagementService)
    {
        if ($trick->getImages()) {
           foreach ($trick->getImages() as $image) {
               $imageManagementService->deleteAnImageFromTheUploadDirectory($image->getName());
           }
        }

        $imageManagementService->deleteAnImageFromTheUploadDirectory($trick->getCoverImage());

        $manager->remove($trick);
        $manager->flush();

        $this->addFlash(
            'success',
            "La figure <strong>{$trick->getName()}</strong> a bien été supprimée !"
        );

        return $this->redirectToRoute('homepage');
    }
}
