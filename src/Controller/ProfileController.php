<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\User;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Repository\EmpruntRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/emprunt', name: 'app_profile_index', methods: ['GET'])]
    public function indexEmprunt(EmpruntRepository $empruntRepository): Response
    {

        // Si l'utilisateur est administrateur, il peut voir tous les emprunts
        if ($this->isGranted('ROLE_ADMIN')) {

            $emprunts = $empruntRepository->findAll();

        } else {
            
            /** @var User */
            $user = $this->getUser();
            $emprunteurId = $user->getEmprunteur()->getId();
            $emprunts = $empruntRepository->findBy(['emprunteur' => $emprunteurId]);
        }


        return $this->render('profile/index.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }

    #[Route('/emprunt/{id}', name: 'app_profile_show', methods: ['GET'])]
    public function show(Emprunt $emprunt): Response
    {
        return $this->render('profile/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }

    private function filterSessionUser(User $user)
    {
        $sessionUser = $this->getUser();

        if ($sessionUser != $user) {
            throw new AccessDeniedException();
        }
    }
}
