<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ActivatedTrait
{

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $activated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deactivatedAt;

    /**
     * Set activated
     *
     * @param boolean $activated
     *
     * @return $this
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * Get activated
     *
     * @return boolean
     */
    public function isActivated()
    {
        return $this->activated;
    }

    /**
     * Set deactivatedAt
     *
     * @param \DateTime $deactivatedAt
     *
     * @return $this
     */
    public function setDeactivatedAt($deactivatedAt)
    {
        $this->deactivatedAt = $deactivatedAt;

        return $this;
    }

    /**
     * Get deactivatedAt
     *
     * @return \DateTime
     */
    public function getDeactivatedAt()
    {
        return $this->deactivatedAt;
    }

    /**
     * Initialization
     *
     * @param boolean $activate
     * @ORM\PrePersist
     */
    public function initActivatedTrait()
    {
        $this->activated = true;
    }

}
