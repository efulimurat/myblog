<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="page",indexes={@ORM\Index(name="search_ind", columns={"slug"})})
 */
class Page
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;
    
    /**
     * @ORM\Column(type="string")
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $insert_date;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $update_date;
    
    /**
     * @ORM\Column(type="smallint",length=1)
     * @Assert\Choice(choices = {"0","1"}, multiple = false, message = "Durum seçiniz.")
     */
    private $status;
    
    public function setTitle($title){
        $this->title = $title;
    }
    public function getTitle(){
        return $this->title;
    }
    public function setContent($content){
        $this->content = $content;
    }
    public function getContent(){
        return $this->content;
    }
     public function setStatus($status){
        $this->status = $status;
    }
    public function getStatus(){
        return $this->status;
    }
}
?>