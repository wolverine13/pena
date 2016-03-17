<?php
/**
 * Created by PhpStorm.
 * User: wolverine13
 * Date: 01.02.16
 * Time: 16:03
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Tests\Fixtures\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="Key")
 */

class Key
{


    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="keys")
     * @ORM\JoinColumn(name="Room",referencedColumnName="id")
     */
    private $id;
      /**
       * @ORM\Column(name="descr",type="string",length=25)
       */
    private $key_descr;

    /**
     * @ORM\Column(name="storeId",type="integer")
     */
    private $storeId;

    /**
     * @ORM\ManyToOne(targetEntity="KeyStatus",inversedBy="keys")
     * @ORM\JoinColumn(name="KeyStatus",referencedColumnName="id")
     */
    private $keyStatus;



    public function _construct()
    {

    }

    public function getStoreId()
    {
        return $this->storeId;
    }
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }

    public function getKey_Status()
    {
        return $this->keyStatus;
    }
    public function setKey_status($keyStatus)
    {
        $this->keyStatus = $keyStatus;
    }



    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Key
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
     * Set keyDescr
     *
     * @param string $keyDescr
     *
     * @return Key
     */
    public function setKeyDescr($keyDescr)
    {
        $this->key_descr = $keyDescr;

        return $this;
    }

    /**
     * Get keyDescr
     *
     * @return string
     */
    public function getKeyDescr()
    {
        return $this->key_descr;
    }

    /**
     * Set keyStatus
     *
     * @param integer $keyStatus
     *
     * @return Key
     */
    public function setKeyStatus($keyStatus)
    {
        $this->keyStatus = $keyStatus;

        return $this;
    }

    /**
     * Get keyStatus
     *
     * @return integer
     */
    public function getKeyStatus()
    {
        return $this->keyStatus;
    }
}
