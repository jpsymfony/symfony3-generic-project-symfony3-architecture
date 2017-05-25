<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends Controller
{
    /**
     * @Route("/movies/{page}", name="movie_list", defaults={"page" = 1})
     * @Template("movie/list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of movies and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();
        $limit = $this->getParameter('app.max_movies_per_page');

        // really dirty but will be removed with the datepicker
        $currentRequestVal = current($requestVal);
        if (!empty($currentRequestVal['releaseDateFrom']) && is_array($currentRequestVal['releaseDateFrom'])) {
            $currentRequestVal['releaseDateFrom'] = (new \DateTime($currentRequestVal['releaseDateFrom']['year'] . '-' . $currentRequestVal['releaseDateFrom']['month'] . '-' . $currentRequestVal['releaseDateFrom']['day']))->format('Y-m-d');
        }
        if (!empty($currentRequestVal['releaseDateTo']) && is_array($currentRequestVal['releaseDateTo'])) {
            $currentRequestVal['releaseDateTo'] = (new \DateTime($currentRequestVal['releaseDateTo']['year'] . '-' . $currentRequestVal['releaseDateTo']['month'] . '-' . $currentRequestVal['releaseDateTo']['day']))->format('Y-m-d');
        }
        // end block to remove

        $movies = $this->getMovieManager()->getResultFilterPaginated($currentRequestVal, $limit, ($page - 1) * $limit);
        $nbFilteredMovies = $this->getMovieManager()->getResultFilterCount($currentRequestVal);
        $pagination = $this->getMovieManager()->getPagination($requestVal, $page, 'movie_list', $limit, $nbFilteredMovies);

        return [
            'movies' => $movies,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Template("movie/partials/movies.html.twig")
     */
    public function topAction($max = 5)
    {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findBy([], ['title'=> 'asc'], $max);

        return [
            'movies' => $movies,
        ];
    }

    /**
     * @Route("/movies/{id}/show", name="movie_show")
     */
    public function showAction($id)
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Movie ' . $id . ' not found');
        }

        return $this->render('movie/show.html.twig', ['movie' => $movie]);
    }

    /**
     * @Route("/admin/movies/new", name="movie_new")
     * @Route("/admin/movies/{id}/edit", name="movie_edit")
     * @Template("movie/edit.html.twig")
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function newEditAction(Request $request)
    {
        $id = $request->attributes->get('id');
        $movie = null;

        if (!is_null($id)) {
            $movie = $this->getMovieManager()->find($id);
            if (!$movie) {
                throw $this->createNotFoundException('Movie ' . $id . ' not found');
            }
        }

        $entityToProcess = $this->getMovieFormHandler()->processForm($movie);

        if ($this->getMovieFormHandler()->handleForm($this->getMovieFormHandler()->getForm(), $entityToProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getMovieFormHandler()->getMessage());

            return $this->redirectToRoute('movie_edit', array('id' => $entityToProcess->getId()));
        }

        return [
            'form' => $this->getMovieFormHandler()->createView(),
            'movie' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/movies/{id}/delete", name="movie_delete")
     * @return RedirectResponse
     */
    public function deleteAction($id)
    {
        $movie = $this->getDoctrine()->getManager()->getRepository(Movie::class)->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Movie ' . $id . ' not found');
        }

        $this->getMovieManager()->remove($movie);
        $this->addFlash('success', $this->get('translator')->trans('film.supprime', ['%title%' => $movie->getTitle()]));

        return new RedirectResponse($this->get('router')->generate('movie_list'));
    }

    /**
     * @Template("movie/partials/formFilter.html.twig")
     * @param Request $request
     * @return Response
     */
    public function formFilterAction(Request $request)
    {
        $form = $this->getMovieManager()->getMovieSearchForm(new Movie());

        try {
            $this->getMovieFormHandler()->handleSearchForm($form, $request);
        } catch (\Exception $e) {
            $this->get('logger')->error($e->getMessage());
            $this->addFlash('error', $e->getMessage());
        }

        return $this->render('movie/partials/formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getMovieFormHandler()
    {
        return $this->get('app.movie.form.handler');
    }

    public function getMovieManager()
    {
        return $this->get('app.movie.manager');
    }
}
