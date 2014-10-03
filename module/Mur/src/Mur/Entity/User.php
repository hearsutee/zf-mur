<?php

namespace Mur\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends ModelAbstract
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
     * @ORM\Column(name="userName", type="string", length=255, nullable=false)
     */
    private $userName;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $password = '';


    /**
     * @var boolean
     *
     * @ORM\Column(name="isAdmin", type="boolean", nullable=false)
     */
    private $isAdmin;


    protected $inputFilter;


    //=======GETTERS/SETTERS=======\\

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
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return boolean
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set isAdmin
     *
     * @param boolean $isAdmin
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userName
     *
     * @param string $userName
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $plaintextPassword
     * @return $this
     */
    public function setPassword($plaintextPassword)
    {
        $this->password = crypt($plaintextPassword);
        return $this;
    }

    //======InputFilter=======\\

//    /**
//     * Set input filter
//     *
//     * @param  InputFilterInterface $inputFilter
//     * @return InputFilterAwareInterface
//     */
//    public function setInputFilter(InputFilterInterface $inputFilter)
//    {
//        // TODO: Implement setInputFilter() method.
//    }
//
//    /**
//     * Retrieve input filter
//     *
//     * @return InputFilterInterface
//     */
//    public function getInputFilter()
//    {
//        // TODO: Implement getInputFilter() method.
//    }

    public function __toString()
    {
        return $this->userName;
    }

}
