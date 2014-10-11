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


    /**
     * @param array $data
     * @return bool
     */
    public function write(array $data)
    {

        $message = new Message();

        $this->hydrate($data, $message);

        $authManager = $this->getServiceLocator()->get('mur.auth.manager');
        $userConnected = $authManager->getUserConnected();

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
        $em = $this
            ->getServiceLocator()
            ->get('doctrine.entitymanager.orm_default');

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
        $em = $this
            ->getServiceLocator()
            ->get('doctrine.entitymanager.orm_default');

        $message = $em
            ->getRepository('Mur\Entity\Message')
            ->findOneById($id);

        return $message;
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

        return true;
    }

    /**
     * @param array $data
     * @param $entity
     */
    public function hydrate($data, $entity)
    {
        $em = $this
            ->getServiceLocator()
            ->get('doctrine.entitymanager.orm_default');

        $hydrator = new DoctrineObject($em);
        $hydrator->hydrate($data, $entity);

    }
} 