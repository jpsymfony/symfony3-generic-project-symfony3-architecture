<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Actor;
use Symfony\Component\HttpFoundation\Response;

class ActorController extends Controller
{
    /**
     * @Route("/actors/{page}", name="actors_list", defaults={"page" = 1}, options={"expose"=true})
     * @Template("actor/list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return mixed
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $motcle = $request->query->get('motcle');
        $limit = $this->getParameter('app.max_actors_per_page');
        $nbFilteredActors = $this->getActorManager()->getResultFilterCount($motcle);

        $data = [
            'actors' => $this->getActorManager()->getResultFilterPaginated($motcle, $limit, ($page - 1) * $limit),
            'displayActorsFound' => true,
            'pagination' => $this->getActorManager()->getPagination($request->query->all(), $page, 'actors_list', $limit, $nbFilteredActors),
            'nbFilteredActors' => $nbFilteredActors
        ];

        if ($request->isXmlHttpRequest()) {
            return new Response('TODO');
        }

        return array_merge($data, ['form' => $this->getActorManager()->getActorSearchForm()->createView()]);
    }

    /**
     * @Template("actor/partials/actors.html.twig")
     */
    public function topAction($max = 5, $displayActorsFound = false)
    {
        $actors = $this->getActorManager()->findBy([], ['birthday'=> 'asc'], $max);

        return [
            'actors' => $actors,
            'displayActorsFound' => $displayActorsFound,
        ];
    }

    /**
     * @Route("/admin/actors/new", name="actor_new")
     * @Route("/admin/actors/{id}/edit", name="actor_edit")
     * @param Request $request
     * @return array|RedirectResponse
     * @Template("actor/edit.html.twig")
     */
    public function newEditAction(Request $request)
    {
        $id = $request->attributes->get('id');
        $actor = null;

        if (!is_null($id)) {
            $actor = $this->getActorManager()->find($id);
            if (!$actor) {
                throw $this->createNotFoundException('Actor ' . $id . ' not found');
            }
        }

        $entityToProcess = $this->getActorFormHandler()->processForm($actor);

        if ($this->getActorFormHandler()->handleForm($this->getActorFormHandler()->getForm(), $entityToProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getActorFormHandler()->getMessage());

            return $this->redirectToRoute('actor_edit', array('id' => $entityToProcess->getId()));
        }

        return [
            'form' => $this->getActorFormHandler()->createView(),
            'actor' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/actors/{id}/delete", name="actor_delete")
     * @return RedirectResponse
     */
    public function deleteAction($id)
    {
        $actor = $this->getActorManager()->find($id);

        if (!$actor) {
            throw $this->createNotFoundException('Actor ' . $id . ' not found');
        }
        $this->getActorManager()->remove($actor);
        $this->addFlash('success', $this->get('translator')->trans('acteur.supprime', ['%actor%' => $actor]));

        return new RedirectResponse($this->container->get('router')->generate('actors_list'));
    }

    public function getActorFormHandler()
    {
        return $this->get('app.actor.form.handler');
    }

    public function getActorManager()
    {
        return $this->get('app.actor.manager');
    }
}
