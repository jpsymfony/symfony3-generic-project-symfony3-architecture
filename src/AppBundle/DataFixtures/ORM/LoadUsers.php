<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        $factory = $this->container->get('security.encoder_factory');

        $user = new User();
        $user->setUsername('visitor1');
        $user->setEmail('visitor1@symfony.com');
        $user->setPlainPassword('visitor123');
        $user->setRoles(['ROLE_VISITOR']);
        $user->setCgvRead(false);
        $user->setIsActive(true);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('visitor2');
        $user->setEmail('visitor2@symfony.com');
        $user->setPlainPassword('visitor123');
        $user->setRoles(['ROLE_VISITOR']);
        $user->setCgvRead(true);
        $user->setIsActive(true);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@symfony.com');
        $user->setPlainPassword('admin123');
        $user->setIsActive(true);
        $user->setRoles(['ROLE_ADMIN']);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('editor1');
        $user->setEmail('editor1@symfony.com');
        $user->setPlainPassword('editor123');
        $user->setIsActive(true);
        $user->setRoles(['ROLE_EDITOR']);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('editor2');
        $user->setEmail('editor2@symfony.com');
        $user->setPlainPassword('editor123');
        $user->setIsActive(true);
        $user->setRoles(['ROLE_EDITOR']);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $manager->persist($user);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 1;
    }
}
