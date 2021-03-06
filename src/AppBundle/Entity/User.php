<?php
/**
 * Created by PhpStorm.
 * User: wolverine13
 * Date: 24.01.16
 * Time: 10:56
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Tests\Fixtures\Entity;

/**
 *  @ORM\Table(name="app_user")
 *  @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 *  @ORM\HasLifecycleCallbacks
 */

class User implements UserInterface, \Serializable
{
    /**
     *  @ORM\Column(type="integer")
     *  @ORM\Id
     *  @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=20,nullable=false)
     */

    private $givenName;

    /**
     * @ORM\Column(type="string",length=20,nullable=false)
     */
    private $surName;
    /**
     *  @ORM\Column(type="string",length=25,unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string",length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string",length=25,unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active",type="boolean")
     */
    private $isActive;
    // * @ORM\Column(name="role",type="integer", length=1,nullable=false)
    /**
     * @ORM\ManyToOne(targetEntity="Role",inversedBy="users")
     * @ORM\JoinColumn(name="role",referencedColumnName="id")
     */
    private $role;

    /**
     * @ORM\Column(name="store",type="integer",nullable=false)
     */
    private $storeId;

    /**
     * @ORM\Column(name="created",type="datetime", nullable=false)
     * @ORM\Version
     * @var \DateTime
     */
    private $created;

    /**
     * @ORM\Column(name="createdBy",type="integer",nullable=false)
     */

    private $createdBy;

    /**
     * @ORM\Column(name="uModBy",type="integer",nullable=true)
     */
    private $uModBy;

    /**
     * @ORM\Column(name="modDate",type="datetime", nullable=true)
     */
    private $modDate;
    /**
     * @ORM\Column(name="passAge",type="datetime", nullable=false)
     */
    private $passAge;

    public function _construct()
    {
        $this->isActive=true;
        $this->created = new \DateTime();
        $this->setUModBy(0);
       // $this->passAge = new \DateTime();
    }
    public function _contruct($username,$password,$role,$store)
    {
        $this->username = $username;
        $this->password = $password;
        $this->isActive = 1;
        $this->role = $role;
        $this->storeId=$store;
        $this->created =  new \DateTime();
      //  $this->passAge = new \DateTime()
        //modUserby = $this->get('security.token_storage')->getToken()->getUser();
        $this->setUModBy(); // Need to change to loged user
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
        return null;
    }
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
        return $this->password;
    }

    public function getRole()
    {
        // TODO: Implement getRoles() method.
        return $this->role;
    }
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
                $this->id,
                $this->username,
                $this->password,

            )
        );

    }
    /**  @see \Serializable::unserialize() */
    public function unserialize($unserialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($unserialized);
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
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
     * Set role
     *
     * @param integer $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRoles()
    {
       // return $this->role;
        switch($this->getRole()->getId())
        {
            case 1:return array("ROLE_GL_ADMIN");break;
            case 2:return array("ROLE_ADMIN");break;
            case 3:return array("ROLE_USER");break;
        }
    }

    /**
     * Set storeId
     *
     * @param integer $storeId
     *
     * @return User
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;

        return $this;
    }

    /**
     * Get storeId
     *
     * @return integer
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set uModBy
     *
     * @param string $uModBy
     *
     * @return User
     */
    public function setUModBy($uModBy)
    {
        $this->uModBy = $uModBy;

        return $this;
    }

    /**
     * Get uModBy
     *
     * @return string
     */
    public function getUModBy()
    {
        return $this->uModBy;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     *
     * @return User
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set modDate
     *
     * @param \DateTime $modDate
     *
     * @return User
     */
    public function setModDate($modDate)
    {
        $this->modDate = $modDate;

        return $this;
    }

    /**
     * Get modDate
     *
     * @return \DateTime
     */
    public function getModDate()
    {
        return $this->modDate;
    }

    /**
     * Set givenName
     *
     * @param string $givenName
     *
     * @return User
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;

        return $this;
    }

    /**
     * Get givenName
     *
     * @return string
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * Set surName
     *
     * @param string $surName
     *
     * @return User
     */
    public function setSurName($surName)
    {
        $this->surName = $surName;

        return $this;
    }

    /**
     * Get surName
     *
     * @return string
     */
    public function getSurName()
    {
        return $this->surName;
    }
    public function checkPassAge()
    {
        $currDate = new \DateTime();
        $expPassDate = strtotime($this->passAge . "40 days" );
        if($currDate >= $expPassDate)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Set passAge
     *
     * @param \DateTime $passAge
     *
     * @return User
     */
    public function setPassAge($passAge)
    {
        $this->passAge = $passAge;

        return $this;
    }

    /**
     * Get passAge
     *
     * @return \DateTime
     */
    public function getPassAge()
    {
        return $this->passAge;
    }
}
