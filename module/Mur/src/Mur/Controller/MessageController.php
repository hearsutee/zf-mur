<?php


namespace Mur\Controller;


use Mur\Form\MessageFilter;
use Zend\Form\FormInterface;
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
        $authManager = $sm->get('mur.auth.manager');

        if (!$authManager->getUserConnected()) {
            return $this->redirect()->toRoute('home');
        }

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
        $authManager = $sm->get('mur.auth.manager');

        if (!$authManager->getUserConnected()) {
            return $this->redirect()->toRoute('home');
        }

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
        $authManager = $sm->get('mur.auth.manager');

        if (!$authManager->getUserConnected() || $authManager->getRole() != 'admin') {
            return $this->redirect()->toRoute('home');
        }

        $messageManager = $sm->get('mur.message.manager');

        $idMessage = $this->params()->fromRoute('id');
        $messageToUpdate = $messageManager->getMessageById($idMessage);

        $form = $sm->get('FormElementManager')->get('mur.message.form');

       $form->bind($messageToUpdate);

       
       // $form->get('content')->setValue($messageToUpdate->getContent());

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setInputFilter(new MessageFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                //si le form est bound, getData retourne l'object entity.
                $data = $form->getData();

                //$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
                //if ($messageManager->update($data, $messageToUpdate)) {

                // si le form est bound alors getData retourne l'object entity ! on peut donc utiliser persist sans l'hydrater au                       préalable :
                if ($messageManager->record($messageToUpdate)) {
                    return $this->redirect()->toRoute('message');
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

    /**
     * admin delete existing message
     * @return ViewModel
     */
    public function deleteAction()
    {
        $sm = $this->getServiceLocator();
        $authManager = $sm->get('mur.auth.manager');

        if (!$authManager->getUserConnected() || $authManager->getRole() != 'admin') {
            return $this->redirect()->toRoute('home');
        }

        $messageManager = $sm->get('mur.message.manager');

        $idMessage = $this->params()->fromRoute('id');
        $messageToDelete = $messageManager->getMessageById($idMessage);

        $messageManager->delete($messageToDelete);

        return $this->redirect()->toRoute('message');

    }

}





