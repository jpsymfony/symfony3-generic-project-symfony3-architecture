<?php
namespace App\PortalBundle\Form\Handler\Actor;

use App\PortalBundle\Entity\Manager\Interfaces\ActorManagerInterface;
use App\PortalBundle\Form\Type\ActorType;
use Symfony\Component\HttpFoundation\Request;
use App\PortalBundle\Entity\Actor;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\FormFactoryInterface;

class UpdateActorFormHandlerStrategy extends AbstractActorFormHandlerStrategy
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var ActorManagerInterface
     */
    protected $actorManager;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Constructor.
     *
     * @param TranslatorInterface $translator Service of translation
     * @param ActorManagerInterface $actorManager
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     */
    public function __construct
    (
        TranslatorInterface $translator,
        ActorManagerInterface $actorManager,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    )
    {
        $this->translator = $translator;
        $this->actorManager = $actorManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function createForm(Actor $actor)
    {
        $this->form = $this->formFactory->create(ActorType::class, $actor, array(
            'action' => $this->router->generate('actor_edit', array('id' => $actor->getId())),
            'method' => 'PUT',
        ));

        return $this->form;
    }

    public function handleForm(Request $request, Actor $actor)
    {
        $this->actorManager->save($actor, false, true);

        return $this->translator
            ->trans('acteur.modifier.succes', array(
                '%nom%' => $actor->getFirstName(),
                '%prenom%' => $actor->getLastName()
            ));
    }
}
