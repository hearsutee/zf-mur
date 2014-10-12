<?php

namespace Mur\Service;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Mur\Entity\Message;
use Mur\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class MessageManager
 * @package Mur\Service
 */
class MessageManager implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $hydrator;
    protected $entityManager;
    protected $authManager;


    /**
     * @param array $data
     * @return bool
     */
    public function write(array $data)
    {

        $message = new Message();
        $this->hydrate($data, $message);

        $userConnected = $this->getAuthManager()->getUserConnected();
        $message->setUser($userConnected);
        $message->setDateCreation(new \DateTime('now'));

        $this->record($message);

        return true;
    }

    /**
     * @param array $data
     * @param $entity
     * @return bool
     */
    public function update($data, $entity)
    {

        $this->hydrate($data, $entity);
        $this->record($entity);

        return true;
    }


    /**
     * @param $entity
     * @return bool
     */
    public function delete($entity)
    {
        $em = $this->getEntityManager();

        $em->remove($entity);
        $em->flush();

        return true;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getMessageById($id)
    {
        $em = $this->getEntityManager();

        $message = $em
            ->getRepository('Mur\Entity\Message')
            ->findOneById($id);

        return $message;
    }


    /**
     * @param $entity
     * @return bool
     */
    public function record($entity)
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();

        return true;
    }

    /**
     * @param array $data
     * @param $entity
     */
    public function hydrate($data, $entity)
    {

        $hydrator = $this->getHydrator();
        $hydrator->hydrate($data, $entity);

    }

    public function getHydrator()
    {

        return $this->hydrator;
    }

    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
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