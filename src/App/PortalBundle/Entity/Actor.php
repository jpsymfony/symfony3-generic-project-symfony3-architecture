<?php

namespace App\PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use App\CoreBundle\Traits\Entity\TraitDatetime;
use App\CoreBundle\Traits\Entity\TraitSimple;
use App\CoreBundle\Traits\Entity\TraitEnabled;
use App\CoreBundle\Traits\Entity\Interfaces\TraitDatetimeInterface;
use App\CoreBundle\Traits\Entity\Interfaces\TraitSimpleInterface;
use App\CoreBundle\Traits\Entity\Interfaces\TraitEnabledInterface;

/**
 * @ORM\Table(name="actor")
 * @ORM\Entity(repositoryClass="App\PortalBundle\Repository\ActorRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Actor implements TraitDatetimeInterface, TraitSimpleInterface, TraitEnabledInterface
{
    use TraitDatetime;
    
    use TraitSimple;
    
    use TraitEnabled;
    
    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3, minMessage = "erreur.nom.minlength")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $birthday;

    /**
     * @ORM\Column(type="string",length=1)
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {"M", "F"})
     */
    private $sex;

    /**
     * @Gedmo\Slug(fields={"firstName", "lastName"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return Actor
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return Actor
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     * @return Actor
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param string $sex
     * @return Actor
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }
    
    /**
     * Get firstName lastName
     *
     * @return string $firstName.' '.$lastName
     */
    public function getFirstNameLastName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    public function __toString()
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Actor
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
