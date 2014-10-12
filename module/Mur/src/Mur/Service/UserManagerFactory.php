<?php

namespace Mur\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class UserManagerFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userManager = new UserManager();

        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');

        $userManager->setEntityManager($em);
        $userManager->setHydrator(new DoctrineObject($em));

        $authManager = $serviceLocator->get('mur.auth.manager');
        $userManager->setAuthManager($authManager);

        return $userManager;
    }
}

