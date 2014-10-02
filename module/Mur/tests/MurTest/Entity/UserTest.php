<?php


namespace MurTest\Entity;

use Mur\Test\PhpunitTestCase;
use Mur\Entity\User;

class UserTest extends PhpunitTestCase
{

    protected $instance;

    /**
     *  setUp
     */
    public function setUp()
    {
        $this->instance = new User();
    }

    /**
     *  tearDown
     */
    public function tearDown()
    {
        $this->instance = null;
    }

    /*
    * Test Get Set id
    */
    public function testGetSetId()
    {

        $fixture = 23238;

        $this->assertSame($fixture, $this->instance->SETId($fixture));
        $this->assertSame($fixture, $this->instance->getId());
    }

//    /*+
//    * Test Get Set id
//    */
//    public function testSetIdException()
//    {
//        $fixture = 'string';
//
//        $this->setExpectedException('Exception');
//
//        $this->instance->setId($fixture);
//    }
} 