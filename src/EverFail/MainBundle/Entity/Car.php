<?php

namespace EverFail\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 */
class Car
{
    /**
     * @var string
     */
    private $regNumber;

    /**
     * @var string
     */
    private $model;

    /**
     * @var \DateTime
     */
    private $manufactureYear;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set regNumber
     *
     * @param string $regNumber
     * @return Car
     */
    public function setRegNumber($regNumber)
    {
        $this->regNumber = $regNumber;

        return $this;
    }

    /**
     * Get regNumber
     *
     * @return string 
     */
    public function getRegNumber()
    {
        return $this->regNumber;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set manufactureYear
     *
     * @param \DateTime $manufactureYear
     * @return Car
     */
    public function setManufactureYear($manufactureYear)
    {
        $this->manufactureYear = $manufactureYear;

        return $this;
    }

    /**
     * Get manufactureYear
     *
     * @return \DateTime 
     */
    public function getManufactureYear()
    {
        return $this->manufactureYear;
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
    
    public function __toString() {
        return "$this->regNumber";
    }
}
