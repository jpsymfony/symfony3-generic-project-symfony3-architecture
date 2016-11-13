<?php

namespace AppBundle\Form\Handler\Movie;

use AppBundle\Entity\Manager\Interfaces\MovieManagerInterface;
use AppBundle\Entity\Movie;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractMovieFormHandlerStrategy implements MovieFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var MovieManagerInterface
     */
    protected $movieManager;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param MovieManagerInterface $movieManager
     * @return AbstractMovieFormHandlerStrategy
     */
    public function setMovieManager(MovieManagerInterface $movieManager)
    {
        $this->movieManager = $movieManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractMovieFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractMovieFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractMovieFormHandlerStrategy
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
        return $this;
    }

    /**
     * @return \Symfony\Component\Form\FormView
     */
    public function createView()
    {
        return $this->form->createView();
    }

    /**
     * @param Request $request
     * @param Movie $movie
     * @param ArrayCollection|null $originalTags
     * @return mixed
     */
    abstract public function handleForm(Request $request, Movie $movie, ArrayCollection $originalTags = null);

    /**
     * @param Movie $movie
     * @return mixed
     */
    abstract public function createForm(Movie $movie);


}