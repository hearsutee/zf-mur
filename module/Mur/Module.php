<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Mur;

use Zend\Authentication\AuthenticationService;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements
    FormElementProviderInterface,
    AutoloaderProviderInterface,
    ApigilityProviderInterface

{
    public function onBootstrap(MvcEvent $e)
    {

//        $this->initAcl($e);

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

//        $e->getApplication()->getEventManager()->attach(
//            'route', [$this, 'checkAcl']
//        );
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
                    'mur.message.form' => 'Mur\Form\MessageForm',
                ]
        ];
    }



//
}
