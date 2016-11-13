<?php
namespace AppBundle\Form\Handler\Movie;

use AppBundle\Form\Type\MovieType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Movie;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewMovieFormHandlerStrategy extends AbstractMovieFormHandlerStrategy
{
    /**
     * @var TokenStorageInterface
     */
    protected $securityTokenStorage;

    /**
     * Constructor.
     *
     * @param TokenStorageInterface $securityTokenStorage
     */
    public function __construct(TokenStorageInterface $securityTokenStorage)
    {
        $this->securityTokenStorage = $securityTokenStorage;
    }

    /**
     * @param Movie $movie
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Movie $movie)
    {
        $this->form = $this->formFactory->create(MovieType::class, $movie, array(
            'action' => $this->router->generate('movie_new'),
            'method' => 'POST',
            'hashtags_hidden' => false,
            'image' => null,
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Movie $movie
     * @param ArrayCollection|null $originalHashTags
     * @return string
     */
    public function handleForm(Request $request, Movie $movie, ArrayCollection $originalHashTags = null)
    {
        $movie->setAuthor($this->securityTokenStorage->getToken()->getUser());
        $this->movieManager->save($movie, true, true);

        return $this->translator
            ->trans('film.ajouter.succes', array(
                '%titre%' => $movie->getTitle()
            ));
    }


}
