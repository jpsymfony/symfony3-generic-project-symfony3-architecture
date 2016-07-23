<?php

namespace App\UserBundle\Entity\Manager;

use App\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use App\UserBundle\Entity\UserInterface;

interface UserManagerInterface extends GenericManagerInterface
{
    /**
     * @param UserInterface $user
     *
     * @return void
     */
    public function createUser(UserInterface $user);

    /**
     * @param UserInterface $user
     * @param $newPassword
     * @return mixed
     */
    public function updateCredentials(UserInterface $user, $newPassword);

    /**
     * @param UserInterface $user
     * @param $plainPassword
     * @return mixed
     */
    public function isPasswordValid(UserInterface $user, $plainPassword);

    /**
     * @param $identifier
     * @return mixed
     */
    public function getUserByIdentifier($identifier);

    /**
     * @param $user
     * @return mixed
     */
    public function sendRequestPassword($user);

    /**
     * @param UserInterface $user
     * @param $token
     * @return mixed
     */
    public function updateConfirmationTokenUser(UserInterface $user, $token);

    /**
     * @param $token
     * @return mixed
     */
    public function getUserByConfirmationToken($token);

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function clearConfirmationTokenUser(UserInterface $user);

    /**
     * @param UserInterface $user
     * @param \Datetime $lastConnexion
     */
    public function setLastConnexion(UserInterface $user, \Datetime $lastConnexion);
} 
