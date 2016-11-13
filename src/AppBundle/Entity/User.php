<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Interfaces\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="That username is taken!")
 * @UniqueEntity(fields="email", message="That email is taken!")
 */
class User implements UserInterface, Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank(message="Give us at least 3 characters")
     * @Assert\Length(min=3, minMessage="Give us at least 3 characters!")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = array();

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    /**
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/",
     *      message="Use 1 upper case letter, 1 lower case letter, and 1 number"
     * )
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $confirmationToken = null;

    /**
     * // no cascade remove otherwise if an author would be removed from database, associated movies would be removed too
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Movie", mappedBy="author")
     */
    private $movies;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $isAlreadyRequested = false;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cgvRead;

    /**
     * @var \DateTime $lastConnexion
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnexion;

    public function __toString()
    {
        return (string) $this->getUsername();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return boolean
     */
    public function isCgvRead()
    {
        return $this->cgvRead;
    }

    /**
     * @param boolean $cgvRead
     */
    public function setCgvRead($cgvRead)
    {
        $this->cgvRead = $cgvRead;
    }

    /**
     * @param PasswordEncoderInterface $encoder
     */
    public function encodePassword(PasswordEncoderInterface $encoder)
    {
        if ($this->plainPassword) {
            $this->salt = sha1(uniqid(mt_rand()));
            $this->password = $encoder->encodePassword(
                $this->plainPassword, $this->salt
            );

            $this->eraseCredentials();
        }
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        // allows for chaining
        return $this;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    public function getIsAlreadyRequested()
    {
        return $this->isAlreadyRequested;
    }

    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    public function setIsAlreadyRequested($isAlreadyRequested)
    {
        $this->isAlreadyRequested = $isAlreadyRequested;
    }

    /**
     * @return mixed
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
     * @param mixed $movies
     * @return User
     */
    public function setMovies($movies)
    {
        $this->movies = $movies;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastConnexion()
    {
        return $this->lastConnexion;
    }

    /**
     * @param \DateTime $lastConnexion
     */
    public function setLastConnexion(\DateTime $lastConnexion)
    {
        $this->lastConnexion = $lastConnexion;
    }
}