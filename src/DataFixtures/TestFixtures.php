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

// $repotags = $this->manager->getRepository(Tag::class);
// $ltags = $repotags->finAll();
// $this->faker->randomElement($ltags);

// $htmlTag = $repository->find(1);
// $cssTag = $repository->find(2);
// $jslTag = $repository->find(3);

// éléments de code réutiliser dans vos boucles
// $html = $tags[0];
// $html->getName();
// $tags[0]->getName();



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
        // $this->loadEmrprunts();
        // $this->loadEmprunteurs();
    }

    public function loadLivres()
    {


        $repoEmprunt = $this->manager->getRepository(Emprunt::class);
        $emprunts = $repoEmprunt->findAll();
        $emprunt1 = $repoEmprunt->find(1);
        $emprunt2 = $repoEmprunt->find(2);
        $emprunt3 = $repoEmprunt->find(3);

        $repoGenres = $this->manager->getRepository(Genre::class);
        $genres = $repoGenres->findAll();
        // $this->faker->randomElement($tags);

        // on récupère un tag a partir de son id
        $manga = $repoGenres->find(1);
        $policier = $repoGenres->find(2);
        $sf = $repoGenres->find(2);

        $datas = [
            [
                'titre' => 'Moi, moche et méchant',
                'anneeEdition' => 1990,
                'nombrePage' => 100,
                'codeIsbn' => null,
                'genres' => [$manga],
                // 'emprunt' => [$emprunt1],
                'auteur' => null,
            ],
            [
                'titre' => 'Arsène lupin',
                'anneeEdition' => 2000,
                'nombrePage' => 150,
                'codeIsbn' => null,
                'genres' => [$policier, $sf],
                // 'emprunt' => [$emprunt2],
                'auteur' => null,
            ],
            [
                'titre' => 'Starfield',
                'anneeEdition' => 2020,
                'nombrePage' => 300,
                'codeIsbn' => null,
                'genres' => [$sf],
                // 'emprunt' => [$emprunt3],
                'auteur' => null,
            ],
        ];

        // données statique 

        foreach ($datas as $data) {
            $livre = new Livre();
            $livre->setTitre($data['titre']);
            $livre->setAnneeEdition($data['anneeEdition']);
            $livre->setNombrePage($data['nombrePage']);
            $livre->setCodeIsbn($data['codeIsbn']);

            // foreach ($data['emprunt'] as $emprunt) {
            //     $livre->addEmprunt($emprunt);
            // }

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
            $livre->setCodeIsbn($this->faker->optional(0.5)->numberBetween(100, 100000));

            // on choisit le nombre de tags au hasard entre 1 et 4
            $genreCount = random_int(1, 3);
            // on choisit des tags au hasard depuis la liste complète
            $genreList = $this->faker->randomElements($genres, $genreCount);

            // on passe revue chaque tag de la short list
            foreach ($genreList as $genre) {
                // on associe un tag avec le projet
                $livre->addGenre($genre);
            }

            // foreach ($genreList as $emprunt) {
            //     // on associe un tag avec le projet
            //     $livre->addEmprunt($emprunt);
            // }

            $repoAuteur = $this->manager->getRepository(Auteur::class);
            $auteurs = $repoAuteur->findAll();
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



    // public function loadEmrprunts()
    // {
    //     $datas = [
    //         [
    //             'name' => 'Alan turing',
    //             'description' => null,
    //             'startDate' => new DateTime('2022-01-01'),
    //             'endDate' => new DateTime('2022-12-31'),
    //         ],
    //         [
    //             'name' => 'John Von Neuman',
    //             'description' => null,
    //             'startDate' => new DateTime('2022-01-01'),
    //             'endDate' => new DateTime('2022-12-31'),
    //         ],
    //         [
    //             'name' => 'Brendan Eich',
    //             'description' => null,
    //             'startDate' => new DateTime('2022-01-01'),
    //             'endDate' => new DateTime('2022-12-31'),
    //         ],
    //     ];

    //     // données statique 

    //     foreach ($datas as $data) {
    //         $schoolyear = new Emprunt();
    //         $schoolyear->setName($data['name']);
    //         $schoolyear->setDescription($data['description']);
    //         $schoolyear->setStartDate($data['startDate']);
    //         $schoolyear->setEndDate($data['endDate']);

    //         $this->manager->persist($schoolyear);
    //     }

    //     $this->manager->flush();

    //     // données dynamique

    //     for ($i = 0; $i < 10; $i++) {
    //         $schoolyear = new Emprunt();
    //         $words = random_int(2, 4);
    //         $schoolyear->setName($this->faker->unique()->sentence($words));
    //         $words = random_int(2, 10);
    //         $schoolyear->setDescription($this->faker->optional(0.7)->sentence($words));

    //         $startDate = $this->faker->dateTimeBetween('-1 year', '- 6months');
    //         $schoolyear->setStartDate($startDate);

    //         $endDate = $this->faker->dateTimeBetween('- 3 months', 'now');
    //         $schoolyear->setEndDate($endDate);

    //         $this->manager->persist($schoolyear);
    //     }
    //     $this->manager->flush();
    // }

    public function loadGenres()
    {
        // $repository = $this->manager->getRepository(Livre::class);
        // $livres = $repository->findAll();
        // // $this->faker->randomElement($livres);

        // // on récupère un tag a partir de son id
        // $livre1 = $repository->find(1);
        // $livre2 = $repository->find(2);
        // $livre3 = $repository->find(3);


        // données statique
        $datas = [
            [
                'nom' => 'Manga',
                'description' => 'Livre d\'animation',
                // 'livres' => [$livre1],
            ],
            [
                'nom' => 'Policer',
                'description' => 'Thriller policier',
                // 'livres' => [$livre2],
            ],
            [
                'nom' => 'Science fiction',
                'description' => 'Livre imaginaire',
                // 'livres' => [$livre3],
            ],
        ];
        foreach ($datas as $data) {
            $genre = new Genre();
            $genre->setNom($data['nom']);
            $genre->setDescription($data['description']);

            // foreach ($data['livres'] as $livre) {
            //     $genre->addLivre($livre);
            // }

            $this->manager->persist($genre);
        }
        $this->manager->flush();

        //données dynamique
        for ($i = 0; $i < 10; $i++) {
            $genre = new Genre();
            $words = random_int(1, 3);
            $genre->setNom($this->faker->unique()->sentence($words));
            $words = random_int(8, 15);
            $genre->setDescription($this->faker->sentence($words));


            $livresCount = random_int(1, 2);
            // on choisit des tags au hasard depuis la liste complète
            // $shortList = $this->faker->randomElements($livres, $livresCount);

            // on passe revue chaque tag de la short list
            // foreach ($shortList as $livre) {
            //     // on associe un tag avec le projet
            //     $genre->addLivre($livre);
            // }

            $this->manager->persist($genre);
        }
        $this->manager->flush();
    }

    // public function loadEmprunteurs(): void
    // {
    //     $repoSchoolYear = $this->manager->getRepository(SchoolYear::class);
    //     $schoolYears = $repoSchoolYear->findAll();
    //     $repoTag = $this->manager->getRepository(Tag::class);
    //     $tags = $repoTag->findAll();
    //     $repoProject = $this->manager->getRepository(Project::class);
    //     $projects = $repoProject->findAll();

    //     $siteVitrine = $repoProject->find(1);
    //     $wordPress = $repoProject->find(2);
    //     $apiRest = $repoProject->find(3);

    //     $htmlTag = $repoTag->find(1);
    //     $cssTag = $repoTag->find(2);
    //     $jsTag = $repoTag->find(3);

    //     // Données statiques
    //     $datas = [
    //         [
    //             'email' => 'alice@example.com',
    //             'password' => '123',
    //             'roles' => ['ROLE_USER'],
    //             'firstName' => 'Foo',
    //             'lastName' => 'Example',
    //             'schoolYear' => $schoolYears[0],
    //             'projects' => [$siteVitrine],
    //             'tags' => [$htmlTag],
    //         ],
    //         [
    //             'email' => 'bob@example.com',
    //             'password' => '123',
    //             'roles' => ['ROLE_USER'],
    //             'firstName' => 'Bar',
    //             'lastName' => 'Example',
    //             'schoolYear' => $schoolYears[1],
    //             'projects' => [$wordPress],
    //             'tags' => [$cssTag, $htmlTag],
    //         ],
    //         [
    //             'email' => 'charlie@example.com',
    //             'password' => '123',
    //             'roles' => ['ROLE_USER'],
    //             'firstName' => 'Baz',
    //             'lastName' => 'Example',
    //             'schoolYear' => $schoolYears[2],
    //             'projects' => [$apiRest],
    //             'tags' => [$jsTag],
    //         ],
    //     ];

    //     foreach ($datas as $data) {

    //         $user = new User();
    //         $user->setEmail($data['email']);
    //         $password = $this->hasher->hashPassword($user, $data['password']);
    //         $user->setPassword($password);
    //         $user->setRoles($data['roles']);
    //         // Persist sert a stocker l'user dans la base de donner
    //         $this->manager->persist($user);

    //         $student = new Emprunteur();
    //         $student->setFirstName($data['firstName']);
    //         $student->setLastName($data['lastName']);
    //         $student->setSchoolYear($data['schoolYear']);
    //         $student->setUser($user);

    //         // récupération du premier projet de la liste du student
    //         $project = $data['projects'][0];
    //         $student->addProject($project);


    //         foreach ($data['tags'] as $tag) {
    //             $student->addTag($tag);
    //         }
    //         // $tag = $data['tags'][0];
    //         // $student->addTag($tag);


    //         $this->manager->persist($student);
    //     }


    //     $this->manager->flush();

    //     // flush = push du user dans la base de donner

    //     // // données dynamiques
    //     for ($i = 0; $i < 50; $i++) {
    //         $user = new User();
    //         $user->setEmail($this->faker->unique()->safeEmail());
    //         $password = $this->hasher->hashPassword($user, $data['password']);
    //         $user->setPassword($password);
    //         $user->setRoles(['ROLE_USER']);

    //         $student = new Student();
    //         $student->setFirstname($this->faker->firstName());
    //         $student->setLastname($this->faker->lastName());

    //         $schoolYear = $this->faker->randomElement($schoolYears);
    //         $student->setSchoolYear($schoolYear);

    //         $project = $this->faker->randomElement($projects);
    //         $student->addProject($project);

    //         $tagsCount = random_int(1, 4);
    //         $shortList = $this->faker->randomElements($tags, $tagsCount);
    //         foreach ($shortList as $tag) {
    //             $student->addTag($tag);
    //         }

    //         $student->setUser($user);



    //         $this->manager->persist($user);
    //     }
    //     $this->manager->flush();
    // }
}
