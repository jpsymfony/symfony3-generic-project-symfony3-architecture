<?php

namespace App\CoreBundle\Services;

use App\CoreBundle\Services\Interfaces\MailerServiceInterface;

class MailerService implements MailerServiceInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @inheritdoc
     */
    public function sendMail($from, $to, $subject, $body, $charset = 'UTF-8', $contentType = 'text/html')
    {
        $message = $this->createMessageInstance($from, $to, $subject, $body, $charset, $contentType);
        $this->mailer->send($message);
    }

    private function createMessageInstance($from, $to, $subject, $body, $charset = 'UTF-8', $contentType = 'text/html')
    {
        $message = \Swift_Message::newInstance()
            ->setCharset($charset)
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body)
            ->setContentType($contentType);

        return $message;
    }
}