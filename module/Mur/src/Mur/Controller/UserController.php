<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 01/10/2014
 * Time: 09:59
 */

namespace Mur\Controller;

use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class UserController extends AbstractActionController
{

    protected $em;

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $users = $em->getRepository('Mur\Entity\User')->findAll();

        return new ViewModel(
            [
                'users' => $users
            ]
        );
    }

    public function createAction()
    {
        return new ViewModel();
    }

    public function updateAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }

    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('Album\Model\usersTable');
        }
        return $this->usersTable;
    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

} 