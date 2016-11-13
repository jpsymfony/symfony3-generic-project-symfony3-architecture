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

        $movies = $this->getMovieManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredMovies = $this->getMovieManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getMovieManager()->getPagination($requestVal, $page, 'movie_list', $limit, $nbFilteredMovies);

        return [
            'movies' => $movies,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Template("movie/partials/movies.html.twig", vars={"movies"})
     * @ParamConverter("movies", converter="project_collection_converter", options={"manager":"app.movie.manager", "orderby":"title", "dir":"desc"})
     * @param ArrayCollection $movies
     * @param int $max
     */
    public function topAction(ArrayCollection $movies, $max = 5)
    {
    }

    /**
     * @Route("/movies/{id}/show", name="movie_show")
     * @ParamConverter("movie", class="AppBundle:Movie")
     * @param Movie $movie
     * @return Response
     * @Security("has_role('ROLE_VISITOR')")
     * @Cache(smaxage=600)
     */
    public function showAction(Movie $movie)
    {
        $response = new Response();
        $response->setEtag(md5($movie->getId() . $movie->getUpdatedAt()->format('YmdHis') . microtime(true)));

        return $this->render('movie/show.html.twig', ['movie' => $movie], $response);
    }

    /**
     * @Route("/admin/movies/new", name="movie_new")
     * @Route("/admin/movies/{id}/edit", name="movie_edit")
     * @Template("movie/edit.html.twig")
     * @param Request $request
     * @param Movie|null $movie
     * @return array|RedirectResponse
     * @ParamConverter("movie", class="AppBundle:Movie")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, Movie $movie = null)
    {
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
     * @ParamConverter("movie", class="AppBundle:Movie")
     * @param Movie $movie
     * @return RedirectResponse
     */
    public function deleteAction(Movie $movie)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
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
