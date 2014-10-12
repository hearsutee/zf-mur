<?php

namespace Mur\Service;



use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class AuthManagerFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authManager = new AuthManager();

        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');

        $authManager->setEntityManager($em);
        $authManager->setHydrator(new DoctrineObject($em));

        return $authManager;
    }
}
