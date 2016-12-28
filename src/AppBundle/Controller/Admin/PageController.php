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
use Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends Controller {
    
    /**
     * @Route("/admin/page", name="admin_page_default")
     */
    public function pagesIndex() {
        
        return $this->render('admin/page/pageList.html.twig');
    }
    /**
     * Ajax Requestlerini JSON olarak döner
     * @Route("/admin/page/ajax/list", name="admin_page_ajaxdata")
     */
    public function getPages(Request $request) {
        $start = (int)$request->get('start');
        $length = (int)$request->get('length');
        $search = $request->get('search')["value"];
        
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('AppBundle:Page')
                ->listAllPages($start, $length, $search);

        $jsonData = [];

        foreach ($pages["records"] as $page) {
            $_titlePattern = "<a href='%s'>%s</a>";
            $title = $page->getTitle();
            $pageUpateUrl = $this->generateUrl('admin_page_update', array("id" => $page->getId()));

            array_push($jsonData, array(sprintf($_titlePattern, $pageUpateUrl, $title), $page->getStatus() == 1 ? "Aktif" : "Pasif"));
        }
        $response = new JsonResponse();
        $response->setData(array(
            'data' => $jsonData,
            'recordsTotal' => $pages["recordsCount"],
            'recordsFiltered' => $pages["recordsCount"]
        ));
        return $response;
    }

    /**
     * @Route("/admin/page/add", name="admin_page_add")
     */
    public function addPage(Request $request) {
        $page = new Page();

        $form = $this->createFormBuilder($page)
                ->add('category', EntityType::class, array(
                    'label' => "Kategori",
                    'class' => 'AppBundle:Category',
                    'placeholder' => 'Kategori Seçiniz',
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

            return $this->redirect($this->generateUrl('admin_page_default'));
        }
        return $this->render('admin/page/pageAdd.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/admin/page/update/{id}", name="admin_page_update", requirements ={"id":"\d+"})
     */
    public function updatePage(Request $request, $id) {
        
        $em = $this->getDoctrine()->getEntityManager();
        $page = $em->getRepository('AppBundle:Page')->find($id);
        if(!$page){
            throw $this->createNotFoundException('Sayfa Bulunamadı');
        }
        $form = $this->createFormBuilder($page)
                ->add('category', EntityType::class, array(
                    'label' => "Kategori",
                    'class' => 'AppBundle:Category',
                    'placeholder' => 'Kategori Seçiniz',
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
                ->add('imageFile', FileType::class, array('label' => 'Sayfa Resmi', "required" => false))
                ->add('save', SubmitType::class, array('label' => 'Kaydet'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $page = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_page_default'));
        }
        return $this->render('admin/page/pageUpdate.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/admin/page/delete/{id}", name="admin_page_delete", requirements={"id": "\d+"})
     */
    public function deletePage($id) {

        $em = $this->getDoctrine()->getEntityManager();
        $page = $em->getRepository('AppBundle:Page')->find($id);
        if(!$page){
            throw $this->createNotFoundException('Sayfa Bulunamadı');
        }
        $em->remove($page);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_page_default'));
    }

}

?>