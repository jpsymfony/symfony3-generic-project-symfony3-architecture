<?php

namespace AppBundle\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class HomePageController
 *
 * @Route("/back")
 */
class HomePageController extends Controller
{
    /**
     * @Route("/", name="homepage_admin")
     * @Template("back/homePage/index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}
