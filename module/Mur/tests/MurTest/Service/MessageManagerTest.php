<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 02/10/2014
 * Time: 22:49
 */

namespace MurTest\Entity;


use Mur\Entity\Message;
use Mur\Service\MessageManager;
use Mur\Test\PhpunitTestCase;

class MessageManagerTest extends PhpunitTestCase
{
    protected $instance;

    /**
     *  setUp
     */
    public function setUp()
    {
        $this->instance = new MessageManager();
    }

    /**
     *  tearDown
     */
    public function tearDown()
    {
        $this->instance = null;
    }

    /**
     * test register
     */
    public function testCreate()
    {
        $dataFixture = [
            'content' => 'loremIpsum?loremIpsum?  !  loremIpsum?
            loremIpsum?loremIpsum?loremIpsum?loremIpsum?   !  loremIpsum?
            loremIpsum?loremIpsum?',

        ];

        $userConnectedMock = $this->getMockFromArray('Mur\Entity\User', false,
            [

            ]);

        $messageMock = $this->getMockFromArray('Mur\Entity\Message', false,
            [
                'exchangeArray' =>
                    [
                        'with' => $dataFixture,
                    ],

                'flush' =>
                    [

                    ]
            ]);

        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [

                'persist' =>
                    [
                        'with' => $messageMock,
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

        $this->instance->setServiceLocator($smMock);

        $this->instance->register($dataFixture);

    }


}
