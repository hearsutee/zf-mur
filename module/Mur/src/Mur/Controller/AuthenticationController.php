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

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $form->getData();

                $authService = $sm->get('mur.auth.service');
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

    public function loginAction()
    {
        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('mur.login.form');

        $request = $this->getRequest();
        if ($request->isPost()) {


            $form->setInputFilter(new LoginFilter());

            $form->setData($request->getPost());


            if ($form->isValid()) {

                $data = $form->getData();

                $authService = $sm->get('mur.auth.service');

                if ($authService->login($data)) {

                    return $this->redirect()->toRoute('user');
                } else {
                    // erreur logins..
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