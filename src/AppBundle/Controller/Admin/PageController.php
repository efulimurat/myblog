<?php

namespace AppBundle\Controller\Admin;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Page;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
        $page = new Page();

        $form = $this->createFormBuilder($page)
                ->add('category', EntityType::class, array(
                    'class' => 'AppBundle:Category',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                                ->orderBy('c.title', 'ASC');
                    },
                    'choice_label' => 'title',
                ))
                ->add('title', TextType::class, array('label' => 'Sayfa Başlığı'))
                ->add('content', TextareaType::class, array('label' => 'Sayfa İçerik'))
                ->add('status', "choice", array(
                    'label' => 'Sayfa Durumu',
                    "choices" => array("1" => "Aktif", "0" => "Pasif"),
                    "multiple" => false,
                    "expanded" => true,
                    "required" => true
                ))
                ->add('imageFile', FileType::class, array('label' => 'Sayfa Resmi'))
                ->add('save', SubmitType::class, array('label' => 'Kaydet'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $page = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_page_list'));
        }
        return $this->render('admin/page/pageAdd.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}

?>