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
                ->from("AppBundle:Page","p")
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

}
