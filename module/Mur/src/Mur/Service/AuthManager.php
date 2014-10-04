<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 03/10/2014
 * Time: 14:23
 */

namespace Mur\Service;


use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Mur\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class AuthManager implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;


    public function register(array $data)
    {
        $user = new User();

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $hydrator = new DoctrineObject($em);
        $hydrator->hydrate($data, $user);

        $user->setRole('member');

        $em->persist($user);
        $em->flush();


    }

    public function login(array $data)
    {
        $authService = $this
            ->getServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');

        $adapter = $authService->getAdapter();

        $adapter->setIdentityValue($data['username']);
        $adapter->setCredentialValue($data['password']);

        $authResult = $authService->authenticate();

        if ($authResult->isValid()) {
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
            return true;
        }

        return false;
    }

    public function logout()
    {
        $authService = $this
            ->getServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');

        $authService->getStorage()->clear();
    }



    public function getUserConnected()
    {

        $authService = $this
            ->getServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');

        $loggedUser = $authService->getIdentity();


        return $loggedUser;
    }

    public function getRole()
    {

        $authService = $this
            ->getServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');

        $loggedUser = $authService->getIdentity();
        $role =  $loggedUser->getRole();


        return $role;
    }


}