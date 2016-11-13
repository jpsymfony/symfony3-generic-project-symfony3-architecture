<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\HashTag;

class LoadHashTagData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 7; $i++) {
            $hashTag = new HashTag();
            $hashTag->setName('#HashTag ' . $i);
            $manager->persist($hashTag);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
