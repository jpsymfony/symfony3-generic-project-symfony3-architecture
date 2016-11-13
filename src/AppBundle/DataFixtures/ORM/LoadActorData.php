<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Actor;

class LoadActorData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $acteur1 = new Actor();
        $acteur1->setLastName('Reno');
        $acteur1->setFirstName('Jean');
        $acteur1->setSex('M');
        $acteur1->setBirthday(new \DateTime('1948/07/31'));
        $manager->persist($acteur1);

        $acteur2 = new Actor();
        $acteur2->setLastName('Deneuve');
        $acteur2->setFirstName('Catherine');
        $acteur2->setSex('F');
        $acteur2->setBirthday(new \DateTime('1943-10-22'));
        $manager->persist($acteur2);

        $acteur3 = new Actor();
        $acteur3->setLastName('Dujardin');
        $acteur3->setFirstName('Jean');
        $acteur3->setSex('M');
        $acteur3->setBirthday(new \DateTime('1972-06-19'));
        $manager->persist($acteur3);

        $acteur4 = new Actor();
        $acteur4->setLastName('Portman');
        $acteur4->setFirstName('Natalie');
        $acteur4->setSex('F');
        $acteur4->setBirthday(new \DateTime('1981-05-09'));
        $manager->persist($acteur4);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
