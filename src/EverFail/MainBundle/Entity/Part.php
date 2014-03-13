<?php

namespace EverFail\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Part
 */
class Part
{
    /**
     * @var string
     */
    private $partName;

    /**
     * @var string
     */
    private $price;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \EverFail\MainBundle\Entity\Vendor
     */
    private $vendor;

    /**
     * @var \EverFail\MainBundle\Entity\Category
     */
    private $category;

    /**
     * @var \EverFail\MainBundle\Entity\Service
     */
    private $service;


    /**
     * Set partName
     *
     * @param string $partName
     * @return Part
     */
    public function setPartName($partName)
    {
        $this->partName = $partName;

        return $this;
    }

    /**
     * Get partName
     *
     * @return string 
     */
    public function getPartName()
    {
        return $this->partName;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Part
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set vendor
     *
     * @param \EverFail\MainBundle\Entity\Vendor $vendor
     * @return Part
     */
    public function setVendor(\EverFail\MainBundle\Entity\Vendor $vendor = null)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return \EverFail\MainBundle\Entity\Vendor 
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set category
     *
     * @param \EverFail\MainBundle\Entity\Category $category
     * @return Part
     */
    public function setCategory(\EverFail\MainBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \EverFail\MainBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set service
     *
     * @param \EverFail\MainBundle\Entity\Service $service
     * @return Part
     */
    public function setService(\EverFail\MainBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \EverFail\MainBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }
    
    public function __toString() {
        return "$this->partName";;
    }
}
