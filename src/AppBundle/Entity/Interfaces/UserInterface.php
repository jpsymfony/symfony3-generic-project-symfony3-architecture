<?php

namespace AppBundle\Entity\Interfaces;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface as SecurityUserInterface;

interface UserInterface extends SecurityUserInterface
{
    public function encodePassword(PasswordEncoderInterface $encoder);

    public function getPlainPassword();
    public function setPlainPassword($plainPassword);

    public function getConfirmationToken();
    public function setConfirmationToken($confirmationToken);

    public function getIsAlreadyRequested();
    public function setIsAlreadyRequested($isAlreadyRequested);

    public function setRoles(array $roles);

    public function isCgvRead();
    public function setCgvRead($cgvRead);

    public function getIsActive();
    public function setIsActive($isActive);

    public function getEmail();
    public function setEmail($email);

    public function getLastConnexion();
    public function setLastConnexion(\DateTime $lastConnexion);
} 
