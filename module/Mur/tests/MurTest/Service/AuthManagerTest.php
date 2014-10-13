<?php

namespace MurTest\Service;


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

    /**
     * test register
     */
    public function testRegister()
    {
        $dataFixture = [
            'username' => 'machin',
            'password' => 'truc123mE',

        ];


        $userMock = $this->getMockFromArray('Mur\Entity\User', false,
            [
                'setRole' =>
                    [
                        'with' => 'member',
                        'will' => $this->returnValue($this->instance)
                    ]

            ]);

        $entityManagerMock = $this->getMockFromArray('Doctrine\ORM\EntityManager', false,
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
                        'with' => 'mur.user.entity',
                        'will' => $this->returnValue($userMock)
                    ],


            ]);

        $hydratorMock = $this->getMock('DoctrineModule\Stdlib\Hydrator\DoctrineObject', ['hydrate'], [$entityManagerMock]);


        $hydratorMock->expects($this->once())
            ->method('hydrate')
            ->with($dataFixture, $userMock);

        $this->setInaccessiblePropertyValue('serviceLocator', $smMock);
        $this->setInaccessiblePropertyValue('entityManager', $entityManagerMock);
        $this->setInaccessiblePropertyValue('hydrator', $hydratorMock);

        $this->instance->register($dataFixture);

    }

    public function testLoginIfValid()
    {

        $data =
            [
                'username' => 'good',
                'password' => 'good'
            ];
        $adapterMock =  $this->getMockFromArray('\stdClass', false,
            [

                'setIdentityValue' => [
                    'with' => $data['username'],
                ],
                'setCredentialValue' =>[
                    'with' => $data['password'],
                ]

            ]);

        $storageMock = $this->getMockFromArray('\stdClass', false,
            [

                'write' => [

                ],

            ]);

        $authResultMock = $this->getMockFromArray('\stdClass', false,
        [

            'isValid' => [
                'will' => $this->returnValue(true)
            ],
            'getIdentity' => [],
        ]);

        $authServiceMock = $this->getMockFromArray('Zend\Authentication\AuthenticationService', false,
            [

                'getAdapter' => [
                    'expects' => $this->any(),
                    'will' => $this->returnValue($adapterMock)
                ],

                'authenticate' =>[
                    'will' => $this->returnValue($authResultMock)
                ],


                'getStorage' => [
                    'will' => $this->returnValue($storageMock)
                ]

            ]);



        $this->setInaccessiblePropertyValue('authService', $authServiceMock);
        $this->assertTrue($this->instance->login($data));




    }

    public function testLoginIfNonValid()
    {

        $data =
            [
                'username' => 'wrong',
                'password' => 'wrong'
            ];

        $adapterMock =  $this->getMockFromArray('\stdClass', false,
            [

                'setIdentityValue' => [
                    'with' => $data['username'],
                ],
                'setCredentialValue' =>[
                    'with' => $data['password'],
                ]

            ]);

        $authResultMock = $this->getMockFromArray('\stdClass', false,
            [

                'isValid' => [
                    'will' => $this->returnValue(false)
                ],

            ]);

        $authServiceMock = $this->getMockFromArray('Zend\Authentication\AuthenticationService', false,
            [

                'getAdapter' => [
                    'expects' => $this->any(),
                    'will' => $this->returnValue($adapterMock)
                ],

                'authenticate' =>[
                    'will' => $this->returnValue($authResultMock)
                ],

            ]);



        $this->setInaccessiblePropertyValue('authService', $authServiceMock);
        $this->assertFalse($this->instance->login($data));
    }

}
