<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 01/10/2014
 * Time: 09:59
 */

namespace Mur\Controller;

use Mur\Entity\User;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class UserController
 * @package Mur\Controller
 */
class UserController extends AbstractActionController
{


    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $users = $em->getRepository('Mur\Entity\User')->findAll();

        return new ViewModel(
            [
                'users' => $users
            ]
        );
    }


    /**
     * @return ViewModel
     */
    public function createAction()
    {
        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('Mur\Form\UserForm');

        return new ViewModel(
            [
                'form' => $form
            ]
        );
    }

    /**
     * @return ViewModel
     */
    public function updateAction()
    {
        return new ViewModel();
    }

    /**
     * @return ViewModel
     */
    public function deleteAction()
    {
        return new ViewModel();
    }


}