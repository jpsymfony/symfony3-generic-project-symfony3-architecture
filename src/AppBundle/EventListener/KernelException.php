<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;

class KernelException
{
    /**
     * @var Router $router
     */
    private $router;

    /**
     * @var Session $session
     */
    protected $session;

    /**
     * @var string $urlRedirectionException
     */
    protected $urlRedirectionException;

    public function __construct(Router $router, Session $session, $urlRedirectionException)
    {
        $this->router = $router;
        $this->session = $session;
        $this->urlRedirectionException = $urlRedirectionException;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        // You get the exception object from the received event
        $exception = $event->getException();

        if (
            $exception instanceof AccessDeniedHttpException ||
            $exception instanceof AccessDeniedException ||
            $exception instanceof InsufficientAuthenticationException
        ) {
            $this->session->getFlashBag()->add('error', $exception->getMessage());
            $url = $this->router->generate($this->urlRedirectionException);
            $event->setResponse(new RedirectResponse($url));
        }
    }
}