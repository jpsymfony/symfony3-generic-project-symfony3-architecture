<?php

namespace AppBundle\EventListener;

use Jpsymfony\CoreBundle\Services\EntityManagementGuesser;
use AppBundle\Controller\ContactController;
use Liip\ImagineBundle\Controller\ImagineController;
use Symfony\Bundle\AsseticBundle\Controller\AsseticController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class KernelController
{
    /**
     * @var AuthorizationChecker $authorizationChecker
     */
    private $authorizationChecker;

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
        AuthorizationChecker $authorizationChecker,
        TokenStorageInterface $tokenStorage,
        RouterInterface $router,
        EntityManagementGuesser $entityManagementGuesser
    )
    {
        $this->authorizationChecker = $authorizationChecker;
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

            if ('AppBundle' == $bundle) {
                if ($controllers[0] instanceof ContactController) {
                    return;
                }

                $user  = $this->tokenStorage->getToken()->getUser();

                if (!is_object($user)) {
                    return;
                }

                $roles = $user->getRoles();
                $role  = $roles[0];

                if ('ROLE_VISITOR' === $role) {
                    $cgvRead = $user->isCgvRead();
                    if (!$cgvRead) {
                        $redirectRoute = 'sales_conditions';
                        $redirectUrl = $this->router->generate($redirectRoute);
                        $event->setController(function() use ($redirectUrl) {
                            return new RedirectResponse($redirectUrl);
                        });
                    }
                }
            }
        }
    }
}