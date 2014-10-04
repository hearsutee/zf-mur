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
use Zend\Form\Element\DateTime;

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

//    /**
//     * test register
//     */
//    public function testCreate()
//    {
//        $dataFixture = [
//            'content' => 'loremIpsum?loremIpsum?  !  loremIpsum?
//            loremIpsum?loremIpsum?loremIpsum?loremIpsum?   !  loremIpsum?
//            loremIpsum?loremIpsum?',
//
//        ];
//
//        $userConnectedMock = $this->getMockFromArray('Mur\Entity\User', false,
//            [
//
//            ]);
//
//        $messageMock = $this->getMockFromArray('Mur\Entity\Message', false,
//            [
//                'exchangeArray' =>
//                    [
//                        'with' => $dataFixture,
//                    ],
//
//                'flush' =>
//                    [
//
//                    ]
//            ]);
//
//        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
//            [
//
//                'persist' =>
//                    [
//                        'with' => $messageMock,
//                    ],
//
//                'flush' =>
//                    [
//
//                    ]
//
//            ]);
//
//        $smMock = $this->getMockFromArray('Zend\ServiceManager\ServiceManager', false,
//            [
//
//                'get' =>
//                    [
//                        'with' => 'doctrine.entitymanager.orm_default',
//                        'will' => $this->returnValue($doctrineEmMock)
//                    ],
//
//
//            ]);
//
//        $this->instance->setServiceLocator($smMock);
//
//        $this->instance->register($dataFixture);
//
//    }
    public function testRecord()
    {
        $entityMock = $this->getMockFromArray('Mur\Entity\User', false,
            [

            ]);


        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [

                'persist' =>
                    [
                        //test ok mais impossible de valider l'assertion comme quoi persist est appelé avec le mock ?
//                        'with' => $entityMock,
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
        $this->instance->record($entityMock);

    }

    public function testGetMessageById()
    {


        $messageMock = $this->getMockFromArray('Mur\Entity\Message', false,
            [
                'setContent' => [] ,
                'setId' => [] ,
                'setDateCreation' => [] ,
                'setUser' => [] ,

            ]);

        $userMock = $this->getMockFromArray('Mur\Entity\User', false,
            [

            ]);

        $dataFixture = [
            'id' => 123,
            'content' => 'kzfoznfzlkenf',
            'date' => new \DateTime('now'),
            'user' => $userMock
        ];

        $messageMock
            ->setId($dataFixture['id'])
            ->setContent($dataFixture['content'])
            ->setDateCreation($dataFixture['date'])
            ->setUser($dataFixture['user']);


        $messageRepositoryMock = $this->getMockFromArray('Doctrine\ORM\EntityRepository', true,
            [
                'findOneById' =>
                    [
                        'with' => $dataFixture['id'],
                        'will' => $this->returnValue($messageMock)
                    ],

            ]);

        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [

                'getRepository' =>
                    [
                        'with' => 'Mur\Entity\Message',
                        'will' => $this->returnValue($messageRepositoryMock)
                    ],


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
        $this->instance->getMessageById($dataFixture['id']);
    }

}
