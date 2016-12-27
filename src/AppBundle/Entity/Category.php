<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="category",indexes={@ORM\Index(name="search_ind", columns={"slug"})})
 */
class Category
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;
    
    /**
     * @Gedmo\Slug(fields={"title","id"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $insert_date;
        
    /**
     * @ORM\Column(type="smallint",length=1)
     */
    private $status;
    
    public function getId() {
        return $this->id;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    public function getTitle() {
        return $this->title;
    }
    
    public function getSlug() {
        return $this->slug;
    }
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }
    public function getStatus() {
        return $this->status;
    }
}
?>