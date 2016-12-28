<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
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
    
    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="category")
     */
    private $pages;

    public function __construct() {
        $this->pages = new ArrayCollection();
    }
    
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

    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set insert_date
     *
     * @param \DateTime $insertDate
     * @return Category
     */
    public function setInsertDate($insertDate)
    {
        $this->insert_date = $insertDate;

        return $this;
    }

    /**
     * Get insert_date
     *
     * @return \DateTime 
     */
    public function getInsertDate()
    {
        return $this->insert_date;
    }

    /**
     * Add pages
     *
     * @param \AppBundle\Entity\Page $pages
     * @return Category
     */
    public function addPage(\AppBundle\Entity\Page $pages)
    {
        $this->pages[] = $pages;

        return $this;
    }

    /**
     * Remove pages
     *
     * @param \AppBundle\Entity\Page $pages
     */
    public function removePage(\AppBundle\Entity\Page $pages)
    {
        $this->pages->removeElement($pages);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPages()
    {
        return $this->pages;
    }
}
