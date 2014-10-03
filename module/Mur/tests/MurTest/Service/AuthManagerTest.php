<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 02/10/2014
 * Time: 22:49
 */

namespace MurTest\Entity;


use Mur\Entity\Message;
use Mur\Service\AuthManager;
use Mur\Test\PhpunitTestCase;

class AuthManagerTest extends PhpunitTestCase
{
    protected $instance;

    /**
     *  setUp
     */
    public function setUp()
    {
        $this->instance = new AuthManager();
    }

    /**
     *  tearDown
     */
    public function tearDown()
    {
        $this->instance = null;
    }

    public function testRegister()
    {
        $dataFixture = [
            'usernama' => 'machin',
            'password' => 'truc123mE'
        ];


        $userMock = $this->getMockFromArray('Mur\Entity\User', false,
            [

                'exchangeArray' =>
                    [
                        'with' => $dataFixture,
                        'will' => $this->returnValue($this->instance)
                    ],
                'setIsAdmin' =>
                    [
                        'with' => false,
                        'will' => $this->returnValue($this->instance)
                    ]

            ]);

        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [

                'persist' =>
                    [
                        'with' => $userMock,
                    ],

                'flush' =>
                    [

                    ]

            ]);

        $smMock = $this->getMockFromArray('Zend\ServiceManager\ServiceManager', false,
            [

                'get' =>
                    [
                        'with' => 'doctrine.entitymanager.orm_default',
                        'will' => $this->returnValue($doctrineEmMock)
                    ],


            ]);

        $this->setInaccessiblePropertyValue('serviceLocator', $smMock);

        $this->instance->register($dataFixture);

    }


}
