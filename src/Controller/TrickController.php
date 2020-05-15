<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Service\FileUploaderService;
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
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager, FileUploaderService $fileUploaderService)
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            foreach ($trick->getMedias() as $media) {
                $media->setTrick($trick);
                $manager->persist($media);
            }

            $trick->setCreator($this->getUser());

            $coverImage = $form['coverImage']->getData();
            if ($coverImage) {
               $coverImageName = $fileUploaderService->upload($coverImage);
               $trick->setCoverImage($coverImageName);
            }

            $images = $form['images']->getData();
            if ($images) {
                foreach ($images as $image) {
                    $img = new Image();
                    $imageName = $fileUploaderService->upload($image);
                    $img->setTrick($trick);
                    $img->setName($imageName);
                    $trick->addImage($img);
                    $trick->removeNotImageFile($image);
                    $manager->persist($img);
                }
            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                "La figure <strong>{$trick->getName()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('tricks_index');
        }

        return $this->render('trick/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Displays all the tricks
     *
     * @Route("/tricks", name="tricks_index")
     * @param TrickRepository $repo
     * @return Response
     */
    public function index(TrickRepository $repo)
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $repo->findAll()
        ]);
    }

    /**
     * Displays one particular trick
     *
     * @Route("/tricks/{slug}", name="tricks_show")
     * @param Trick $trick
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function show(Trick $trick, Request $request, EntityManagerInterface $manager)
    {
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
            'form' => $form->createView()
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
     * @return Response
     */
    public function edit(Request $request, Trick $trick, EntityManagerInterface $manager, FileUploaderService $fileUploaderService)
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
                    $img = new Image();
                    $imageName = $fileUploaderService->upload($image);
                    $img->setTrick($trick);
                    $img->setName($imageName);
                    $trick->addImage($img);
                    $trick->removeNotImageFile($image);
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
     * @return RedirectResponse
     */
    public function delete(Trick $trick, EntityManagerInterface $manager)
    {
        $manager->remove($trick);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'annonce <strong>{$trick->getName()}</strong> a bien été supprimée !"
        );

        return $this->redirectToRoute('tricks_index');
    }
}
