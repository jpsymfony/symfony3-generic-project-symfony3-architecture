<?php

namespace App\PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\PortalBundle\Validator\Constraints as CoreAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class Contact
{
    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, unique=false)
     * @Assert\NotBlank(message="contact.firstname.notblank")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, unique=false)
     * @Assert\NotBlank(message="contact.lastname.notblank")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="cellphone", type="string", length=255, nullable=true)
     */
    private $cellphone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=false)
     * @Assert\NotBlank(message="contact.email.notblank")
     * @Assert\Email()
     * @CoreAssert\EmailBlackList()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="additionnalInformation", type="text", nullable=true)
     */
    private $additionnalInformation;

    /**
     * @var string
     *
     * @ORM\Column(name="knowledge", type="string", length=255, nullable=true)
     */
    private $knowledge;

    /**
     * @var string
     *
     * @ORM\Column(name="other", type="string", length=255, nullable=true)
     */
    private $other;

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }


    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Contact
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set cellphone
     *
     * @param string $cellphone
     * @return Contact
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    /**
     * Get cellphone
     *
     * @return string 
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Contact
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

    /**
     * Set additionnalInformation
     *
     * @param string $additionnalInformation
     * @return Contact
     */
    public function setAdditionnalInformation($additionnalInformation)
    {
        $this->additionnalInformation = $additionnalInformation;

        return $this;
    }

    /**
     * Get additionnalInformation
     *
     * @return string 
     */
    public function getAdditionnalInformation()
    {
        return $this->additionnalInformation;
    }

    /**
     * Set knowledge
     *
     * @param string $knowledge
     * @return Contact
     */
    public function setKnowledge($knowledge)
    {
        $this->knowledge = $knowledge;

        return $this;
    }

    /**
     * Get knowledge
     *
     * @return string 
     */
    public function getKnowledge()
    {
        return $this->knowledge;
    }

    /**
     * Set other
     *
     * @param string $other
     * @return Contact
     */
    public function setOther($other)
    {
        $this->other = $other;

        return $this;
    }

    /**
     * Get other
     *
     * @return string 
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * @param ExecutionContextInterface $context
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getKnowledge() == 'autre' && $this->getOther() == null) {
            $context->buildViolation(
                "Vous devez remplir ce champ si vous avez coché 'autre'"
            )
                ->atPath('other')
                ->addViolation();
        }
    }
}
