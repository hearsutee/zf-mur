<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 03/10/2014
 * Time: 11:33
 */

namespace Mur\Controller;


use Mur\Entity\User;
use Mur\Form\LoginFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthenticationController extends AbstractActionController
{

    public function registerAction()
    {
        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('mur.user.register.form');

        $em = $sm->get('doctrine.entitymanager.orm_default');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new User();

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $user->exchangeArray($form->getData());
                $user->setIsAdmin(false);

                $em->persist($user);
                $em->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('user');
            }
        }
        return ['form' => $form];
    }

    public function loginAction()
    {
        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('mur.login.form');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setInputFilter(new LoginFilter());

            $form->setData($request->getPost());

//            $data = $form->getData();

            if ($form->isValid()) {
                $data = $form->getData();

                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $adapter = $authService->getAdapter();

                $adapter->setIdentityValue($data['username']);
                $adapter->setCredentialValue($data['password']);

                $authResult = $authService->authenticate();
                die('aa');

                if ($authResult->isValid()) {


                    $identity = $authResult->getIdentity();
                    $authService->getStorage()->write($identity);

                    return $this->redirect()->toRoute('user');
                }

            }


        }

        return new ViewModel(
            [

                'form' => $form,

            ]
        );

    }
}