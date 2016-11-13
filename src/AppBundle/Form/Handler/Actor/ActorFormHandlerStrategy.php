<?php
namespace AppBundle\Form\Handler\Actor;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Actor;

interface ActorFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Actor $actor
     * @return mixed
     */
    public function handleForm(Request $request, Actor $actor);

    /**
     * @param Actor $actor
     * @return mixed
     */
    public function createForm(Actor $actor);

    /**
     * @return mixed
     */
    public function createView();
}
