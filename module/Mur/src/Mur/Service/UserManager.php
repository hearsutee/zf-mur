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
class UserManager implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $hydrator;
    protected $entityManager;
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
     * @param array $data
     * @return bool
     */
    public function update(array $data)
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
     * @param $entity
     */
    public function record($entity)
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();
    }

    /**
     * @param array $data
     * @param $entity
     */
    public function hydrate(array $data, $entity)
    {
        $em = $this->getEntityManager();

        $hydrator = new DoctrineObject($em);
        $hydrator->hydrate($data, $entity);
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

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     * @param mixed $hydrator
     */
    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
    }
} 