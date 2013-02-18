<?php

namespace THL\OnCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedule
 *
 * @ORM\Table(name="schedule")
 * @ORM\Entity
 */
class Schedule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_custom", type="boolean", nullable=false)
     */
    private $isCustom;

    /**
     * @var \Actor
     *
     * @ORM\ManyToOne(targetEntity="Actor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="actor_id", referencedColumnName="id")
     * })
     */
    private $actor;



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
     * Set date
     *
     * @param \DateTime $date
     * @return Schedule
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set isCustom
     *
     * @param boolean $isCustom
     * @return Schedule
     */
    public function setIsCustom($isCustom)
    {
        $this->isCustom = $isCustom;

        return $this;
    }

    /**
     * Get isCustom
     *
     * @return boolean
     */
    public function getIsCustom()
    {
        return $this->isCustom;
    }

    /**
     * Set actor
     *
     * @param \THL\OnCallBundle\Entity\Actor $actor
     * @return Schedule
     */
    public function setActor(\THL\OnCallBundle\Entity\Actor $actor = null)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Get actor
     *
     * @return \THL\OnCallBundle\Entity\Actor
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * Returns date
     * @return string
     */
    public function __toString() {
        return $this->getDate()->format('Y-m-d');
    }
}
