<?php
namespace AppBundle\Security;

use AppBundle\Entity\Manager\Interfaces\UserManagerInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Psr\Log\LoggerInterface;

class LogoutSuccessHandler implements LogoutHandlerInterface
{
    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * @var UserManagerInterface $userManager
     */
    private $userManager;
    
    public function __construct(LoggerInterface $logger, UserManagerInterface $userManager) {
        $this->logger = $logger;
        $this->userManager= $userManager;
    }
    
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        $user = $token->getUser();
        $this->logger->info("User " . $user->getEmail() . " has been logged out");

        $response->headers->setCookie(new Cookie('success_connection', '', time() - 3600));

        $this->userManager->setLastConnexion($user, new \DateTime('now'));
        $this->userManager->save($user, false, true);

        return $response;
    }
}
