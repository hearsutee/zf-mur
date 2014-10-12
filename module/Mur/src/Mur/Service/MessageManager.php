<?php

namespace Mur\Service;


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

    use DoctrineObjectManagerTrait;

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