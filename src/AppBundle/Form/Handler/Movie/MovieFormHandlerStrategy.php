<?php
namespace AppBundle\Form\Handler\Movie;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Movie;

interface MovieFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Movie $movie
     * @param ArrayCollection|null $originalHashTags
     * @return mixed
     */
    public function handleForm(Request $request, Movie $movie, ArrayCollection $originalHashTags = null);

    /**
     * @param Movie $movie
     * @return mixed
     */
    public function createForm(Movie $movie);

    /**
     * @return mixed
     */
    public function createView();
}
