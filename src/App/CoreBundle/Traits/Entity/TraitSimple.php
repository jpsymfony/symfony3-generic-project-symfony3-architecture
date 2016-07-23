<?php
namespace App\CoreBundle\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;

trait TraitSimple
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean $archived
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    protected $archived = false;

    /**
     * @inheritdoc}
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc}
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
        return $this;
    }

    /**
     * @inheritdoc}
     */
    public function getArchived()
    {
        return $this->archived;
    }
}