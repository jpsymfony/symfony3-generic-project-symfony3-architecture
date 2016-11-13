<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cat1 = new Category('Comédie');
        $cat2 = new Category('Science-fiction');
        $cat3 = new Category('Policier');
        $cat4 = new Category('Drame');

        $manager->persist($cat1);
        $manager->persist($cat2);
        $manager->persist($cat3);
        $manager->persist($cat4);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
