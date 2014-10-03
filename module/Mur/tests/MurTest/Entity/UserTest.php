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

    /**
     * Test Get id
     */
    public function testGetId()
    {
        $fixture = 23238;

        $this->setInaccessiblePropertyValue('id', 23238);
        $this->assertSame($fixture, $this->instance->getId());
    }

    /**
     * Test Get Set userName
     */
    public function testGetSetUserName()
    {
        $fixture = 'Jean-Paul234MxX';

        $this->assertSame($this->instance, $this->instance->setUserName($fixture));

        $this->assertSame($fixture, $this->instance->getUserName());
    }

    /**
     * Test Get Set isAdmin
     */
    public function testGetSetIsAdmin()
    {
        $fixtureTrue = true;
        $fixtureFalse = false;

        $this->assertSame($this->instance, $this->instance->setIsAdmin($fixtureTrue));
        $this->assertSame($this->instance, $this->instance->setIsAdmin($fixtureFalse));
        $this->assertSame($fixtureFalse, $this->instance->getIsAdmin());
    }

    /**
     * Test __toString
     */
    public function testToString()
    {
        $fixture= 'blabla';
        $this->setInaccessiblePropertyValue('userName', $fixture);

        $this->assertSame($fixture, $this->instance->__toString());

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