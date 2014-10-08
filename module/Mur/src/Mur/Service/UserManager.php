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
        $em = $this
            ->getServiceLocator()
            ->get('doctrine.entitymanager.orm_default');

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
        $em = $this
            ->getServiceLocator()
            ->get('doctrine.entitymanager.orm_default');

        $em->persist($entity);
        $em->flush();
    }

    /**
     * @param array $data
     * @param $entity
     */
    public function hydrate(array $data, $entity)
    {
        $em = $this
            ->getServiceLocator()
            ->get('doctrine.entitymanager.orm_default');

        $hydrator = new DoctrineObject($em);
        $hydrator->hydrate($data, $entity);
    }
} 