<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PageController extends Controller {

    /**
     * @Route("/admin/page/list", name="admin_page_list")
     */
    public function listPages() {
        return $this->render('admin/default/index.html.twig');
    }

    /**
     * @Route("/admin/page/add", name="admin_page_add")
     */
    public function addPage(Request $request) {
        // create a task and give it some dummy data for this example
        $page = new Page();
//        $page->setTitle("Başlık Giriniz");
//        $page->setContent("Açıklama Giriniz");

        $form = $this->createFormBuilder($page)
                ->add('title', TextType::class)
                ->add('content', TextareaType::class)
                ->add('status', "choice", array(
                    "choices" => array("1" => "Aktif", "0" => "Pasif"),
                    "multiple" => false,
                    "expanded" => true,
                    "required" => true
                ))
                ->add('save', SubmitType::class, array('label' => 'Kaydet'))
                ->getForm();

        return $this->render('admin/page/pageAdd.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}

?>