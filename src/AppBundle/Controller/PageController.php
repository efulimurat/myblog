<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller {

    /**
     * @Route("/yazi/{slug}", name="page_detail", requirements={"page":"{[a-z0-9-]+}"})
     */
    public function indexAction(Request $request, $slug) {
        
        return $this->render('default/index.html.twig', ["records" => $pages["records"]]);
    }

}
