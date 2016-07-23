<?php

namespace App\PortalBundle\Entity\Manager\Interfaces;

use App\CoreBundle\Services\Interfaces\MailerServiceInterface;
use App\PortalBundle\Entity\Contact;
use Symfony\Component\Translation\TranslatorInterface;

interface ContactManagerInterface
{
    /**
     * @param Contact $data
     */
    public function sendMail(Contact $data);
} 
