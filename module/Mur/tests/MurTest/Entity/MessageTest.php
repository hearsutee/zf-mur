<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 02/10/2014
 * Time: 22:49
 */

namespace MurTest\Entity;


use Mur\Entity\Message;
use Mur\Test\PhpunitTestCase;

class MessageTest extends PhpunitTestCase
{
    protected $instance;

    /**
     *  setUp
     */
    public function setUp()
    {
        $this->instance = new Message();
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

        $this->setInaccessiblePropertyValue('id', $fixture);
        $this->assertSame($fixture, $this->instance->getId());
    }

    /**
     * Test Get Set Content
     */
    public function testGetSetContent()
    {
        $fixture = 'Citroque inmorantur discursantes milvorum momento quicquid
        parvi poterat tamen impetraverint qui ultro milvorum hostes dispexerint
      ';

        $this->assertSame($this->instance, $this->instance->setContent($fixture));

        $this->assertSame($fixture, $this->instance->getContent());
    }

    /**
     * Test Get Set DateCreation
     */
    public function testGetSetDateCreation()
    {
        $fixtureDate = new \DateTime('2014-07-14');

        $this->assertSame($this->instance, $this->instance->setDateCreation($fixtureDate));

        $this->assertSame($fixtureDate, $this->instance->getDateCreation());
    }

    /**
     * Test Get Set DateCreation
     */
    public function testGetSetUser()
    {
        $userMock = $this->getMockFromArray('Mur\Entity\User');

        $this->assertSame($this->instance, $this->instance->setUser($userMock));

        $this->assertSame($userMock, $this->instance->getUser());
    }

}
 