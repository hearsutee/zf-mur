<?php

namespace MurTest\Service;


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

        $entityManagerMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
            [
                'getRepository' =>
                    [
                        'with' => 'Mur\Entity\Message',
                        'will' => $this->returnValue($messageRepositoryMock)
                    ],

            ]);

        $this->instance = $this->getMockFromArray('Mur\Service\MessageManager', false,
            [
                'getEntityManager' =>
                    [
                        'will' => $this->returnValue($entityManagerMock)

                    ],
            ]);


        $this->assertSame($message, $this->instance->getMessageById($dataFixture['id']));
    }




}
