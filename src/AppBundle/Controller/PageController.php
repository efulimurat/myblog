<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller {

    /**
     * @Route("/yazi/{slug}", name="page_detail")
     */
    public function indexAction(Request $request, $slug) {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('AppBundle:Page')
                ->pageDetail($slug);

        return $this->render('page/detail.html.twig',["Page"=>$page]);
    }

}
