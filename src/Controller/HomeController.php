<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_index', methods: ['GET'])]
    public function index(LivreRepository $livreRepository ): Response
    {

        $livres = $livreRepository->findAll();

        
        return $this->render('home/index.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/livre/{id}', name: 'app_home_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('home/show.html.twig', [
            'livre' => $livre,
        ]);
    }
}
