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


        // $nLivre = new Livre;
        // $nLivre->setTitre('Totum autem id externum');
        // $nLivre->setAnneeEdition(2020);
        // $nLivre->setNombrePage(300);
        // $nLivre->setCodeIsbn(9790412882714);
        // $nLivre->setAuteur($auteur2);
        // $nLivre->addGenre($genre6);
        // $em->persist($nLivre);

        // $livre2 = $repository->find(2);
        // $genre5 = $genreRepository->find(5);

        // $livre2->setTitre('Aperiendum est agitur');
        // $genres = $livre2->getGenres();
        // $genreSupprimer = $genres[0];
        // $livre2->removeGenre($genreSupprimer);
        // $livre2->addGenre($genre5);
        // $em->flush();

        // $livre123 = $repository->find(123);

        // if ($livre123) {
        //     // supression de l'objet
        //     $em->remove($livre123);
        //     $em->flush();
        // }

        $livreOrders = $repository->findByAlphabetiqueOrder();
        $livre1 = $repository->find(1);

        $livreKeywords = $repository->findByKeywordLorem('lorem');
        $genreKeywords = $repository->findByGenreKeyword();

        return $this->render('test/livre.html.twig', [
            'title' => $title,
            'livre1' => $livre1,
            'livreOrders' => $livreOrders,
            'livreKeywords' => $livreKeywords,
            'genreKeywords' => $genreKeywords
        ]);
    }

    // #[Route('/project', name: 'app_test_project')]
    // public function schoolYear(ManagerRegistry $doctrine): Response
    // {
    //     $em = $doctrine->getManager();
    //     $repository = $em->getRepository(Project::class);

    //     $project = new Project;
    //     $project->setName('Promo 11');
    //     $project->setDescription('Formation de la promo 11');
    //     $project->setClientName('Alexandre');
    //     $project->setStartDate(new DateTime('2023-01-01'));
    //     $project->setCheckPointDate(new DateTime('2023-06-01'));
    //     $project->setDeliveryDate(new DateTime('2023-07-01'));
    //     $em->persist($project);

    //     try {
    //         $em->flush();
    //     } catch (Exception $e) {
    //         // géréer le message d'erreur
    //         dump($e->getMessage('Erreur'));
    //     };

    //     $projects = $repository->findAll();
    //     $project = $repository->find(1);
    //     $project14 = $repository->find(14);

    //     if ($project14) {
    //         // supression de l'objet
    //         $em->remove($project14);
    //         $em->flush();
    //     }

    //     $title = 'Test des school years';

    //     return $this->render('test/project.html.twig', [
    //         'title' => $title,
    //         'project' => $project,
    //         'projects' => $projects,
    //     ]);
    // }
}
