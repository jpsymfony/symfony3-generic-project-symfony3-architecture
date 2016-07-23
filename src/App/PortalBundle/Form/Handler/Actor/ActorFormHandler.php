<?php
namespace App\PortalBundle\Form\Handler\Actor;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use App\PortalBundle\Entity\Actor;

class ActorFormHandler
{
    /**
     * @var string
     */
    private $message = "";

    /**
     * @var FormInterface $form
     */
    protected $form;

    /**
     * @var ActorFormHandlerStrategy $actorFormHandlerStrategy
     */
    protected $actorFormHandlerStrategy;

    /**
     * @var ActorFormHandlerStrategy $newActorFormHandlerStrategy
     */
    protected $newActorFormHandlerStrategy;

    /**
     * @var ActorFormHandlerStrategy $updateActorFormHandlerStrategy
     */
    protected $updateActorFormHandlerStrategy;

    public function setNewActorFormHandlerStrategy(ActorFormHandlerStrategy $nafhs) {
        $this->newActorFormHandlerStrategy = $nafhs;
    }

    public function setUpdateActorFormHandlerStrategy(ActorFormHandlerStrategy $uafhs) {
        $this->updateActorFormHandlerStrategy = $uafhs;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Actor|null $actor
     * @return Actor
     */
    public function processForm(Actor $actor = null)
    {
        if (is_null($actor)) {
            $actor = new Actor();
            $this->actorFormHandlerStrategy = $this->newActorFormHandlerStrategy;
        } else {
            $this->actorFormHandlerStrategy = $this->updateActorFormHandlerStrategy;
        }

        $this->form = $this->createForm($actor);

        return $actor;
    }

    /**
     * @param Actor $actor
     * @return FormInterface
     */
    public function createForm(Actor $actor)
    {
        return $this->actorFormHandlerStrategy->createForm($actor);
    }

    /**
     * @param FormInterface $form
     * @param Actor $actor
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Actor $actor, Request $request)
    {
        if (
            (null === $actor->getId() && $request->isMethod('POST'))
            || (null !== $actor->getId() && $request->isMethod('PUT'))
        ) {
            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->actorFormHandlerStrategy->handleForm($request, $actor);

            return true;
        }
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return mixed
     */
    public function createView()
    {
        return $this->actorFormHandlerStrategy->createView();
    }
}
