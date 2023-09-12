<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private $faker;
    private $hasher;
    private $manager;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = FakerFactory::create('fr_FR');
        $this->hasher = $hasher;
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager): void
    {

        $this->manager = $manager;
        $this->loadGenres();
        $this->loadAuteurs();
        $this->loadLivres();
        $this->loadEmprunteurs();
        $this->loadEmprunts();
    }

    public function loadLivres()
    {
        $repoAuteur = $this->manager->getRepository(Auteur::class);
        $auteurs = $repoAuteur->findAll();
        $auteur1 = $repoAuteur->find(1);
        $auteur2 = $repoAuteur->find(2);
        $auteur3 = $repoAuteur->find(3);
        $auteur4 = $repoAuteur->find(4);

        $repoGenres = $this->manager->getRepository(Genre::class);
        $genres = $repoGenres->findAll();

        $genre1 = $repoGenres->find(1);
        $genre2 = $repoGenres->find(2);
        $genre3 = $repoGenres->find(3);
        $genre4 = $repoGenres->find(4);

        $datas = [
            [
                'titre' => 'Moi, moche et méchant',
                'anneeEdition' => 1990,
                'nombrePage' => 100,
                'codeIsbn' => 9785786930024,
                'genres' => [$genre1],
                'auteur' => $auteur1,
            ],
            [
                'titre' => 'Arsène lupin',
                'anneeEdition' => 2000,
                'nombrePage' => 150,
                'codeIsbn' => 9783817260935,
                'genres' => [$genre2, $genre3],
                'auteur' => $auteur2,
            ],
            [
                'titre' => 'Starfield',
                'anneeEdition' => 2020,
                'nombrePage' => 200,
                'codeIsbn' => 9782020493727,
                'genres' => [$genre3],
                'auteur' => $auteur3,
            ],
            [
                'titre' => 'Quem audis satis belle',
                'anneeEdition' => 2013,
                'nombrePage' => 250,
                'codeIsbn' => 9794059561353,
                'genres' => [$genre4],
                'auteur' => $auteur4,
            ],
        ];

        // données statique 

        foreach ($datas as $data) {
            $livre = new Livre();
            $livre->setTitre($data['titre']);
            $livre->setAnneeEdition($data['anneeEdition']);
            $livre->setNombrePage($data['nombrePage']);
            $livre->setCodeIsbn($data['codeIsbn']);

            foreach ($data['genres'] as $genre) {
                $livre->addGenre($genre);
            }


            $livre->setAuteur($data['auteur']);

            $this->manager->persist($livre);
        }

        $this->manager->flush();

        // données dynamique

        for ($i = 0; $i < 1000; $i++) {
            $livre = new Livre();
            $words = random_int(1, 2);
            $livre->setTitre($this->faker->sentence($words));
            $livre->setAnneeEdition($this->faker->numberBetween(1970, 2000));
            $livre->setNombrePage($this->faker->numberBetween(50, 400));
            $livre->setCodeIsbn($this->faker->optional(0.5)->isbn13());

            $countG = random_int(1, 2);

            $listGenre = $this->faker->randomElements($genres, $countG);
            

            
            foreach ( $listGenre as $genre ) {
                $livre->addGenre($genre);
            }


            $auteur = $this->faker->randomElement($auteurs);

            $livre->setAuteur($auteur);

            $this->manager->persist($livre);
        }

        $this->manager->flush();
    }

    public function loadAuteurs()
    {
        $datas = [
            [
                'nom' => 'Sebastien',
                'prenom' => 'Bar',
            ],
            [
                'nom' => 'Daishi',
                'prenom' => 'Baz',
            ],
            [
                'nom' => 'Foo',
                'prenom' => 'Alice',
            ],
        ];

        // données statique 

        foreach ($datas as $data) {
            $auteur = new Auteur();
            $auteur->setNom($data['nom']);
            $auteur->setPrenom($data['prenom']);

            $this->manager->persist($auteur);
        }

        $this->manager->flush();

        // données dynamique

        for ($i = 0; $i < 500; $i++) {
            $project = new Auteur();
            $project->setNom($this->faker->firstName());
            $project->setPrenom($this->faker->lastName());

            $this->manager->persist($project);
        }

        $this->manager->flush();
    }



    public function loadEmprunts()
    {
        $repoLivres = $this->manager->getRepository(Livre::class);
        $livres = $repoLivres->findAll();
        $livre1 = $repoLivres->find(1);
        $livre2 = $repoLivres->find(2);
        $livre3 = $repoLivres->find(3);

        $repoEmprunteur = $this->manager->getRepository(Emprunteur::class);
        $emprunteurs = $repoEmprunteur->findAll();
        $emprunteur1 = $repoEmprunteur->find(1);
        $emprunteur2 = $repoEmprunteur->find(2);
        $emprunteur3 = $repoEmprunteur->find(3);


        $datas = [
            [
                'dateEmprunt' => new DateTime('2022-01-01'),
                'dateRetour' => new DateTime('2022-12-31'),
                'livre' => $livre1,
                'emprunteur' => $emprunteur1,
            ],
            [
                'dateEmprunt' => new DateTime('2022-01-01'),
                'dateRetour' => new DateTime('2022-12-31'),
                'livre' => $livre2,
                'emprunteur' => $emprunteur2,
            ],
            [
                'dateEmprunt' => new DateTime('2022-01-01'),
                'dateRetour' => null,
                'livre' => $livre3,
                'emprunteur' => $emprunteur3,
            ],
        ];

        // données statique 

        foreach ($datas as $data) {
            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt($data['dateEmprunt']);
            $emprunt->setDateRetour($data['dateRetour']);
            $emprunt->setLivre($data['livre']);
            $emprunt->setEmprunteur($data['emprunteur']);

            $this->manager->persist($emprunt);
        }

        $this->manager->flush();

        // données dynamique

        for ($i = 0; $i < 200; $i++) {

            $randomLivre = $this->faker->unique()->randomElement($livres);
            $randomEmprunteur = $this->faker->randomElement($emprunteurs);

            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt($this->faker->dateTimeBetween('-1 year', '- 1months'));
            $emprunt->setDateRetour($this->faker->optional(0.8)->dateTimeBetween('-1 year', 'now'));
            $emprunt->setLivre($randomLivre);
            $emprunt->setEmprunteur($randomEmprunteur);

            $this->manager->persist($emprunt);
        }

        $this->manager->flush();
    }

    public function loadGenres()
    {
        // données statique
        $datas = [
            [
                'nom' => 'Poésie',
                'description' => null,

            ],
            [
                'nom' => 'Nouvelle',
                'description' => null,
            ],
            [
                'nom' => 'Roman historique',
                'description' => null,
            ],
            [
                'nom' => 'Roman d\'amour',
                'description' => null,
            ],
            [
                'nom' => 'Roman d\'aventure',
                'description' => null,
            ],
            [
                'nom' => 'Science-fiction',
                'description' => null,
            ],
            [
                'nom' => 'Fantasy',
                'description' => null,
            ],
            [
                'nom' => 'Biographie',
                'description' => null,
            ],
            [
                'nom' => 'Conte',
                'description' => null,
            ],
            [
                'nom' => 'Témoignage',
                'description' => null,
            ],
            [
                'nom' => 'Théatre',
                'description' => null,
            ],
            [
                'nom' => 'Essai',
                'description' => null,
            ],
            [
                'nom' => 'Journal intime',
                'description' => null,
            ],
        ];
        foreach ($datas as $data) {
            $genre = new Genre();
            $genre->setNom($data['nom']);
            $genre->setDescription($data['description']);
            $this->manager->persist($genre);
        }
        $this->manager->flush();
    }

    public function loadEmprunteurs(): void
    {
        // Données statiques
        $datas = [
            [
                'email' => 'foo@example.com',
                'password' => '123',
                'roles' => ['ROLE_USER'],
                'nom' => 'Foo',
                'prenom' => 'Foo',
                'actif' => true,
                'tel' => '0123456789',
            ],
            [
                'email' => 'bar@example.com',
                'password' => '123',
                'roles' => ['ROLE_USER'],
                'nom' => 'Baz',
                'prenom' => 'Baz',
                'actif' => false,
                'tel' => '0123456789',
            ],
            [
                'email' => 'baz@example.com',
                'password' => '123',
                'roles' => ['ROLE_USER'],
                'nom' => 'Baz',
                'prenom' => 'Baz',
                'actif' => true,
                'tel' => '0123456789',
            ],
        ];

        foreach ($datas as $data) {

            $user = new User();
            $user->setEmail($data['email']);
            $password = $this->hasher->hashPassword($user, $data['password']);
            $user->setPassword($password);
            $user->setRoles($data['roles']);
            $user->setActif($data['actif']);

            $this->manager->persist($user);

            $emprunteur = new Emprunteur();
            $emprunteur->setNom($data['nom']);
            $emprunteur->setPrenom($data['prenom']);
            $emprunteur->setTel($data['tel']);
            $emprunteur->setUser($user);

            $this->manager->persist($emprunteur);
        }


        $this->manager->flush();

        // données dynamiques

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail($this->faker->unique()->safeEmail());
            $password = $this->hasher->hashPassword($user, $this->faker->password());
            $user->setPassword($password);
            $user->setActif($this->faker->boolean(70));
            $user->setRoles(['ROLE_USER']);

            $dateCreation = $this->faker->dateTimeBetween('2020-01-01', '2023-12-31');
            $dateMiseAJour = $this->faker->dateTimeBetween($dateCreation, '2023-12-31');

            $emprunteur = new Emprunteur();
            $emprunteur->setPrenom($this->faker->firstName());
            $emprunteur->setNom($this->faker->lastName());
            $emprunteur->setTel($this->faker->phoneNumber());
            $emprunteur->setCreatedAt($dateCreation);
            $emprunteur->setUpdatedAt($dateMiseAJour);
            $emprunteur->setUser($user);



            $this->manager->persist($user);
        }
        $this->manager->flush();
    }
}
