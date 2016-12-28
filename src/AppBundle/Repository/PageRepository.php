<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository {

    public function listAllPages($start = 0, $length = 10, $search = NULL) {

        $searchAdd = "p.title IS NOT NULL";
        if ($search != NULL) {
            $searchAdd = " p.title LIKE '$search%' ";
        }
        $query = $this->getEntityManager()
                ->createQueryBuilder()->select("p")
                ->from("AppBundle:Page", "p")
                ->orderBy("p.id", "DESC")
                ->where($searchAdd)
                ->setMaxResults($length)
                ->setFirstResult($start);
        $paginator = new Paginator($query, $fetchJoinCollection = true);

        $c = count($paginator);
        $pageData = [];

        foreach ($paginator as $page) {
            $pageData[] = $page;
        }
        return [
            "records" => $pageData,
            "recordsCount" => $c
        ];
    }

    public function listHomepagePages($start = 0) {
        $length = 6;
        $query = $this->getEntityManager()
                ->createQueryBuilder()->select("p")
                ->from("AppBundle:Page", "p")
                ->orderBy("p.id", "DESC")
                ->where("p.status = 1")
                ->setMaxResults($length)
                ->setFirstResult($start);
        $paginator = new Paginator($query, $fetchJoinCollection = true);

        $c = count($paginator);
        $pageData = [];
        foreach ($paginator as $page) {
            $pageData[] = [
                "id" => $page->getId(),
                "title" => $page->getTitle(),
                "content" => $page->getContent(),
                "image" => $page->getImage(),
                "imageFile" => $page->getImageFile(),
                "slug" => $page->getSlug()
            ];
        }
        return [
            "records" => $pageData,
            "recordsCount" => $c
        ];
    }
    
     public function pageDetail($slug) {

         $query = $this->getEntityManager()
                ->createQueryBuilder()->select("p")
                ->from("AppBundle:Page", "p")
                ->where("p.slug = ? AND p.status = 1")
                 ->setParameter(1, $slug)
                ->setMaxResults($length)
                ->setFirstResult($start);

        $page = $query->getResult();
        print_r($page);exit;
        return [
            "records" => $pageData,
            "recordsCount" => $c
        ];
    }

}
