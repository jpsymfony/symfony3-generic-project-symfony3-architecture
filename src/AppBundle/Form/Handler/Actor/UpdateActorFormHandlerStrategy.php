<?php
namespace AppBundle\Form\Handler\Actor;

use AppBundle\Entity\Manager\Interfaces\ActorManagerInterface;
use AppBundle\Form\Type\ActorType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Actor;
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

    /**
     * @param Actor $actor
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Actor $actor)
    {
        $this->form = $this->formFactory->create(ActorType::class, $actor, array(
            'action' => $this->router->generate('actor_edit', array('id' => $actor->getId())),
            'method' => 'PUT',
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Actor $actor
     * @return string
     */
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
