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
        $response = parent::onAuthenticationSuccess($request, $token);
        
        return $response;
    }
}
