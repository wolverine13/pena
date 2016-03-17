<?php
/**
 * Created by PhpStorm.
 * User: wolverine13
 * Date: 22.02.16
 * Time: 12:57
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Tests\Fixtures\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="KeyStatus")
 */

class KeyStatus
{
    /**
     * @ORM\Column(type="integer",length=1)
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=25)
     */

    private $status;

    /**
     * @ORM\OneToMany(targetEntity="Key", mappedBy="keyStatus")
     */
    protected $keys;

    public function __construct()
    {
        $this->keys = new ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return KeyStatus
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set status
     *
     * @param string $status
     *
     * @return KeyStatus
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add key
     *
     * @param \AppBundle\Entity\Key $key
     *
     * @return KeyStatus
     */
    public function addKey(\AppBundle\Entity\Key $key)
    {
        $this->keys[] = $key;

        return $this;
    }

    /**
     * Remove key
     *
     * @param \AppBundle\Entity\Key $key
     */
    public function removeKey(\AppBundle\Entity\Key $key)
    {
        $this->keys->removeElement($key);
    }

    /**
     * Get keys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKeys()
    {
        return $this->keys;
    }
}
