<?php

namespace AppBundle\EventListener;

use AppBundle\Controller\ContactController;
use AppBundle\Controller\User\UserController;
use Jpsymfony\CoreBundle\Services\EntityManagementGuesser;
use Liip\ImagineBundle\Controller\ImagineController;
use Symfony\Bundle\AsseticBundle\Controller\AsseticController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class KernelController
{
    /**
     * @var RouterInterface $router
     */
    private $router;

    /**
     * @var TokenStorageInterface $tokenStorage
     */
    private $tokenStorage;

    /**
     * @var EntityManagementGuesser $entityManagementGuesser
     */
    private $entityManagementGuesser;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        RouterInterface $router,
        EntityManagementGuesser $entityManagementGuesser
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->entityManagementGuesser = $entityManagementGuesser;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controllers = $event->getController();

        if (!is_array($controllers)) {
            return;
        }

        if (
            !$controllers[0] instanceof ProfilerController
            && !$controllers[0] instanceof RedirectController
            && !$controllers[0] instanceof ExceptionController
            && !$controllers[0] instanceof AsseticController
            && !$controllers[0] instanceof ImagineController
        ) {
            $this->entityManagementGuesser->inizialize($controllers[0]);
            $bundle = $this->entityManagementGuesser->getBundleShortName();

            if ('AppBundleController' === $bundle) {
                if ($controllers[0] instanceof ContactController
                    || $controllers[0] instanceof UserController) {
                    return;
                }

                $user  = $this->tokenStorage->getToken()->getUser();

                if (!is_object($user)) {
                    return;
                }

                if (in_array('ROLE_VISITOR', $user->getRoles()) && !$user->isCgvRead()) {
                    $redirectUrl = $this->router->generate('sales_conditions');
                    $event->setController(function() use ($redirectUrl) {
                        return new RedirectResponse($redirectUrl);
                    });
                }
            }
        }
    }
}