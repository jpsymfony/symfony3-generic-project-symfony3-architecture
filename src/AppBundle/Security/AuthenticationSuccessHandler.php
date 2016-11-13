<?php
namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    private $logger;
    
    public function __construct(LoggerInterface $logger, HttpUtils $httpUtils, array $options)
    {
        parent::__construct($httpUtils, $options);
        
        $this->logger = $logger;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        $this->logger->info("User ".$user->getId()." has been logged", array('user' => $user));

        $response = parent::onAuthenticationSuccess($request, $token);
        $response->headers->setCookie(new Cookie('success_connection', $token->getUsername(), 0));
        
        return $response;
    }
}
