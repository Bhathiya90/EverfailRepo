<?php

namespace EverFail\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 */
class Service
{
    /**
     * @var \DateTime
     */
    private $serviceDate;

    /**
     * @var string
     */
    private $serviceCharge;

    /**
     * @var string
     */
    private $note;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \EverFail\MainBundle\Entity\Car
     */
    private $car;

    /**
     * @var \EverFail\MainBundle\Entity\Customer
     */
    private $cust;

    /**
     * @var \EverFail\MainBundle\Entity\Invoice
     */
    private $invoice;


    /**
     * Set serviceDate
     *
     * @param \DateTime $serviceDate
     * @return Service
     */
    public function setServiceDate($serviceDate)
    {
        $this->serviceDate = $serviceDate;

        return $this;
    }

    /**
     * Get serviceDate
     *
     * @return \DateTime 
     */
    public function getServiceDate()
    {
        return $this->serviceDate;
    }

    /**
     * Set serviceCharge
     *
     * @param string $serviceCharge
     * @return Service
     */
    public function setServiceCharge($serviceCharge)
    {
        $this->serviceCharge = $serviceCharge;

        return $this;
    }

    /**
     * Get serviceCharge
     *
     * @return string 
     */
    public function getServiceCharge()
    {
        return $this->serviceCharge;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Service
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
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
     * Set car
     *
     * @param \EverFail\MainBundle\Entity\Car $car
     * @return Service
     */
    public function setCar(\EverFail\MainBundle\Entity\Car $car = null)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car
     *
     * @return \EverFail\MainBundle\Entity\Car 
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * Set cust
     *
     * @param \EverFail\MainBundle\Entity\Customer $cust
     * @return Service
     */
    public function setCust(\EverFail\MainBundle\Entity\Customer $cust = null)
    {
        $this->cust = $cust;

        return $this;
    }

    /**
     * Get cust
     *
     * @return \EverFail\MainBundle\Entity\Customer 
     */
    public function getCust()
    {
        return $this->cust;
    }

    /**
     * Set invoice
     *
     * @param \EverFail\MainBundle\Entity\Invoice $invoice
     * @return Service
     */
    public function setInvoice(\EverFail\MainBundle\Entity\Invoice $invoice = null)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return \EverFail\MainBundle\Entity\Invoice 
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
    
    public function __toString() {
        return "$this->id";
    }
    
}
