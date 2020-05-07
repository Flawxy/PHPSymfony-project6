<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * Creates a trick
     *
     * @Route("tricks/new", name="tricks_create")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            foreach ($trick->getMedias() as $media) {
                $media->setTrick($trick);
                $manager->persist($media);
            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                "La figure <strong>{$trick->getName()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('tricks_show', [
                'slug' => $trick->getSlug()
            ]);
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
     * @return Response
     */
    public function show(Trick $trick)
    {
        return $this->render('trick/show.html.twig', [
            'trick' => $trick
        ]);
    }
}
