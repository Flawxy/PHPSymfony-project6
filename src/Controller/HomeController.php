<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Display the homepage
     *
     * @Route("/", name="homepage")
     * @param TrickRepository $trickRepository
     * @return Response
     */
    public function home(TrickRepository $trickRepository)
    {
        $tricksPerRow = 4;
        $tricks = $trickRepository->findAll();
        $numberOfTricks = count($tricks);
        $numberOfRow = ceil($numberOfTricks / $tricksPerRow);

        return $this->render("home.html.twig", [
            'tricks' => $tricks,
            'totalTricks' => $numberOfTricks,
            'numberOfRow' => $numberOfRow
            ]
        );
    }
}
