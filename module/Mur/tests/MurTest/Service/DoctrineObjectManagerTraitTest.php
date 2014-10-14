<?php


namespace MurTest\Service;

use Mur\Entity\Message;
use Mur\Entity\User;
use Mur\Test\PhpunitTestCase;

/**
 * Class DoctrineObjectManagerTraitTest
 * @package MurTest\Service
 */
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
     *  test get set hydrator
     */
    public function testGetSetHydrator()
    {
        $entityManagerMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            []);

        $hydratorMock = $this->getMock('DoctrineModule\Stdlib\Hydrator\DoctrineObject', [],
            [$entityManagerMock]);

        $this->assertSame($this->instance, $this->instance->setHydrator($hydratorMock));
        $this->assertSame($hydratorMock, $this->instance->getHydrator());
    }

    /**
     *  test get set entityManager
     */
    public function testGetSetEntityManager()
    {
        $entityManagerMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            []);

        $this->assertSame($this->instance, $this->instance->setEntityManager($entityManagerMock));
        $this->assertSame($entityManagerMock, $this->instance->getEntityManager());
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

        $entity = new Message();
        $subEntity = new User();

        $dataFixture = [
            'content' => 'kzfoznfzlkenf',
            'dateCreation' => new \DateTime('now'),
            'user' => $subEntity
        ];

        $entityAsItShouldBeAtTheEnd = clone $entity;

        $entityAsItShouldBeAtTheEnd
            ->setContent($dataFixture['content'])
            ->setDateCreation($dataFixture['dateCreation'])
            ->setUser($dataFixture['user']);

        $entityManagerMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            []);

        $hydratorMock = $this->getMock('DoctrineModule\Stdlib\Hydrator\DoctrineObject', [],
            [$entityManagerMock]);

        $hydratorMock->expects($this->once())
            ->method('hydrate')
            ->with($dataFixture, $entity);

        $this->setInaccessiblePropertyValue('entityManager', $entityManagerMock);
        $this->setInaccessiblePropertyValue('hydrator', $hydratorMock);

        $this->instance->hydrate($dataFixture,$entity);
        $this->assertEquals($entity, $entityAsItShouldBeAtTheEnd);
    }

    /**
     * test update
     */
    public function testUpdate()
    {

        $entity = new Message();
        $subEntity = new User();

        $data =
            [
                'id' => 1287,
                'content' => 'kzfoznfzlkenf',
                'date' => new \DateTime('now'),
                'user' => $subEntity
            ];

        $entity
            ->setId($data['id'])
            ->setContent($data['content'])
            ->setDateCreation($data['date'])
            ->setUser($data['user']);

        $newData =
            [
                'id' => 1287,
                'content' => 'nouveau contenu nouveau !',
                'date' => new \DateTime('now'),
                'user' => $subEntity
            ];

        $newEntity = clone $entity;
        $newEntity
            ->setContent($newData['content']);

        $this->instance = $this->getMockFromArray('Mur\Service\MessageManager', false,
            [

                'hydrate' =>
                    [
                        'with' => [$newData, $entity],

                    ],
                'record' =>
                    [
                        'with' => $entity
                    ]


            ]);

        $hydratorMock = $this->getMockFromArray('DoctrineModule\Stdlib\Hydrator\DoctrineObject', false,
            []);

        $entityManagerMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            []);

        $this->setInaccessiblePropertyValue('hydrator', $hydratorMock);
        $this->setInaccessiblePropertyValue('entityManager', $entityManagerMock);

        $this->assertTrue($this->instance->update($newData, $entity));

    }

    /**
     * test delete
     */
    public function testDelete()
    {

        $entityMock = $this->getMockFromArray('Mur\Entity\Message', false, []);

        $entityManagerMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [
                'remove' =>
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

        $this->instance->delete($entityMock);

    }


} 