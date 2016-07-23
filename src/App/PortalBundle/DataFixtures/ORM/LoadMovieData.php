<?php

namespace App\PortalBundle\DataFixtures\ORM;

use App\PortalBundle\Entity\HashTag;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\PortalBundle\Entity\Movie;

class LoadMovieData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category1 = $manager->getRepository("AppPortalBundle:Category")->findOneByTitle('Comédie');
        $category3 = $manager->getRepository("AppPortalBundle:Category")->findOneByTitle('Policier');
        $category4 = $manager->getRepository("AppPortalBundle:Category")->findOneByTitle('Drame');

        $actor1 = $manager->getRepository("AppPortalBundle:Actor")->findOneByLastName("Reno");
        $actor2 = $manager->getRepository("AppPortalBundle:Actor")->findOneByLastName("Deneuve");
        $actor3 = $manager->getRepository("AppPortalBundle:Actor")->findOneByLastName("Dujardin");
        $actor4 = $manager->getRepository("AppPortalBundle:Actor")->findOneByLastName("Portman");

        $hashTag1 = $manager->getRepository("AppPortalBundle:HashTag")->findOneByName("#HashTag 1");
        $hashTag2 = $manager->getRepository("AppPortalBundle:HashTag")->findOneByName("#HashTag 2");
        $hashTag3 = $manager->getRepository("AppPortalBundle:HashTag")->findOneByName("#HashTag 3");
        $hashTag4 = $manager->getRepository("AppPortalBundle:HashTag")->findOneByName("#HashTag 4");
        $hashTag5 = $manager->getRepository("AppPortalBundle:HashTag")->findOneByName("#HashTag 5");
        $hashTag6 = $manager->getRepository("AppPortalBundle:HashTag")->findOneByName("#HashTag 6");

        $author1 = $manager->getRepository("AppUserBundle:User")->findOneByEmail("editor1@symfony.com");
        $author2 = $manager->getRepository("AppUserBundle:User")->findOneByEmail("editor2@symfony.com");

        $movie1 = new Movie();
        $movie1->setTitle('Léon');
        $movie1->setDescription('Léon (Jean Reno) est un tueur à gages vivant seul au quartier de la Little Italy à New York. La plupart de ses contrats viennent d\'un mafieux nommé Tony (Danny Aiello) qui opère depuis son restaurant le « Supreme Macaroni ». Léon passe son temps libre à faire des exercices physiques, prendre soin de sa plante d\'intérieur (une Aglaonema) qu\'il décrit comme sa « meilleure amie » et regarder des comédies musicales de Gene Kelly.');
        $movie1->setCategory($category3);
        $movie1->addActor($actor1);
        $movie1->addActor($actor4);
        $movie1->addHashTag($hashTag1);
        $movie1->addHashTag($hashTag2);
        $movie1->setAuthor($author1);
        $movie1->setReleasedAt(new \DateTime('2000-07-25'));
        $manager->persist($movie1);

        $movie2 = new Movie();
        $movie2->setTitle('Brice de Nice');
        $movie2->setDescription('Brice Agostini mène la belle vie à Nice. Il est fan du film Point Break et en particulier de son personnage principal Bodhi joué par Patrick Swayze. Il attend chaque jour qu\'une vague géante déferle sur les rives de Nice, comme cela a eu lieu une fois, en 1979.');
        $movie2->setCategory($category1);
        $movie2->addActor($actor3);
        $movie2->addHashTag($hashTag3);
        $movie2->addHashTag($hashTag4);
        $movie2->setAuthor($author1);
        $movie2->setReleasedAt(new \DateTime('1998-12-15'));
        $manager->persist($movie2);

        $movie3 = new Movie();
        $movie3->setTitle('Le Dernier Métro');
        $movie3->setDescription('Depuis que la moitié Nord de la France a été envahie par les nazis, les parisiens passent leurs soirées dans les salles de spectacles, pour ne pas avoir froid. Marion Steiner ne pense qu\'aux répétitions de la pièce qui va être jouée dans son théâtre, le théâtre Montmartre, dont elle assure la direction à la place de son mari juif. Tout le monde pense que Lucas Steiner a fui la France. En réalité, il s\'est réfugié dans les sous-sols du théâtre. Chaque soir, Marion lui rend visite et commente avec lui le travail des comédiens, notamment celui du jeune premier de la troupe, Bernard Granger. Très vite, Lucas comprend, simplement en écoutant les répétitions depuis sa cachette, que sa femme est tombée amoureuse de Bernard Granger. Ce dernier, engagé dans la résistance, sera le seul de la troupe à aider Lucas lors d\'une perquisition de la gestapo. La pièce est un succès mais le théâtre connait de durs jours, du fait de la jalousie d\'un critique de théâtre antisémite et hargneux. Alors que la France est libérée par les alliés, Marion continue sa vie de comédienne, entre son mari, désormais réhabilité et acclamé, et Bernard.');
        $movie3->setCategory($category4);
        $movie3->addActor($actor2);
        $movie3->addHashTag($hashTag5);
        $movie3->addHashTag($hashTag6);
        $movie3->setAuthor($author2);
        $movie3->setReleasedAt(new \DateTime('2013-03-29'));
        $manager->persist($movie3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
