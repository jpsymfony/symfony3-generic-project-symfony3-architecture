<?php

namespace App\UserBundle\Entity;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface as SecurityUserInterface;

interface UserInterface extends SecurityUserInterface
{
    public function encodePassword(PasswordEncoderInterface $encoder);

    public function setPlainPassword($plainPassword);

    public function setConfirmationToken($confirmationToken);

    public function setIsAlreadyRequested($isAlreadyRequested);

    public function setRoles(array $roles);

    public function setCgvRead($cgvRead);

    public function setLastConnexion(\DateTime $lastConnexion);
} 
