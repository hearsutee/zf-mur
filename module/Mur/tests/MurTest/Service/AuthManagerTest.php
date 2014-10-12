<?php
//
//namespace MurTest\Service;
//
//
//use Mur\Entity\Message;
//use Mur\Service\AuthManager;
//use Mur\Test\PhpunitTestCase;
//
//class AuthManagerTest extends PhpunitTestCase
//{
//    protected $instance;
//
//    /**
//     *  setUp
//     */
//    public function setUp()
//    {
//        $this->instance = new AuthManager();
//    }
//
//    /**
//     *  tearDown
//     */
//    public function tearDown()
//    {
//        $this->instance = null;
//    }
//
//    /**
//     * test register
//     */
//    public function testRegister()
//    {
//        $dataFixture = [
//            'username' => 'machin',
//            'password' => 'truc123mE',
//
//        ];
//
//
//        $userMock = $this->getMockFromArray('Mur\Entity\User', false,
//            [
//
//                'setIsAdmin' =>
//                    [
//                        'with' => false,
//                        'will' => $this->returnValue($this->instance)
//                    ]
//
//            ]);
//
//        $doctrineEmMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
//            [
//
//                'persist' =>
//                    [
//                        'with' => $userMock,
//                    ],
//
//                'flush' =>
//                    [
//
//                    ]
//
//            ]);
//
//        $doctrineObjectMock = $this->getMock('DoctrineModule\Stdlib\Hydrator\DoctrineObject', ['hydrate'], [$doctrineEmMock]);
//
//        $doctrineObjectMock->expects($this->once())
//            ->method('hydrate')
//            ->with($dataFixture, $userMock);
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

//}
