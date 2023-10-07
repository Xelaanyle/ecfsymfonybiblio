<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Emprunt;
use App\Form\EmprunteurProfileType;
use App\Form\UserPasswordType;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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

        $emprunteur = $emprunt->getEmprunteur();
        /** @var User */
        if ($emprunteur && $emprunteur->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Accès refusé.');
        }

        return $this->render('profile/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }

    #[Route('/emprunteur/{id}', name: 'app_profile_emprunteur_show', methods: ['GET'])]
    public function showEmprunteur(User $user): Response
    {

        $this->filterSessionUser($user);

        return $this->render('profile/emprunteur_show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_profile_emprunteur_edit', methods: ['GET', 'POST'])]
    public function editEmprunteur(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $this->filterSessionUser($user);


        $form = $this->createForm(EmprunteurProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_emprunteur_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/emprunteur_edit.html.twig', [
            'emprunteur' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/password', name: 'app_profile_emprunteur_password', methods: ['GET', 'POST'])]
    public function password(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_emprunteur_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/emprunteur_edit.html.twig', [
            'emprunteur' => $user,
            'form' => $form,
        ]);
    }

    private function filterSessionUser(User $user)
    {
        $sessionUser = $this->getUser($user);

        if ($sessionUser != $user) {
            throw new AccessDeniedException();
        }
    }
}
