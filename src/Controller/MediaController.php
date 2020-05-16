<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{
    /**
     * Allows to replace a media with another one
     *
     * @Route("/medias/{id}/edit", name="media_edit")
     * @IsGranted("ROLE_USER")
     * @param Media $media
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Media $media, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(MediaType::class, $media);
        $trick = $media->getTrick();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->remove($media);
            $newMedia = new Media();
            $newMedia->setUrl($form['url']->getData());
            $newMedia->setTrick($trick);
            $trick->addMedia($newMedia);

            $manager->persist($newMedia);
            $manager->persist($trick);

            $manager->flush();

            $this->addFlash(
                'success',
                "La vidéo a bien été modifiée !"
            );

            return $this->redirectToRoute('tricks_show', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('media/edit.html.twig', [
            'form' => $form->createView(),
            'video' => $media
        ]);
    }

    /**
     * Allows to delete a media from a trick
     *
     * @Route("/medias/{id}/delete", name="media_delete")
     * @IsGranted("ROLE_USER")
     * @param Media $media
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function delete(Media $media, EntityManagerInterface $manager)
    {
        $manager->remove($media);
        $manager->flush();

        $this->addFlash(
            'success',
            "La vidéo a bien été supprimée de la figure <strong>{$media->getTrick()->getName()}</strong> !"
        );

        return $this->redirectToRoute('tricks_show', [
            'slug' => $media->getTrick()->getSlug()
        ]);
    }
}
