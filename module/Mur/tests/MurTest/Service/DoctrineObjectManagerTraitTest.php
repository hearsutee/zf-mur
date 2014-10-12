<?php


namespace MurTest\Service;


use Mur\Entity\Message;
use Mur\Entity\User;
use Mur\Test\PhpunitTestCase;


class DoctrineObjectManagerTraitTest extends PhpunitTestCase
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
        $this->instance = new DoctrineObjectManagerTraitClassTest();
    }

    /**
     *  tearDown
     */
    public function tearDown()
    {
        $this->instance = null;
    }

    /**
     * test record
     */
    public function testRecord()
    {

        $entityMock = $this->getMockFromArray('Mur\Entity\Message', false, []);

        $entityManagerMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [
                'persist' =>
                    [
                        'with' => $entityMock,
                    ],

                'flush' =>
                    [

                    ]

            ]);

        $this->instance = $this->getMockFromArray('Mur\Service\MessageManager', false,
            [
                'getEntityManager' =>
                    [
                        'will' => $this->returnValue($entityManagerMock)

                    ],
            ]);

        $this->setInaccessiblePropertyValue('entityManager', $entityManagerMock);

        $this->instance->record($entityMock);

    }

    /**
     * test hydrate
     */
    public function testHydrate()
    {

        $message = new Message();

        $user = new User();

        $dataFixture = [
            'id' => 123,
            'content' => 'kzfoznfzlkenf',
            'date' => new \DateTime('now'),
            'user' => $user
        ];

        $messageAsItShouldBeAtTheEnd = clone $message;

        $messageAsItShouldBeAtTheEnd
            ->setId($dataFixture['id'])
            ->setContent($dataFixture['content'])
            ->setDateCreation($dataFixture['date'])
            ->setUser($dataFixture['user']);


        $entityManagerMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [

            ]);

        $hydratorMock = $this->getMock('DoctrineModule\Stdlib\Hydrator\DoctrineObject', [],
            [$entityManagerMock]);

        $hydratorMock->expects($this->once())
            ->method('hydrate')
            ->with($dataFixture,$message)
            ->will($this->returnValue($messageAsItShouldBeAtTheEnd));

        $this->instance = $this->getMockFromArray('Mur\Service\MessageManager', false,
            [
                'getHydrator' =>
                    [
                        'will' => $this->returnValue($hydratorMock)

                    ],
            ]);

        $this->setInaccessiblePropertyValue('entityManager', $entityManagerMock);
        $this->setInaccessiblePropertyValue('hydrator', $hydratorMock);

        $this->instance->hydrate($dataFixture, $message);
        $this->assertEquals($message, $messageAsItShouldBeAtTheEnd);

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


        $this->instance = $this->getMockFromArray('Mur\Service\MessageManager', false,
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


        $hydratorMock = $this->getMockFromArray('DoctrineModule\Stdlib\Hydrator\DoctrineObject', false,
            [

            ]);

        $entityManagerMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [

            ]);

        $this->setInaccessiblePropertyValue('hydrator', $hydratorMock);
        $this->setInaccessiblePropertyValue('entityManager', $entityManagerMock);

        $this->assertTrue($this->instance->update($newData, $message));

    }


    //    public function testDelete()
//    {
//
//        $entityMock = $this->getMockFromArray('Mur\Entity\Message', false,
//            [
//
//            ]);
//
//        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
//            [
//                'remove' =>
//                    [
//                        /**
//                         * test ok mais impossible de valider l'assertion ci dessous comme quoi persist est appelée avec le mock ? erreur :
//                         * Parameter count for invocation Doctrine\ORM\EntityManager::remove(Mock54343787ada04 Object (...)) is too low.
//                         */
////                        'with' => $entityMock,
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
//                'get' =>
//                    [
//                        'with' => 'doctrine.entitymanager.orm_default',
//                        'will' => $this->returnValue($doctrineEmMock)
//                    ],
//
//            ]);
//
//        $this->setInaccessiblePropertyValue('serviceLocator', $smMock);
//        $this->instance->delete($entityMock);
//
//    }
} 