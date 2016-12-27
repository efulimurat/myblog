<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller {

    /**
     * @Route("/admin/category/list", name="admin_category_list")
     */
    public function listCategories() {
        return $this->render('admin/default/index.html.twig');
    }

    /**
     * @Route("/admin/category/add", name="admin_category_add")
     */
    public function addCategory() {
        return $this->render('admin/default/index.html.twig');
    }

}

?>