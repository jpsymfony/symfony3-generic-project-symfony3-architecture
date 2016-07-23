<?php

namespace App\UserBundle\Entity\Password;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RequestPassword
{
    /**
     *
     * @var UserInterface
     */
    private $user;

    /**
     * @Assert\NotBlank
     */
    private $identifier;

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    function getUser()
    {
        return $this->user;
    }

    function setUser(UserInterface $user)
    {
        $this->user = $user;
    }
}
