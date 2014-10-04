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

/**
 * Class AuthenticationController
 * @package Mur\Controller
 */
class AuthenticationController extends AbstractActionController
{

    /**
     * register new user
     * @return \Zend\Http\Response|ViewModel
     */
    public function registerAction()
    {
        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('mur.user.register.form');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $form->getData();

                $authService = $sm->get('mur.auth.manager');
                $authService->register($data);

                return $this->redirect()->toRoute('home');
            }
        }
        return new ViewModel(
            [

                'form' => $form,

            ]
        );
    }

    /**
     * login user
     * @return \Zend\Http\Response|ViewModel
     */
    public function loginAction()
    {
        $sm = $this->getServiceLocator();
        $authManager = $sm->get('mur.auth.manager');

        if($authManager->getUserConnected() != false){
            return $this->redirect()->toRoute('message');
        }

        $form = $sm->get('FormElementManager')->get('mur.login.form');

        $request = $this->getRequest();
        if ($request->isPost()) {


            $form->setInputFilter(new LoginFilter());

            $form->setData($request->getPost());


            if ($form->isValid()) {

                $data = $form->getData();



                if ($authManager->login($data)) {

                    return $this->redirect()->toRoute('message');
                } else {
                   //wrong credidentials
                }

            }
        }

        return new ViewModel(
            [

                'form' => $form,

            ]
        );

    }

    /**
     * logout user
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $sm = $this->getServiceLocator();
        $authManager = $sm->get('mur.auth.manager');
        $authManager->logout();

        return $this->redirect()->toRoute('home');
    }
}