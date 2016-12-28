<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends Controller {

    /**
     * @Route("/admin/category/list", name="admin_category_list")
     */
    public function listCategories() {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')
                ->listAllPageCategories();

        return $this->render('admin/category/categoryList.html.twig', array("categories" => $categories));
    }

    /**
     * @Route("/admin/category/add", name="admin_category_add")
     */
    public function addCategory(Request $request) {

        $category = new Category();

        $form = $this->createFormBuilder($category)
                ->add('title', TextType::class, array('label' => 'Kategori Başlık'))
                ->add('status', "choice", array(
                    "label" => "Kategori Durumu",
                    "choices" => array("1" => "Aktif", "0" => "Pasif"),
                    "multiple" => false,
                    "expanded" => true,
                    "required" => true
                ))
                ->add('save', SubmitType::class, array('label' => 'Kaydet'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_category_list'));
        }
        return $this->render('admin/category/categoryAdd.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * 
     * @Route("admin/category/ajax/allCategories",name="admin_category_list_ajaxdata")
     */
    public function allCategories(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')
                ->listAllPageCategories();

        $jsonData = [];
        foreach ($categories["records"] as $category) {
            $_titlePattern = "<a href='%s'>%s</a>";
            $title = $category->getTitle();
            $categoryUpateUrl = $this->generateUrl('admin_category_update', array("id" => $category->getId()));

            array_push($jsonData, array(sprintf($_titlePattern, $categoryUpateUrl, $title), $category->getStatus() == 1 ? "Aktif" : "Pasif"));
        }
        $response = new JsonResponse();
        $response->setData(array(
            'data' => $jsonData,
            'recordsTotal' => $categories["recordsCount"],
            'recordsFiltered' => $categories["recordsCount"]
        ));
        return $response;
    }

    /**
     * 
     * @Route("admin/category/update/{id}", name="admin_category_update", requirements={"id": "\d+"})
     */
    public function updateCategory(Request $request, $id) {

        $em = $this->getDoctrine()->getEntityManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);

        $form = $this->createFormBuilder($category)
                ->add('title', TextType::class, array('label' => 'Kategori Başlık'))
                ->add('status', "choice", array(
                    "label" => "Kategori Durumu",
                    "choices" => array("1" => "Aktif", "0" => "Pasif"),
                    "multiple" => false,
                    "expanded" => true,
                    "required" => true
                ))
                ->add('save', SubmitType::class, array('label' => 'Kaydet'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_category_list'));
        }
        return $this->render('admin/category/categoryEdit.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/category/delete/{id}", name="admin_category_delete", requirements={"id": "\d+"})
     */
    public function deleteCategory($id) {

        $em = $this->getDoctrine()->getEntityManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);
        $em->remove($category);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_category_list'));
    }

}

?>