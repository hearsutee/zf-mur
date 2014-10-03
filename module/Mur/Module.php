<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Mur;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements
    FormElementProviderInterface,
    AutoloaderProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' =>
                [
                    'namespaces' =>
                        [
                            __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                        ],
                ],
        ];
    }

    public function getFormElementConfig()
    {
        return [
            'invokables' =>
                [
                    'mur.user.admin.form' => 'Mur\Form\UserForm',
                    'mur.message.add.form' => 'Mur\Form\MessageForm',
                    'mur.user.register.form' => 'Mur\Form\RegisterForm',
                    'mur.login.form' => 'Mur\Form\LoginForm',
                ]
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' =>
                [
                    'Zend\Authentication\AuthenticationService' => function ($serviceManager) {

                        return $serviceManager->get('doctrine.authenticationservice.orm_default');

                    }
                ]
        ];
    }
}
