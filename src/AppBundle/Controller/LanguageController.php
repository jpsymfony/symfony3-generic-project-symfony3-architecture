<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends Controller
{
    /**
     * Finds and displays a User entity.
     *
     * @param string $language
     * @Route("/changer-langue/{language}", name="change_langue")
     * @Method("GET")
     * @return Response
     */
    public function chooseLanguageAction($language = null)
    {
        $dateExpire = time() + intval(604800);

        if (null !== $language) {
            // On enregistre la langue en session
            $this->get('request_stack')->getCurrentRequest()->setLocale($language);
        }

        // on tente de rediriger vers la page d’origine
        $url = $this->get('request_stack')->getCurrentRequest()->headers->get('referer');

        if (empty($url)) {
            $url = $this->get('router')->generate('homepage');
        } else {
            if (!stristr($url, $this->get('request_stack')->getCurrentRequest()->getHttpHost())) {
                $this->createAccessDeniedException('Attack!!');
            }
        }

        $response = new RedirectResponse($url, 302);

        return $response;
    }
}