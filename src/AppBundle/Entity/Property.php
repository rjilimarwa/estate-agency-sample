<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // pour créer le slug

/**
 * Property
 *
 * @ORM\Table(name="property")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropertyRepository")
 */
class Property
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", length=255, unique=true)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="area", type="integer")
     */
    private $area; //surface

    /**
     * @var int
     *
     * @ORM\Column(name="roomNumber", type="integer")
     */
    private $roomNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="living_room_number", type="integer", nullable=true)
     */
    private $livingRoomNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="bath_room_number", type="integer", nullable=true)
     */
    private $bathRoomNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="kitchen_number", type="integer", nullable=true)
     */
    private $kitchenNumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="garden", type="boolean")
     */
    private $garden;

    /**
     * @var bool
     *
     * @ORM\Column(name="garage", type="boolean")
     */
    private $garage;

    /**
     * @var bool
     *
     * @ORM\Column(name="parking", type="boolean")
     */
    private $parking;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activate", type="boolean")
     */
    private $activate;

    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="string")
     */
    private $operation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Photo", cascade={"persist", "remove"}, mappedBy="property")
     */
    private $photos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ville")
     */
    private $ville;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Region")
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     */
    private $category;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

  
    /**
     * Set title
     *
     * @param string $title
     *
     * @return Property
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Property
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Property
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Property
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set area
     *
     * @param integer $area
     *
     * @return Property
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return integer
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set roomNumber
     *
     * @param integer $roomNumber
     *
     * @return Property
     */
    public function setRoomNumber($roomNumber)
    {
        $this->roomNumber = $roomNumber;

        return $this;
    }

    /**
     * Get roomNumber
     *
     * @return integer
     */
    public function getRoomNumber()
    {
        return $this->roomNumber;
    }

    /**
     * Set livingRoomNumber
     *
     * @param integer $livingRoomNumber
     *
     * @return Property
     */
    public function setLivingRoomNumber($livingRoomNumber)
    {
        $this->livingRoomNumber = $livingRoomNumber;

        return $this;
    }

    /**
     * Get livingRoomNumber
     *
     * @return integer
     */
    public function getLivingRoomNumber()
    {
        return $this->livingRoomNumber;
    }

    /**
     * Set bathRoomNumber
     *
     * @param integer $bathRoomNumber
     *
     * @return Property
     */
    public function setBathRoomNumber($bathRoomNumber)
    {
        $this->bathRoomNumber = $bathRoomNumber;

        return $this;
    }

    /**
     * Get bathRoomNumber
     *
     * @return integer
     */
    public function getBathRoomNumber()
    {
        return $this->bathRoomNumber;
    }

    /**
     * Set kitchenNumber
     *
     * @param integer $kitchenNumber
     *
     * @return Property
     */
    public function setKitchenNumber($kitchenNumber)
    {
        $this->kitchenNumber = $kitchenNumber;

        return $this;
    }

    /**
     * Get kitchenNumber
     *
     * @return integer
     */
    public function getKitchenNumber()
    {
        return $this->kitchenNumber;
    }

    /**
     * Set garden
     *
     * @param boolean $garden
     *
     * @return Property
     */
    public function setGarden($garden)
    {
        $this->garden = $garden;

        return $this;
    }

    /**
     * Get garden
     *
     * @return boolean
     */
    public function getGarden()
    {
        return $this->garden;
    }

    /**
     * Set garage
     *
     * @param boolean $garage
     *
     * @return Property
     */
    public function setGarage($garage)
    {
        $this->garage = $garage;

        return $this;
    }

    /**
     * Get garage
     *
     * @return boolean
     */
    public function getGarage()
    {
        return $this->garage;
    }

    /**
     * Set parking
     *
     * @param boolean $parking
     *
     * @return Property
     */
    public function setParking($parking)
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * Get parking
     *
     * @return boolean
     */
    public function getParking()
    {
        return $this->parking;
    }

    /**
     * Set activate
     *
     * @param boolean $activate
     *
     * @return Property
     */
    public function setActivate($activate)
    {
        $this->activate = $activate;

        return $this;
    }

    /**
     * Get activate
     *
     * @return boolean
     */
    public function getActivate()
    {
        return $this->activate;
    }

    /**
     * Set operation
     *
     * @param string $operation
     *
     * @return Property
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Property
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Property
     */
    public function setImage(\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add photo
     *
     * @param \AppBundle\Entity\Photo $photo
     *
     * @return Property
     */
    public function addPhoto(\AppBundle\Entity\Photo $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \AppBundle\Entity\Photo $photo
     */
    public function removePhoto(\AppBundle\Entity\Photo $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set ville
     *
     * @param \AppBundle\Entity\Ville $ville
     *
     * @return Property
     */
    public function setVille(\AppBundle\Entity\Ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \AppBundle\Entity\Ville
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set region
     *
     * @param \AppBundle\Entity\Region $region
     *
     * @return Property
     */
    public function setRegion(\AppBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \AppBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Property
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
