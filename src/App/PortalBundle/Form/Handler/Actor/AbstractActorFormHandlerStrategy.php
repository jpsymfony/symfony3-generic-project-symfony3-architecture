<?php

namespace App\PortalBundle\Form\Handler\Actor;

use App\PortalBundle\Entity\Actor;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;


abstract class AbstractActorFormHandlerStrategy implements ActorFormHandlerStrategy
{

    /**
     * @var Form $form
     */
    protected $form;

    public function createView()
    {
        return $this->form->createView();
    }

    abstract public function handleForm(Request $request, Actor $actor);

    abstract public function createForm(Actor $actor);


}