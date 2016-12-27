<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Category as Category;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="page")
 * @Vich\Uploadable
 */
class Page {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="categoryId", referencedColumnName="id")
     */
    private $categoryId;
    
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
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     * @Vich\UploadableField(mapping="page_image", fileNameProperty="image", nullable=true)
     * @ORM\Column(type="string")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $insert_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_date;

    /**
     * @ORM\Column(type="smallint",length=1)
     * @Assert\Choice({"0","1"})
     */
    private $status;

    public function getId() {
        return $this->id;
    }
    
    public function setCategoryId($categoryId) {
        $this->category_id = $categoryId;
        return $this;
    }

    public function getCategoryId() {
        return $this->category_id;
    }
    
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImageFile(File $file = null) {
        $this->imageFile = $file;
        $this->update_date = new \DateTimeImmutable();
    }

    public function getImageFile() {
        return $this->imageFile;
    }

    public function getSlug() {
        return $this->slug;
    }

}

?>