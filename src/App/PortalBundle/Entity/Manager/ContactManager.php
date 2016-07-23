<?php
namespace App\PortalBundle\Entity\Manager;

use App\CoreBundle\Services\Interfaces\MailerServiceInterface;
use App\PortalBundle\Entity\Contact;
use App\PortalBundle\Entity\Manager\Interfaces\ContactManagerInterface;
use App\PortalBundle\Entity\Manager\Interfaces\ManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ContactManager implements ContactManagerInterface, ManagerInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment
     */
    protected $templating;

    /**
     * @var TranslatorInterface $translator
     */
    protected $translator;

    /**
     * @var array
     */
    protected $template;

    /**
     * @var string $from
     */
    protected $from;

    /**
     * @var string $to
     */
    protected $to;

    /**
     * @var MailerServiceInterface
     */
    protected $mailerService;

    /**
     * @param MailerServiceInterface $mailerService
     * @param \Twig_Environment $templating
     * @param $template
     * @param $from
     * @param $to
     */
    public function __construct(MailerServiceInterface $mailerService, \Twig_Environment $templating, TranslatorInterface $translator, $template, $from, $to)
    {
        $this->templating = $templating;
        $this->template = $template;
        $this->translator = $translator;
        $this->from = $from;
        $this->to = $to;
        $this->mailerService = $mailerService;
    }

    /**
     * @inheritdoc
     */
    public function sendMail(Contact $data)
    {
        $this->mailerService->sendMail(
            $this->from,
            $this->to,
            $this->translator->trans('contact.message_subject', ['%name%' => $data]),
            $this->templating->render($this->template, ['data' => $data])
        );
    }

    /**
     * @inheritDoc
     */
    public function isTypeMatch($labelClass)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return null;
    }

}
