<?php

namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/test')]
class TestController extends AbstractController
{
    #[Route('/user', name: 'app_test_user')]
    public function user(ManagerRegistry $doctrine): Response
    {
        $title = 'Test des Users';
        $em = $doctrine->getManager();
        $repository = $em->getRepository(User::class);

        $users = $repository->findAll();
        $user1 = $repository->find(1);

        $foo = $repository->findOneBy([
            'email' => 'foo@example.com',
        ]);

        $roleList = $repository->findByUsersRoleUser();
        $userInactifs = $repository->findByUsersInactif();

        return $this->render('test/user.html.twig', [
            'title' => $title,
            'users' => $users,
            'user1' => $user1,
            'foo' => $foo,
            'roleList' => $roleList, 
            'userInactifs' => $userInactifs,
        ]);
    }

    #[Route('/livre', name: 'app_test_livre')]
    public function livre(ManagerRegistry $doctrine): Response
    {
        $title = 'Test sur les Livres';
        
        $em = $doctrine->getManager();

        $genreRepository = $em->getRepository(Genre::class);
        $genre6 = $genreRepository->find(6);
        
        $repository = $em->getRepository(Livre::class);
        

        $auteurRepository = $em->getRepository(Auteur::class);
        $auteur2 = $auteurRepository->find(2);


        $nLivre = new Livre;
        $nLivre->setTitre('Totum autem id externum');
        $nLivre->setAnneeEdition(2020);
        $nLivre->setNombrePage(300);
        $nLivre->setCodeIsbn(9790412882714);
        $nLivre->setAuteur($auteur2);
        $nLivre->addGenre($genre6);
        $em->persist($nLivre);

        $livre2 = $repository->find(2);
        $genre5 = $genreRepository->find(5);

        $livre2->setTitre('Aperiendum est agitur');
        $livre2->addGenre($genre5);
        $em->flush();

        $livre123 = $repository->find(123);

        // if ($livre123) {
        //     $em->remove($livre123);
        //     $em->flush();
        // }

        $livreOrders = $repository->findByAlphabetiqueOrder();
        $livre1 = $repository->find(1);

        $livreKeywords = $repository->findByKeywordLorem('lorem');
        $genreKeywords = $repository->findByGenreKeyword();
        $livreAuteurs = $repository->findByAuteurId();

        return $this->render('test/livre.html.twig', [
            'title' => $title,
            'livre1' => $livre1,
            'livreOrders' => $livreOrders,
            'livreKeywords' => $livreKeywords,
            'genreKeywords' => $genreKeywords,
            'livreAuteurs' => $livreAuteurs,
        ]);
    }
    
    #[Route('/emprunteur', name: 'app_test_emprunteur')]
    public function emprunteur(ManagerRegistry $doctrine): Response
    {
        $title = 'Test sur les Emprunteurs';

        $em = $doctrine->getManager();
        $repository = $em->getRepository(Emprunteur::class);

        $emprunteurs = $repository->findByEmprunteur();
        $emprunteur3 = $repository->find(3);
        $emprunteurFoos = $repository->findByEmprunteurFoo();
        $emprunteurTels = $repository->findByEmprunteurTel();

        $orderDateCreate = $repository->findByDate();

        $repoUser = $em->getRepository(User::class);
        $user3 = $repoUser->find(3);


        return $this->render('test/emprunteur.html.twig', [
            'title' => $title,
            'emprunteurs' => $emprunteurs,
            'emprunteur3' => $emprunteur3,
            'user3' => $user3,
            'emprunteurFoos' => $emprunteurFoos,
            'emprunteurTels' => $emprunteurTels,
            'orderDates' => $orderDateCreate,
        ]);
    }

    #[Route('/emprunt', name: 'app_test_emprunt')]
    public function emprunt(ManagerRegistry $doctrine): Response
    {
        $title = 'Test sur les Emprunts';

        $em = $doctrine->getManager();
        $repository = $em->getRepository(Emprunt::class);



        return $this->render('test/emprunt.html.twig', [
            'title' => $title,

        ]);
    }
}
