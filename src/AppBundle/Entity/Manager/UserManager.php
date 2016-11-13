<?php

namespace AppBundle\Entity\Manager;

use AppBundle\Entity\Manager\Interfaces\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Jpsymfony\CoreBundle\Entity\Manager\AbstractGenericManager;
use AppBundle\AppEvents;
use AppBundle\Entity\Interfaces\UserInterface;
use AppBundle\Event\UserDataEvent;
use AppBundle\Repository\UserRepository;

class UserManager extends AbstractGenericManager implements UserManagerInterface
{
    /**
     * @var EncoderFactoryInterface $encoderFactory
     */
    protected $encoderFactory;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    protected $dispatcher;

    /**
     * @var UserPasswordEncoderInterface $encoder
     */
    protected $encoder;

    /**
     *
     * @var UserRepository $repository
     */
    protected $repository;

    /**
     * @param EncoderFactoryInterface       $encoderFactory
     * @param EventDispatcherInterface      $dispatcher
     * @param UserPasswordEncoderInterface  $encoder
     * @param UserRepository                $userRepository
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        EventDispatcherInterface $dispatcher,
        UserPasswordEncoderInterface $encoder,
        UserRepository $userRepository
    )
    {
        $this->encoderFactory = $encoderFactory;
        $this->dispatcher = $dispatcher;
        $this->encoder = $encoder;
        $this->repository = $userRepository;
    }

    /**
     * @inheritdoc
     */
    public function createUser(UserInterface $user)
    {
        $user->setCgvRead(false);
        $user->setRoles(['ROLE_VISITOR']);
        $user->encodePassword($this->encoderFactory->getEncoder($user));
        $this->save($user, true, true);

        $this->dispatcher->dispatch(
            AppEvents::NEW_ACCOUNT_CREATED, new UserDataEvent($user)
        );
    }

    /**
     * @inheritdoc
     */
    public function updateCredentials(UserInterface $user, $newPassword)
    {
        $user->setPlainPassword($newPassword);
        $user->encodePassword($this->encoderFactory->getEncoder($user));
        $this->save($user, false, true);
    }

    /**
     * @inheritdoc
     */
    public function isPasswordValid(UserInterface $user, $plainPassword)
    {
        return $this->encoder->isPasswordValid($user, $plainPassword);
    }

    /**
     * @inheritdoc
     */
    public function getUserByIdentifier($identifier)
    {
        return $this->repository->getUserByEmailOrUsername($identifier);
    }

    /**
     * @inheritdoc
     */
    public function sendRequestPassword($user)
    {
        $this->dispatcher->dispatch(
            AppEvents::NEW_PASSWORD_REQUESTED, new UserDataEvent($user)
        );
    }

    /**
     * @inheritdoc
     */
    public function updateConfirmationTokenUser(UserInterface $user, $token) {
        $user->setConfirmationToken($token);
        $user->setIsAlreadyRequested(true);
        $this->save($user, false, true);
    }

    /**
     * @inheritdoc
     */
    public function getUserByConfirmationToken($token)
    {
        return $this->repository->findOneByConfirmationToken($token);
    }

    /**
     * @inheritdoc
     */
    public function clearConfirmationTokenUser(UserInterface $user) {
        $user->setConfirmationToken(null);
        $user->setIsAlreadyRequested(false);
    }

    /**
     * @inheritdoc
     */
    public function setLastConnexion(UserInterface $user, \DateTime $lastConnexion)
    {
        $user->setLastConnexion($lastConnexion);
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'UserManager';
    }
}