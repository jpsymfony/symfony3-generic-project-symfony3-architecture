<?php
namespace App\PortalBundle\Form\Handler\Actor;

use Symfony\Component\HttpFoundation\Request;
use App\PortalBundle\Entity\Actor;

interface ActorFormHandlerStrategy
{
    public function handleForm(Request $request, Actor $actor);

    public function createForm(Actor $actor);

    public function createView();
}
