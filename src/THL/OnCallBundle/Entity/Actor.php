<?php

namespace THL\OnCallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="THL\OnCallBundle\Entity\ActorRepository")
 */

class Actor {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    /**
     * @var integer
     *
     * @ORM\Column(name="order_index", type="integer")
     */
    private $order_index;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $is_active;

    /**
     * @return int
     */
    public function getOrderIndex() {
        return $this->order_index;
    }

    /**
     * Set Order
     *
     * @param int $order_index
     *
     * @return Actor
     */
    public function setOrderIndex($order_index) {
        $this->order_index=$order_index;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Actor
     */
    public function setName($name) {
        $this->name=$name;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Actor
     */
    public function setEmail($email) {
        $this->email=$email;

        return $this;
    }

    /**
     * Get is_active
     *
     * @return boolean
     */
    public function getIsActive() {
        return $this->is_active;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     *
     * @return Actor
     */
    public function setIsActive($isActive) {
        $this->is_active=$isActive;

        return $this;
    }
}
