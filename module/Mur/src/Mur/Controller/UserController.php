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

    protected $usersTable;

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $users = $this->getUsersTable()->select();
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
        if(!$this->usersTable){

            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

            $this->usersTable = new TableGateway(
                'users',
                $adapter
            );
        }

        return $this->usersTable;
    }
} 