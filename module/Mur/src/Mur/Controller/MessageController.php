<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 02/10/2014
 * Time: 09:54
 */

namespace Mur\Controller;


use Zend\Mvc\Controller\AbstractActionController;

class MessageController extends AbstractActionController
{
    protected $em;

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $users = $em->getRepository('Mur\Entity\User')->findAll();

//        die(var_dump($users));

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


    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
} 