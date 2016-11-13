<?php

namespace AppBundle\Entity\Manager\Interfaces;

use AppBundle\Entity\Contact;

interface ContactManagerInterface
{
    /**
     * @param Contact $data
     */
    public function sendMail(Contact $data);
} 
