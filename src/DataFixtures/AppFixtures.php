<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory as FakerFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = FakerFactory::create('fr_FR');
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager)
    {
        $this->loadAdmins($manager, 4);
        $auteurs = $this->loadAuteurs($manager, 5);
        $livres = $this->loadLivres($manager, 3);
   
        $manager->flush();
    }

    public function loadAdmins(ObjectManager $manager, int $count)
    {
        $users = [];

        $user = new User();
        $user->setEmail('admin@exmaple.com');
        $password = $this->encoder->encodePassword($user,'123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $users[]= $user;

        $emails = ['foo.foo@example.com', 'bar.bar@example.com', 'baz.baz@example.com'];

        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setEmail($emails[$i]);
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);
            $user->setRoles(['ROLE_EMPRUNTEUR']);

            $manager->persist($user);
            $users[]= $user;
        }      

        for ($i = 0; $i < $count; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email());
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);
            $user->setRoles(['ROLE_EMPRUNTEUR']);

            $manager->persist($user);
            $users[]= $user;
        }

        return $users;
    }

    public function loadAuteurs(ObjectManager $manager, int $count)
    {
        $auteurs = [];
        $noms = ['Auteur', 'Cartier', 'Lambert', 'Moitessier'];
        $prenoms =['Inconnu', 'Hugues', 'Armand', 'Thomas'];

        for ($i = 0; $i < 4; $i++) {
            $auteur= new Auteur();
            $auteur->setNom($noms[$i]);
            $auteur->setPrenom($prenoms[$i]);
            
            $manager->persist($auteur);

            $auteurs[] = $auteur;
        }
        
        for ($i = 0; $i < $count; $i++) {
            $auteur= new Auteur();
            $auteur->setNom($this->faker->firstname());
            $auteur->setPrenom($this->faker->lastname());
            
            $manager->persist($auteur);

            $auteurs[] = $auteur;
        }

        return $auteurs;
    }

    public function loadLivres(ObjectManager $manager, int $count)
    {
        $livres = [];

        $titres = ['Lorem ipsum dolor sit amet', 'Consectetur adipiscing elit', 'Mihi quidem Antiochum', 'Quem audis satis belle'];
        $annees = ['2010', '2011', '2012','2013'];
        $pages = [100, 150, 200, 250];
        $isbns = ['9785786930024', '9783817260935', '9782020493727', '9794059561353'];

        for($i=0; $i < 4; $i++){
            $livre = new Livre();
            $livre->setTitre($titres[$i]);
            $livre->setAnneeEdition($annees[$i]);
            $livre->setNbrPages($pages[$i]);
            $livre->setCodeIsbn($isbns[$i]);

            $manager->persist($livre);
            $livres[] = $livre;
        }

        
    }


}

