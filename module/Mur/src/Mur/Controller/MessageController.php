<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 02/10/2014
 * Time: 09:54
 */

namespace Mur\Controller;


use Mur\Entity\Message;
use Mur\Entity\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MessageController extends AbstractActionController
{
    protected $em;

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $messages = $em->getRepository('Mur\Entity\Message')->findAll();

//        die(var_dump($users));

        return new ViewModel(
            [
                'messages' => $messages
            ]
        );
    }

    public function createAction()
    {

        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('mur.message.form');


        $request = $this->getRequest();
        if ($request->isPost()) {

            $em = $this->getEntityManager();
            $message = new Message();
            $message->setDateCreation(new \DateTime('now'));

            $em->persist($message);
            $em->flush();


                // Redirect to list of messages
                return $this->redirect()->toRoute('message/index');

        }

        return new ViewModel(
            [
                'form' => $form
            ]
        );

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