<?php

namespace EverFail\RegistrationBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use EverFail\RegistrationBundle\Entity\User;

class Registration
{
    
    protected $user;
    protected $termsAccepted;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (Boolean) $termsAccepted;
    }
}

?>
