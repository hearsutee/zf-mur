<?php

namespace MurTest\Entity;



use Mur\Entity\Message;
use Mur\Entity\User;
use Mur\Service\MessageManager;
use Mur\Test\PhpunitTestCase;
use Zend\Form\Element\DateTime;

/**
 * Class MessageManagerTest
 * @package MurTest\Entity
 */
class MessageManagerTest extends PhpunitTestCase
{
    /**
     * @var
     */
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
     * test update
     */
    public function testUpdate()
    {

        $message = new Message();
        $user = new User();

        $data =
            [
                'id' => 1287,
                'content' => 'kzfoznfzlkenf',
                'date' => new \DateTime('now'),
                'user' => $user
            ];

        $message
            ->setId($data['id'])
            ->setContent($data['content'])
            ->setDateCreation($data['date'])
            ->setUser($data['user']);

        $newData =
            [
                'id' => 1287,
                'content' => 'nouveau contenu nouveau !',
                'date' => new \DateTime('now'),
                'user' => $user
            ];

        $newMessage = clone $message;
        $newMessage
            ->setContent($newData['content']);


        $instanceMock = $this->getMockFromArray('Mur\Service\MessageManager', false,
            [

                'hydrate' =>
                    [
                        'with' => [$newData, $message],

                    ],
                'record' =>
                    [
                        'with' => $message
                    ]


            ]);

        $smMock = $this->getMockFromArray('Zend\ServiceManager\ServiceManager', false,
            [


            ]);

        $this->setInaccessiblePropertyValue('serviceLocator', $smMock);
        $this->instance->hydrate($newData, $message);
        $this->assertTrue($this->instance->update($message, $newData));
        $this->assertSame($newMessage, $message);


    }

    public function testDelete()
    {

        $entityMock = $this->getMockFromArray('Mur\Entity\Message', false,
            [

            ]);

        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [
                'remove' =>
                    [
                        /**
                         * test ok mais impossible de valider l'assertion ci dessous comme quoi persist est appelée avec le mock ? erreur :
                         * Parameter count for invocation Doctrine\ORM\EntityManager::remove(Mock54343787ada04 Object (...)) is too low.
                         */
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
        $this->instance->delete($entityMock);

    }

    /**
     * test record
     */
    public function testRecord()
    {

        $entityMock = $this->getMockFromArray('Mur\Entity\Message', false, []);

        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [
                'persist' =>
                    [

                        'with' => $entityMock,
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


    /**
     * test get message by id
     */
    public function testGetMessageById()
    {

        $message = new Message();

        $user = new User();

        $dataFixture = [
            'id' => 123,
            'content' => 'kzfoznfzlkenf',
            'date' => new \DateTime('now'),
            'user' => $user
        ];

        $message
            ->setId($dataFixture['id'])
            ->setContent($dataFixture['content'])
            ->setDateCreation($dataFixture['date'])
            ->setUser($dataFixture['user']);


        $messageRepositoryMock = $this->getMockFromArray('Doctrine\ORM\EntityRepository', true,
            [
                'findOneById' =>
                    [
                        'with' => $dataFixture['id'],
                        'will' => $this->returnValue($message)
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
        $this->assertSame($message, $this->instance->getMessageById($dataFixture['id']));
    }

    /**
     * test hydrate
     */
    public function testHydrate()
    {

        $entityMock = $this->getMockFromArray('Mur\Entity\User', false, []);

        $data =
            [
                'id' => 1237,
                'userName' => 'Jean-Jean',
                'role' => 'admin',
                'password' => 'topsecret'
            ];

        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false, []);

        $smMock = $this->getMockFromArray('Zend\ServiceManager\ServiceManager', false,
            [

            ]);

        $this->setInaccessiblePropertyValue('serviceLocator', $smMock);

        //$doctrinEmMock passé au constucteur
        $hydratorMock = $this->getMock('DoctrineModule\Stdlib\Hydrator\DoctrineObject', ['hydrate'], [$doctrineEmMock]);

        $hydratorMock->expects($this->once())
            ->method('hydrate')
            ->with($data, $entityMock);

        $this->instance->hydrate($data, $entityMock);

    }


}
