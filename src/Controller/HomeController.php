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
     * @Route("/{page<\d+>?1}", name="homepage")
     * @param TrickRepository $trickRepository
     * @param PaginationService $paginationService
     * @param $page
     * @return Response
     */
    public function home(TrickRepository $trickRepository, PaginationService $paginationService, $page)
    {
        $paginationService
            ->setEntityClass(Trick::class)
            ->setPropertyToOrderBy('creationDate')
            ->setLimit(6)
            ->setCurrentPage($page);

        return $this->render("home.html.twig", [
            'pagination' => $paginationService,
            'tricks' => $trickRepository->findAll()
            ]
        );
    }
}