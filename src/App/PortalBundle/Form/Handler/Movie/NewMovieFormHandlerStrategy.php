<?php
namespace App\PortalBundle\Form\Handler\Movie;

use App\PortalBundle\Form\Type\MovieType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use App\PortalBundle\Entity\Movie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
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
