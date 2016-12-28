<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/{page}", name="homepage", requirements={"page":"{\d+}"})
     */
    public function indexAction(Request $request, $page = 1) {
        if ($page < 1)
            $page = 1;

        $length = 6;
        $start = ($page - 1) * $length;

        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('AppBundle:Page')
                ->listHomepagePages($start);

        return $this->render('default/index.html.twig', ["records" => $pages["records"]]);
    }

}
