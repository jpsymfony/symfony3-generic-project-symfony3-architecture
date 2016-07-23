<?php

namespace App\PortalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\PortalBundle\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ActorController extends Controller
{
    /**
     * @Route("/actors/{page}", name="actors_list", defaults={"page" = 1}, options={"expose"=true})
     * @Template("@AppPortal/Actor/list.html.twig")
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
        $limit = $this->getParameter('app_portal.max_actors_per_page');
        $nbFilteredActors = $this->getActorManager()->getResultFilterCount($motcle);

        $data = [
            'actors' => $this->getActorManager()->getResultFilterPaginated($motcle, $limit, ($page - 1) * $limit),
            'displayActorsFound' => true,
            'pagination' => $this->getActorManager()->getPagination($request->query->all(), $page, 'actors_list', $limit, $nbFilteredActors),
            'nbFilteredActors' => $nbFilteredActors
        ];

        if ($request->isXmlHttpRequest()) {
            return $this->get('templating')->renderResponse('@AppPortal/Actor/partials/actors.html.twig', $data);
        }

        return array_merge($data, ['form' => $this->getActorManager()->getActorSearchForm()->createView()]);
    }

    /**
     * @Template("@AppPortal/Actor/partials/actors.html.twig", vars={"actors", "displayActorsFound"})
     * @ParamConverter("actors", converter="project_collection_converter", options={"manager":"app_portal.actor.manager", "orderby":"birthday"})
     */
    public function topAction(ArrayCollection $actors, $max = 5, $displayActorsFound = false)
    {
    }

    /**
     * @Route("/admin/actors/new", name="actor_new")
     * @Route("/admin/actors/{id}/edit", name="actor_edit")
     * @param Request $request
     * @param Actor|null $actor
     * @return array|RedirectResponse
     * @Template("@AppPortal/Actor/edit.html.twig")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, Actor $actor = null)
    {
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
     * @param Actor $actor
     * @ParamConverter("actor", class="AppPortalBundle:Actor")
     * @return RedirectResponse
     */
    public function deleteAction(Actor $actor)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $this->getActorManager()->remove($actor);
        $this->addFlash('success', $this->get('translator')->trans('acteur.supprime', ['%actor%' => $actor]));

        return new RedirectResponse($this->get('router')->generate('actors_list'));
    }

    public function getActorFormHandler()
    {
        return $this->get('app_portal.actor.form.handler');
    }

    public function getActorManager()
    {
        return $this->get('app_portal.actor.manager');
    }
}
