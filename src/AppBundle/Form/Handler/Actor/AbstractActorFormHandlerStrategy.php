<?php

namespace AppBundle\Form\Handler\Actor;

use AppBundle\Entity\Actor;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractActorFormHandlerStrategy implements ActorFormHandlerStrategy
{

    /**
     * @var Form $form
     */
    protected $form;

    /**
     * @return \Symfony\Component\Form\FormView
     */
    public function createView()
    {
        return $this->form->createView();
    }

    /**
     * @param Request $request
     * @param Actor $actor
     * @return mixed
     */
    abstract public function handleForm(Request $request, Actor $actor);

    /**
     * @param Actor $actor
     * @return mixed
     */
    abstract public function createForm(Actor $actor);


}