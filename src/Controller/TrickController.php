<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
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
     * @return Response
     */
    public function show(Trick $trick)
    {
        return $this->render('trick/show.html.twig', [
            'trick' => $trick
        ]);
    }
<<<<<<< Updated upstream
=======
<<<<<<< Updated upstream
=======
<<<<<<< Updated upstream
=======
>>>>>>> Stashed changes

    /**
     * Displays the editing form of a trick
     *
     * @Route("/tricks/{slug}/edit", name="tricks_edit")
     * @param Request $request
     * @param Trick $trick
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Request $request, Trick $trick, EntityManagerInterface $manager)
    {
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

<<<<<<< Updated upstream
        if($form->isSubmitted() && $form->isValid()) {
=======
        if ($form->isSubmitted() && $form->isValid()) {
>>>>>>> Stashed changes
            foreach ($trick->getMedias() as $media) {
                $media->setTrick($trick);
                $manager->persist($media);
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
<<<<<<< Updated upstream
=======
>>>>>>> Stashed changes
>>>>>>> Stashed changes
>>>>>>> Stashed changes
}
