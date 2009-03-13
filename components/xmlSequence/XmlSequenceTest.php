<?php
require_once 'PHPUnit/Framework.php';

require_once 'XmlSequence.class.php';
require_once '_start.php';

/**
 * Test class for XmlSequence.
 * Generated by PHPUnit on 2009-03-03 at 00:35:08.
 */
class XmlSequenceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    XmlSequence
     * @access protected
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->object = new XmlSequence;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
    }

    /**
     * Generated from @assert ( "/www/folder/", "/www/another/big/", false ) == "../another/big/".
     */
    public function testGetRelativePath()
    {
        $this->assertEquals(
          "../another/big/",
          XmlSequence::getRelativePath( "/www/folder/", "/www/another/big/", false )
        );
    }

    /**
     * Generated from @assert ( "", "" ) throws XmlSequenceException.
     * @expectedException XmlSequenceException
     */
    public function testGetRelativePath2()
    {
        XmlSequence::getRelativePath( "", "" );
    }

    /**
     * Generated from @assert ( "hello", "" ) throws XmlSequenceException.
     * @expectedException XmlSequenceException
     */
    public function testGetRelativePath3()
    {
        XmlSequence::getRelativePath( "hello", "" );
    }

    /**
     * Generated from @assert ( "", "hello" ) throws XmlSequenceException.
     * @expectedException XmlSequenceException
     */
    public function testGetRelativePath4()
    {
        XmlSequence::getRelativePath( "", "hello" );
    }

    /**
     * Generated from @assert ( "cool", "hello" ) throws XmlSequenceException.
     * @expectedException XmlSequenceException
     */
    public function testGetRelativePath5()
    {
        XmlSequence::getRelativePath( "cool", "hello" );
    }

    /**
     * Generated from @assert ( "/cool/", "hello" ) throws XmlSequenceException.
     * @expectedException XmlSequenceException
     */
    public function testGetRelativePath6()
    {
        XmlSequence::getRelativePath( "/cool/", "hello" );
    }

    /**
     * Generated from @assert ( "cool", "/hello/" ) throws XmlSequenceException.
     * @expectedException XmlSequenceException
     */
    public function testGetRelativePath7()
    {
        XmlSequence::getRelativePath( "cool", "/hello/" );
    }

    /**
     * Generated from @assert ( "/cool/", "/hello/", false ) == "../hello/".
     */
    public function testGetRelativePath8()
    {
        $this->assertEquals(
          "../hello/" ,
          XmlSequence::getRelativePath( "/cool/", "/hello/", false )
        );
    }

    /**
     * Generated from @assert ( "/cool/", "/hello/", false ) == "../hello/".
     */
    public function testGetRelativePath9()
    {
        $this->assertEquals(
          "../hello/" ,
          XmlSequence::getRelativePath( "/cool/", "/hello/", false )
        );
    }

    /**
     * Generated from @assert ( "/cool/", "/cool/", false ) == "./".
     */
    public function testGetRelativePath10()
    {
        $this->assertEquals(
          "./" ,
          XmlSequence::getRelativePath( "/cool/", "/cool/", false )
        );
    }

    /**
     * Generated from @assert ( "/cool/more/", "/other/", false ) == "../../other/".
     */
    public function testGetRelativePath11()
    {
        $this->assertEquals(
          "../../other/" ,
          XmlSequence::getRelativePath( "/cool/more/", "/other/", false )
        );
    }

    /**
     * Generated from @assert ( "/cool/", "/other/more/", false ) == "../other/more/".
     */
    public function testGetRelativePath12()
    {
        $this->assertEquals(
          "../other/more/" ,
          XmlSequence::getRelativePath( "/cool/", "/other/more/", false )
        );
    }

    /**
     * @todo Implement testSetMessages().
     */
    public function testSetMessages() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetActors().
     */
    public function testSetActors() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testAddMessage().
     */
    public function testAddMessage() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testAddActor().
     */
    public function testAddActor() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetZoom().
     */
    public function testSetZoom() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetZoom().
     */
    public function testGetZoom() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetXml().
     */
    public function testSetXml() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetXml().
     */
    public function testGetXml() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testShow().
     */
    public function testShow() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
?>