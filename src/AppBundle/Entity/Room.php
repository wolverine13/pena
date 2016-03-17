<?php
/**
 * Created by PhpStorm.
 * User: wolverine13
 * Date: 21.02.16
 * Time: 13:54
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Tests\Fixtures\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="Room")
 */
class Room
{
 /**
  * @ORM\Column(type="integer",length=2)
  * @ORM\GeneratedValue(strategy="AUTO")
  * @ORM\Id
  */
 private $id;

 /**
  * @ORM\Column(name="descr",type="string",length=25)
  */
 private $roomName;

 /**
  * @ORM\OneToMany(targetEntity="Key",mappedBy="id")
  */
 protected $keys;

 public function __construct()
 {
  $this->keys = new ArrayCollection();
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
     * Set roomName
     *
     * @param string $roomName
     *
     * @return Room
     */
    public function setRoomName($roomName)
    {
        $this->roomName = $roomName;

        return $this;
    }

    /**
     * Get roomName
     *
     * @return string
     */
    public function getRoomName()
    {
        return $this->roomName;
    }

    /**
     * Add key
     *
     * @param \AppBundle\Entity\Key $key
     *
     * @return Room
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
