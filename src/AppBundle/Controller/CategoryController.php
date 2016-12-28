<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller {

    /**
     * @Route("/kategori/{slug}/{page}", name="category_detail", requirements={"page":"{\d+}"})
     */
    public function indexAction(Request $request, $slug, $page = 1) {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')
                ->categoryDetail($slug);
        
        if(!$category){
            throw $this->createNotFoundException('Sayfa Bulunamadı');
        }
        
        if ($page < 1)
            $page = 1;

        $length = 6;
        $start = ($page - 1) * $length;

        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('AppBundle:Page')
                ->listCategoryPages($category->getId(),$start);

        return $this->render('category/index.html.twig', ["records" => $pages["records"]]);
        
    }

}
