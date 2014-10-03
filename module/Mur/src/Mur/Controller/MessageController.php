<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 02/10/2014
 * Time: 09:54
 */

namespace Mur\Controller;


use Mur\Entity\Message;
use Mur\Form\MessageFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MessageController extends AbstractActionController
{


    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $messages = $em->getRepository('Mur\Entity\Message')->findAll();


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
            $form->setInputFilter(new MessageFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                $messageManager = $this->getServiceLocator()->get('mur.message.manager');

                if ($messageManager->write($data)) {
                    return $this->redirect()->toRoute('message/index');
                } else {
                    //pb message non enregistré..
                }
            }

        }

        return new ViewModel(
            [
                'form' => $form
            ]
        );


    }

    public function updateAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }


}