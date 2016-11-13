<?php

namespace AppBundle\Entity\Registration;

use Symfony\Component\Validator\Constraints as Assert;
use Jpsymfony\CoreBundle\Validator\Constraints as CoreAssert;
use AppBundle\Validator\Constraints as AppAssert;
use AppBundle\Entity\User;

class Registration
{
    /**
     * @Assert\NotBlank()
     * @CoreAssert\UniqueAttribute(
     *      repository="AppBundle\Entity\User",
     *      property="username"
     * )
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8, minMessage = "registration.password.minlength")
     */
    private $password;

    /**
     * @Assert\NotBlank(message = "registration.email.notblank")
     * @Assert\Email()
     * @CoreAssert\UniqueAttribute(
     *      repository="AppBundle\Entity\User",
     *      property="email"
     * )
     * @AppAssert\EmailBlackList()
     */
    private $email;

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        $user = new User();
        $user->setUsername($this->username);
        $user->setEmail($this->email);
        $user->setPlainPassword($this->password);
        $user->setIsActive(true);

        return $user;
    }
}
