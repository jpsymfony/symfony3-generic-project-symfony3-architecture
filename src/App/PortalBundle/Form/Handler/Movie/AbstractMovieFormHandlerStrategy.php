<?php

namespace App\PortalBundle\Form\Handler\Movie;

use App\PortalBundle\Entity\Manager\Interfaces\MovieManagerInterface;
use App\PortalBundle\Entity\Movie;
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
    public function setMovieManager($movieManager)
    {
        $this->movieManager = $movieManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractMovieFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractMovieFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractMovieFormHandlerStrategy
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;
        return $this;
    }

    public function createView()
    {
        return $this->form->createView();
    }

    abstract public function handleForm(Request $request, Movie $movie, ArrayCollection $originalTags = null);

    abstract public function createForm(Movie $movie);


}