<?php
namespace App\PortalBundle\Form\Handler\Movie;

use App\PortalBundle\Entity\Manager\Interfaces\HashTagManagerInterface;
use App\PortalBundle\Form\Type\MovieType;
use App\UserBundle\Security\MovieVoter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\PortalBundle\Entity\Movie;

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

    public function handleForm(Request $request, Movie $movie, ArrayCollection $originalHashTags = null)
    {
        if (!$this->authorizationChecker->isGranted(MovieVoter::EDIT, $movie)) {
            $errorMessage = $this->translator->trans('film.modifier.erreur', ['%movie%' => $movie->getTitle()]);

            throw new AccessDeniedException($errorMessage);
        }

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
