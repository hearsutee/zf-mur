<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 03/10/2014
 * Time: 14:23
 */

namespace Mur\Service;


use Mur\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class AuthManager implements ServiceLocatorAwareInterface
{
  use ServiceLocatorAwareTrait;

    public function login(array $data)
    {
        $authService = $this
            ->getServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');

        $adapter = $authService->getAdapter();

        $adapter->setIdentityValue($data['username']);
        $adapter->setCredentialValue($data['password']);

        $authResult = $authService->authenticate();

        if($authResult->isValid()) {
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
             return $identity ;
        }

        return false;
    }

    public function register(array $data)
    {
        $user = new User();

        $user->exchangeArray($data);
        $user->setIsAdmin(false);

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $em->persist($user);
        $em->flush();


    }

    public function logout(){

    }
}