<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 03/10/2014
 * Time: 16:03
 */

namespace Mur\Service;


use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Mur\Entity\Message;
use Mur\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class MessageManager implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function write(array $data)
    {
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $message = new Message();

        $hydrator = new DoctrineObject($em);
        $hydrator->hydrate($data, $message);

        $authManager = $this->getServiceLocator()->get('mur.auth.manager');

        $userConnected = $authManager->getUserConnected();

//        die(var_dump($userConnected));
        $message->setUser($userConnected);
        $message->setDateCreation(new \DateTime('now'));
        $this->record($message);


        return true;
    }

    public function update($message, $data)
    {
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $hydrator = new DoctrineObject($em);
        $hydrator->hydrate($data, $message);

        $this->record($message);

        return true;
    }

    public function getMessageById($id)
    {
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $message = $em
            ->getRepository('Mur\Entity\Message')
            ->findOneById($id);

        return $message;
    }

    public function record($object)
    {
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $em->persist($object);
        $em->flush();
    }
} 