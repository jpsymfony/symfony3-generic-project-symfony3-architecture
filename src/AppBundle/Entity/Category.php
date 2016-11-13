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
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Category implements TraitDatetimeInterface, TraitSimpleInterface, TraitEnabledInterface
{
    use TraitDatetime;

    use TraitSimple;

    use TraitEnabled;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=100)
     * @Assert\Regex("/^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]+$/")
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @param string $title
     */
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function __toString()
    {
        return $this->title;
    }
}
