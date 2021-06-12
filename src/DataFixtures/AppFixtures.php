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
        $this->loadAdmin($manager, 4);
        $emprunteurs = $this->loadEmprunteurs($manager, 3);
        $auteurs = $this->loadAuteurs($manager, 5);
        $livres = $this->loadLivres($manager, 3);
        
   
        $manager->flush();
    }

    public function loadAdmin(ObjectManager $manager, int $count)
    {
        $user = new User();
        $user->setEmail('admin@exmaple.com');
        $password = $this->encoder->encodePassword($user,'123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
       
    }

    public function loadEmprunteurs(ObjectManager $manager, int $count)
    {
        $emprunteurs = [];     

        $user = new User();
        $user->setEmail('foo.foo@exmaple.com');
        $password = $this->encoder->encodePassword($user,'123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_EMPRUNTEUR']);

        $manager->persist($user);

        $emprunteur = new Emprunteur();
        $emprunteur->setNom('Foo');
        $emprunteur->setPrenom('Foo');
        $emprunteur->setTel('123456789');
        $emprunteur->setActif(true);
        $emprunteur->setDateCreation(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00'));
        $emprunteur->setUser($user);

        $manager->persist($emprunteur);
        $emprunteurs[] = $emprunteur;
        
        $user = new User();
        $user->setEmail('bar.bar@exmaple.com');
        $password = $this->encoder->encodePassword($user,'123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_EMPRUNTEUR']);

        $manager->persist($user);

        $emprunteur = new Emprunteur();
        $emprunteur->setNom('Bar');
        $emprunteur->setPrenom('Bar');
        $emprunteur->setTel('987654321');
        $emprunteur->setActif(false);
        $emprunteur->setDateCreation(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-02-01 11:00:00'));
        $emprunteur->setDateModification(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-05-01 12:00:00'));
        $emprunteur->setUser($user);

        $manager->persist($emprunteur);
        $emprunteurs[] = $emprunteur;
        
        $user = new User();
        $user->setEmail('baz.baz@exmaple.com');
        $password = $this->encoder->encodePassword($user,'123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_EMPRUNTEUR']);

        $manager->persist($user);

        $emprunteur = new Emprunteur();
        $emprunteur->setNom('Baz');
        $emprunteur->setPrenom('Baz');
        $emprunteur->setTel('192873645');
        $emprunteur->setActif(true);
        $emprunteur->setDateCreation(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-03-01 12:00:00'));
        $emprunteur->setUser($user);

        $manager->persist($emprunteur);
        $emprunteurs[] = $emprunteur;       


        for ($i = 0; $i < $count; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email());
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);
            $user->setRoles(['ROLE_EMPRUNTEUR']);

            $manager->persist($user);
            
            $emprunteur = new Emprunteur();
            $emprunteur->setNom($this->faker->firstname());
            $emprunteur->setPrenom($this->faker->lastname());
            $emprunteur->setTel($this->faker->phoneNumber());
            $emprunteur->setActif($this->faker->boolean());
            $emprunteur->setDateCreation($this->faker->dateTimeThisDecade());
            $emprunteur->setUser($user);

            $manager->persist($emprunteur);
            $emprunteurs[] = $emprunteur;
        }

        return $emprunteurs;
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
            $auteur= new Auteur();
            $auteur->setNom($this->faker->firstname());
            $auteur->setPrenom($this->faker->lastname());
            $manager->persist($auteur);

            $livre = new Livre();
            $livre->setTitre($titres[$i]);
            $livre->setAnneeEdition($annees[$i]);
            $livre->setNbrPages($pages[$i]);
            $livre->setCodeIsbn($isbns[$i]);
            $livre->setAuteur($auteur);

            $manager->persist($livre);
            $livres[] = $livre;
        }

        for($i=0; $i < $count; $i++){
            $auteur= new Auteur();
            $auteur->setNom($this->faker->firstname());
            $auteur->setPrenom($this->faker->lastname());
            $manager->persist($auteur);

            $livre = new Livre();
            $livre->setTitre($this->faker->sentence(4));
            $livre->setAnneeEdition($this->faker->year());
            $livre->setNbrPages($this->faker->numberBetween(50, 1500));
            $livre->setCodeIsbn($this->faker->isbn13());
            $livre->setAuteur($auteur);

            $manager->persist($livre);
            $livres[] = $livre;
        }
        return $livres;
    }


}

