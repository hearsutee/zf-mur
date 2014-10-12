<?php

namespace Mur\Service;



use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class MessageManagerFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $messageManager = new MessageManager();

        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');

        $messageManager->setEntityManager($em);
        $messageManager->setHydrator(new DoctrineObject($em));

        $authManager = $serviceLocator->get('mur.auth.manager');
        $messageManager->setAuthManager($authManager);

        return $messageManager;
    }
}

