<?php

namespace App\CoreBundle\Services\Interfaces;


interface MailerServiceInterface
{
    /**
     * @param $from
     * @param $to
     * @param $subject
     * @param $body
     * @param string $charset
     * @param string $contentType
     */
    public function sendMail($from, $to, $subject, $body, $charset = 'UTF-8', $contentType = 'text/html');
}