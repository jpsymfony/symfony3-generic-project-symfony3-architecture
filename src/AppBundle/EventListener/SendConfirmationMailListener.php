<?php

namespace AppBundle\EventListener;

use Jpsymfony\CoreBundle\Services\Interfaces\MailerServiceInterface;
use AppBundle\Event\UserDataEvent;

class SendConfirmationMailListener
{
    /**
     * @var MailerServiceInterface $mailerService
     */
    protected $mailerService;

    /**
     * @var \Twig_Environment
     */
    protected $templating;

    /**
     * @var array
     */
    protected $template;

    /**
     * @var string $from
     */
    protected $from;

    /**
     * @param MailerServiceInterface $mailerService
     * @param \Twig_Environment $templating
     * @param $template
     * @param $from
     */
    public function __construct(MailerServiceInterface $mailerService, \Twig_Environment $templating, $template, $from)
    {
        $this->mailerService = $mailerService;
        $this->templating = $templating;
        $this->template = $template;
        $this->from = $from;
    }

    /**
     * @param UserDataEvent $event
     */
    public function onNewAccountCreated(UserDataEvent $event)
    {
        $this->mailerService->sendMail(
            $this->from,
            $event->getUser()->getEmail(),
            $this->templating->loadTemplate($this->template)->renderBlock('subject', []),
            $this->templating->loadTemplate($this->template)->renderBlock('body', [
                'username' => $event->getUser()->getUsername()
            ])
        );
    }
} 