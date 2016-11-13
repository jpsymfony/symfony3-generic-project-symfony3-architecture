<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use Jpsymfony\CoreBundle\Traits\Entity\TraitDatetime;
use Jpsymfony\CoreBundle\Traits\Entity\TraitSimple;
use Jpsymfony\CoreBundle\Traits\Entity\TraitEnabled;
use Jpsymfony\CoreBundle\Traits\Entity\Interfaces\TraitDatetimeInterface;
use Jpsymfony\CoreBundle\Traits\Entity\Interfaces\TraitSimpleInterface;
use Jpsymfony\CoreBundle\Traits\Entity\Interfaces\TraitEnabledInterface;

/**
 * @ORM\Table(name="hashTag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HashTagRepository")
 */
class HashTag implements TraitDatetimeInterface, TraitSimpleInterface, TraitEnabledInterface
{
    use TraitDatetime;

    use TraitSimple;

    use TraitEnabled;

    /**
     * onDelete CASCADE useless because orphanRemoval in Movie entity
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="hashTags")
     */
    private $movie;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $name;

    /**
     * Set nom
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set movie
     *
     * @param Movie $movie
     * @return HashTag
     */
    public function setMovie(Movie $movie = null)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return Movie
     */
    public function getMovie()
    {
        return $this->movie;
    }

    public function __toString()
    {
        return (string)$this->name;
    }
}
