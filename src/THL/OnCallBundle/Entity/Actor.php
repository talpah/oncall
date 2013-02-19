<?php

namespace THL\OnCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actor
 *
 * @ORM\Table(name="actor")
 * @ORM\Entity(repositoryClass="THL\OnCallBundle\Entity\ActorRepository")
 */
class Actor
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="order_index", type="integer", nullable=false)
     */
    private $orderIndex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reference_date", type="date", nullable=false)
     */
    private $referenceDate;



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
     * Set name
     *
     * @param string $name
     * @return Actor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Actor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set orderIndex
     *
     * @param integer $orderIndex
     * @return Actor
     */
    public function setOrderIndex($orderIndex)
    {
        $this->orderIndex = $orderIndex;

        return $this;
    }

    /**
     * Get orderIndex
     *
     * @return integer
     */
    public function getOrderIndex()
    {
        return $this->orderIndex;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Actor
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set referenceDate
     *
     * @param \DateTime $referenceDate
     * @return Actor
     */
    public function setReferenceDate($referenceDate)
    {
        $this->referenceDate = $referenceDate;

        return $this;
    }

    /**
     * Get referenceDate
     *
     * @return \DateTime
     */
    public function getReferenceDate()
    {
        return $this->referenceDate;
    }

    /**
     * Returns name
     *
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }

}
