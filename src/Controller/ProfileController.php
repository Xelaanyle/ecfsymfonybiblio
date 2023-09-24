<?php

namespace App\Controller;

use App\Entity\Livre;
use DateTime;
use App\Repository\EmpruntRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class ProfileController extends AbstractController
{

    
    #[Route('/livre', name: 'app_profile_livre_index', methods: ['GET'])]
    public function indexLivre(LivreRepository $livreRepository ): Response
    {

        $livres = $livreRepository->findAll();

        
        return $this->render('profile/livre/index.html.twig', [
            'livres' => $livres,
        ]);
    }
    
    
    #[Route('/livre/{id}', name: 'app_profile_livre_show', methods: ['GET'])]
    public function showLivre(Livre $livre): Response
    {
        return $this->render('profile/livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/emprunt', name: 'app_profile_emprunt_index', methods: ['GET'])]
    public function indexEmprunt(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('profile/emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }
}
