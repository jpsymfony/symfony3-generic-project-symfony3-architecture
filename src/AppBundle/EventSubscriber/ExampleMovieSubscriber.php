<?php
namespace AppBundle\EventSubscriber;

use AppBundle\AppEvents;
use AppBundle\Event\MovieEvent;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Movie;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExampleMovieSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'postUpdate',
             AppEvents::EVENT_MOVIE_1 => array('eventMovieLessImportant', -1),
             AppEvents::EVENT_MOVIE_1 => array('eventMovieMoreImportant', 1),
             AppEvents::EVENT_MOVIE_2 => array('eventMovie2', 0)
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Movie) {
            $entityManager = $args->getEntityManager();
            // ... do something with the Movie
        }
    }

    public function eventMovieLessImportant(MovieEvent $event)
    {
        $movie = $event->getMovie();
        // ... do something with the Movie
    }

    public function eventMovieMoreImportant(MovieEvent $event)
    {
        try {
            $movie = $event->getMovie();
            // ... do something with the Movie
        } catch (\Exception $e) {
            $event->stopPropagation();
        }
    }

    public function eventMovie2(MovieEvent $event)
    {
        $movie = $event->getMovie();
        // ... do something with the Movie
    }
}
