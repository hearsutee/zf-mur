<?php

namespace Mur\Service;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Mur\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class MessageManager
 * @package Mur\Service
 */
class UserManager implements
    ServiceLocatorAwareInterface,
    DoctrineObjectManagerInterface
{
    use ServiceLocatorAwareTrait;

    use DoctrineObjectManagerTrait;

    protected $authManager;


    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $user = new User();

        $this->hydrate($data, $user);

        $this->record($user);

        return true;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        $em = $this->getEntityManager();


        $user = $em
            ->getRepository('Mur\Entity\User')
            ->findOneById($id);

        return $user;
    }

    /**
     * @return mixed
     */
    public function getAuthManager()
    {
        return $this->authManager;
    }

    /**
     * @param mixed $authManager
     */
    public function setAuthManager($authManager)
    {
        $this->authManager = $authManager;
    }


} 