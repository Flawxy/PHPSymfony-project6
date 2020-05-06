<?php

namespace App\Controller;

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
     * @param $slug
     * @param TrickRepository $repo
     * @return Response
     */
    public function show($slug, TrickRepository $repo)
    {
        return $this->render('trick/show.html.twig', [
            'trick' => $repo->findOneBySlug($slug)
        ]);
    }
}
