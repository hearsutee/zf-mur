<?php


namespace Mur\Service;



use Mur\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class AuthManager
 * @package Mur\Service
 */
class AuthManager implements
    ServiceLocatorAwareInterface,
    DoctrineObjectManagerInterface
{
    use ServiceLocatorAwareTrait;

    use DoctrineObjectManagerTrait;

    protected $authService;

    /**
     * @return mixed
     */
    public function getAuthService()
    {
        return $this->authService;
    }


    public function setAuthService($authService)
    {
        $this->authService = $authService;

        return $this;
    }

    /**
     * @param array $data
     */
    public function register(array $data)
    {

        $user = $this->getServiceLocator()->get('mur.user.entity');

        $em = $this->getEntityManager();
        $hydrator = $this->getHydrator();

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
        $authService = $this->getAuthService();
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
        $authService = $this->getAuthService();
        $authService->getStorage()->clear();
    }


    /**
     * @return User
     */
    public function getUserConnected()
    {

        $authService = $this->getAuthService();
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