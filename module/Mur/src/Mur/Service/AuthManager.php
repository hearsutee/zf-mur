<?php


namespace Mur\Service;


use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Mur\Acl\Acl;
use Mur\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class AuthManager
 * @package Mur\Service
 */
class AuthManager implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @param array $data
     */
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

    /**
     * @param array $data
     * @return bool
     */
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

    /**
     *
     */
    public function logout()
    {
        $authService = $this
            ->getServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');

        $authService->getStorage()->clear();
    }


    /**
     * @return User
     */
    public function getUserConnected()
    {

        $authService = $this
            ->getServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');

        $loggedUser = $authService->getIdentity();

        if(!$loggedUser){
            return false;
        }

        return $loggedUser;
    }

    /**
     * @return string
     */
    public function getRole()
    {

        return !$this->getUserConnected() ? 'guest' : $this->getUserConnected()->getRole();
    }




}