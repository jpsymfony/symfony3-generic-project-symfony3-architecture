<?php
namespace AppBundle\Form\Handler\Movie;

use AppBundle\Entity\Manager\Interfaces\HashTagManagerInterface;
use AppBundle\Form\Type\MovieType;
use AppBundle\Security\MovieVoter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use AppBundle\Entity\Movie;

class UpdateMovieFormHandlerStrategy extends AbstractMovieFormHandlerStrategy
{
    /**
     * @var HashTagManagerInterface
     */
    protected $hashTagManager;

    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authorizationChecker;

    /**

     * Constructor.
     *
     * @param HashTagManagerInterface $hashTagManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct
    (
        HashTagManagerInterface $hashTagManager,
        AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->hashTagManager = $hashTagManager;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param Movie $movie
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Movie $movie)
    {
        // we put image in the MovieType constructor to fill value when the form is loaded
        $this->form = $this->formFactory->create(
            MovieType::class,
            $movie,
            [
                'action' => $this->router->generate('movie_edit', ['id' => $movie->getId()]),
                'method' => 'PUT',
                'hashtags_hidden' => false,
                'image' => $movie->getImage()
            ]
        );

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
        foreach ($originalHashTags as $hashTag) {
            if (false === $movie->getHashTags()->contains($hashTag)) {
                $movie->removeHashTag($hashTag);
                $this->hashTagManager->remove($hashTag);
            }
        }

        $this->movieManager->save($movie, false, true);

        return $this->translator
            ->trans('film.modifier.succes', array(
                '%titre%' => $movie->getTitle()
            ));
    }
}
