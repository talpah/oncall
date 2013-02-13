<?php

namespace THL\OnCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedule
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="THL\OnCallBundle\Entity\ScheduleRepository")
 */
class Schedule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="actor_id", type="integer")
     */
    private $actor_id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_custom", type="boolean")
     */
    private $is_custom;


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
     * Set actor_id
     *
     * @param integer $actorId
     * @return Schedule
     */
    public function setActorId($actorId)
    {
        $this->actor_id = $actorId;
    
        return $this;
    }

    /**
     * Get actor_id
     *
     * @return integer 
     */
    public function getActorId()
    {
        return $this->actor_id;
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
     * Set is_custom
     *
     * @param boolean $isCustom
     * @return Schedule
     */
    public function setIsCustom($isCustom)
    {
        $this->is_custom = $isCustom;
    
        return $this;
    }

    /**
     * Get is_custom
     *
     * @return boolean 
     */
    public function getIsCustom()
    {
        return $this->is_custom;
    }
}
