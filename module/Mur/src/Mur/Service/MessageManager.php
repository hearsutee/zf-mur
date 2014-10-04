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
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $message = new Message();

        $hydrator = new DoctrineObject($em);
        $hydrator->hydrate($data, $message);

        $authManager = $this->getServiceLocator()->get('mur.auth.manager');

        $userConnected = $authManager->getUserConnected();

        $message->setUser($userConnected);
        $message->setDateCreation(new \DateTime('now'));
        $this->record($message);


        return true;
    }

    /**
     * @param $message
     * @param $data
     * @return bool
     */
    public function update($message, $data)
    {
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $hydrator = new DoctrineObject($em);
        $hydrator->hydrate($data, $message);

        $this->record($message);

        return true;
    }

    /**
     * @param $message
     * @return bool
     */
    public function delete($message)
    {
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $em->remove($message);
        $em->flush();

        return true;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getMessageById($id)
    {
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $message = $em
            ->getRepository('Mur\Entity\Message')
            ->findOneById($id);

        return $message;
    }

    /**
     * @param $object
     */
    public function record($object)
    {
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $em->persist($object);
        $em->flush();
    }
} 