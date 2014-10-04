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

        $newMessage = clone $message;

        $newData =
            [
                'id' => 1287,
                'content' => 'nouveau contenu !',
                'date' => new \DateTime('now'),
                'user' => $user
            ];

        $newMessage
            ->setContent($newData['content']);



//        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
//            [
//
//                'getRepository' =>
//                    [
//                        'with' => 'Mur\Entity\Message',
//                    ],
//
//            ]);
//
        $smMock = $this->getMockFromArray('Zend\ServiceManager\ServiceManager', false,
            [


            ]);

        $this->setInaccessiblePropertyValue('serviceLocator', $smMock);
                $this->assertTrue($this->instance->update($message, $newData));


    }

    /**
     * test record
     */
    public function testRecord()
    {
        $entityMock = $this->getMockFromArray('Mur\Entity\User', false,
            [

            ]);


        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [

                'persist' =>
                    [
                        //test ok mais impossible de valider l'assertion comme quoi persist est appelée avec le mock ?
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

}
