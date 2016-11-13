<?php

namespace AppBundle\Entity\Password;

use Symfony\Component\Validator\Constraints as Assert;

class ResetPassword
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8)
     */
    private $password;
    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
