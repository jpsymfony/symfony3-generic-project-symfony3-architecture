<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use Jpsymfony\CoreBundle\Traits\Entity\TraitDatetime;
use Jpsymfony\CoreBundle\Traits\Entity\TraitSimple;
use Jpsymfony\CoreBundle\Traits\Entity\TraitEnabled;
use Jpsymfony\CoreBundle\Traits\Entity\Interfaces\TraitDatetimeInterface;
use Jpsymfony\CoreBundle\Traits\Entity\Interfaces\TraitSimpleInterface;
use Jpsymfony\CoreBundle\Traits\Entity\Interfaces\TraitEnabledInterface;

/**
 * @ORM\Table(name="movie", indexes={@ORM\Index(name="title_idx", columns={"title"}), @ORM\Index(name="release_idx", columns={"released_at"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovieRepository")
 */
class Movie implements TraitDatetimeInterface, TraitSimpleInterface, TraitEnabledInterface
{
    use TraitDatetime;

    use TraitSimple;

    use TraitEnabled;

    private static $likeFieds = ['title', 'description'];
    private static $likeFieldsSearchForm = ['title', 'description', 'releaseDateFrom', 'releaseDateTo'];
    private static $collectionFields = ['hashTags', 'actors'];
    private static $objectFields = ['category'];
    private static $managerCollectionMapping =
        [
            'actors' => 'actor',
            'hashTags' => 'hashTag',
        ];

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * nullable=false to prevent a movie from not having a category
     * notBlank forces the validation form to raise an exception if no category is selected
     * no remove annotation otherwise if a category would be deleted, all associated movies would be deleted too
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * onDelete CASCADE so when an actor is deleted, the association is removed from database
     * @ORM\ManyToMany(targetEntity="Actor")
     * @ORM\JoinTable(name="movie_actor",
     *      joinColumns={@ORM\JoinColumn(name="movie_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="actor_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    private $actors;

    /**
     * persist => when the movie form is submitted, the hashTags are persisted
     * no remove annotation here because when a hashTag is deleted in a movie form, associated hashTags are removed from database in UpdateMovieFormHandlerStrategy handle method
     * orphanRemoval=true => when a movie is deleted, associated hashTags are removed from database
     * @ORM\OneToMany(targetEntity="HashTag", mappedBy="movie", cascade={"persist"}, orphanRemoval=true)
     */
    private $hashTags;

    /**
     * persist => when the movie form is submitted, the image is persisted
     * remove => if a movie is deleted, the attached image is deleted too
     * onDelete SET NULL => if the image is removed from database, the image_id field is set to null
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $image;

    /**
     * no cascade remove annotation otherwise when a movie is deleted, the author is deleted too from database
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="movies")
     */
    private $author;

    /**
     * @var \DateTime $releasedAt
     *
     * @ORM\Column(name="released_at", type="date")
     * @Assert\NotBlank()
     */
    private $releasedAt;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
        $this->hashTags = new ArrayCollection();
    }

    /**
     * Get hashTags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHashTags()
    {
        return $this->hashTags;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Movie
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
     * @return Movie
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

    /**
     * Set description
     *
     * @param string $description
     * @return Movie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set category
     *
     * @param Category $category
     * @return Movie
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add actors
     *
     * @param Actor $actors
     * @return Movie
     */
    public function addActor(Actor $actors)
    {
        $this->actors[] = $actors;

        return $this;
    }

    /**
     * Remove actors
     *
     * @param Actor $actors
     */
    public function removeActor(Actor $actors)
    {
        $this->actors->removeElement($actors);
    }

    /**
     * Get actors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActors()
    {
        return $this->actors;
    }

    public function setActors($actors)
    {
        $this->actors = $actors;

        return $this;
    }

    /**
     * Add hashTags
     *
     * @param \AppBundle\Entity\HashTag $hashTag
     * @return Movie
     */
    public function addHashTag(\AppBundle\Entity\HashTag $hashTag)
    {
        if (!$this->hashTags->contains($hashTag)) {
            $this->hashTags->add($hashTag);
            $hashTag->setMovie($this);
        }
    }

    /**
     * Remove hashTags
     *
     * @param \AppBundle\Entity\HashTag $hashTag
     */
    public function removeHashTag(\AppBundle\Entity\HashTag $hashTag)
    {
        if ($this->hashTags->contains($hashTag)) {
            $this->hashTags->removeElement($hashTag);
        }
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Movie
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Movie
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getReleasedAt()
    {
        return $this->releasedAt;
    }

    /**
     * @param \DateTime $releasedAt
     * @return Movie
     */
    public function setReleasedAt($releasedAt)
    {
        $this->releasedAt = $releasedAt;
        return $this;
    }

    /**
     * @return array
     */
    public static function getLikeFieds()
    {
        return self::$likeFieds;
    }

    /**
     * @return array
     */
    public static function getLikeFieldsSearchForm()
    {
        return self::$likeFieldsSearchForm;
    }

    /**
     * @return array
     */
    public static function getCollectionFields()
    {
        return self::$collectionFields;
    }

    /**
     * @return array
     */
    public static function getObjectFields()
    {
        return self::$objectFields;
    }

    /**
     * @return array
     */
    public static function getManagerCollectionMapping()
    {
        return self::$managerCollectionMapping;
    }

    public static function getManagerName($class)
    {
        if (!array_key_exists($class, static::$managerCollectionMapping)) {
            throw new \Exception('Method getManagerName() expects the parameter ' . $class . ' to be one of ' . implode('Manager, ', array_keys(static::$managerCollectionMapping)));
        }

        return static::$managerCollectionMapping[$class];
    }
}
