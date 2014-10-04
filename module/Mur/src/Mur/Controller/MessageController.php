<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 02/10/2014
 * Time: 09:54
 */

namespace Mur\Controller;


use Mur\Form\MessageFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class MessageController
 * @package Mur\Controller
 */
class MessageController extends AbstractActionController
{


    /**
     * display all messages
     * @return ViewModel
     */
    public function indexAction()
    {
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $messages = $em->getRepository('Mur\Entity\Message')->findAll();

        return new ViewModel(
            [
                'messages' => $messages
            ]
        );
    }

    /**
     * @return ViewModel
     */
    public function createAction()
    {
        $sm = $this->getServiceLocator();
//
//        $sessionUser = $sm
//            ->get('Zend\Authentication\AuthenticationService')
//            ->getStorage()
//            ->read()['user'];
//        $acl = $this->getServiceLocator()
//            ->get('mur.acl');
//
//        if ($acl->isAllowed($sessionUser['role'], 'message', 'create')) {

        $form = $sm->get('FormElementManager')->get('mur.message.form');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setInputFilter(new MessageFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                $messageManager = $sm->get('mur.message.manager');

                if ($messageManager->write($data)) {
                    return $this->redirect()->toRoute('message');
                } else {
                    //pb message non enregistré..
                }
            }

        } // }
        else {
            //redirect to route access denied
        }

        return new ViewModel(
            [
                'form' => $form
            ]
        );


    }

    /**
     * admin update existing message
     * @return ViewModel
     */
    public function updateAction()
    {
        $sm = $this->getServiceLocator();

        $em = $sm->get('doctrine.entitymanager.orm_default');
        $messageManager = $sm->get('mur.message.manager');

        $idMessage = $this->params()->fromRoute('id');


        $form = $sm->get('FormElementManager')->get('mur.message.form');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setInputFilter(new MessageFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                $messageManager = $sm->get('mur.message.manager');

                if ($messageManager->update($idMessage, $data)) {
                    return $this->redirect()->toRoute('message');
                } else {
                    //pb message non enregistré..
                }
            }


            return new ViewModel();
        }
    }

    /**
     * admin delete existing message
     * @return ViewModel
     */
    public function deleteAction()
    {
        return new ViewModel();
    }


}