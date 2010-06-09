<?php
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Zend_Service_ResultTest::main');
}

require_once '../../../bootstrap.php';

/** Zend_Service_Itunes */
require_once 'Zend/Service/Itunes/Search.php';

/** Zend_Http_Client */
require_once 'Zend/Http/Client.php';

/** Zend_Http_Client_Adapter_Test */
require_once 'Zend/Http/Client/Adapter/Test.php';

class Zend_Service_Itunes_ResultTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        /**
         * Create mock object of class Zend_Service_Itunes_Search with the method
         * query.
         */
        $result = $this->getMock('Zend_Service_Itunes_Search', array('query'));
    }
    
    protected function _getResultMock()
    {
        $resultMock = file_get_contents(dirname(__FILE__) . '/_files/response_search.txt');
        
        return new Zend_Service_Itunes_ResultSet($resultMock);
    }
    
    /**
     * Test resultset
     */
    public function testResultIteration()
    {
        $results = $this->_getResultMock();
        
        foreach ($results as $result)
        {
            $this->assertType('Zend_Service_Itunes_Result', $result);
        }
    }
    
    /**
     * Test getter for result
     */
    public function testResultIterationGet()
    {
        $results = $this->_getResultMock();
        
        foreach ($results as $result)
        {
            $this->assertEquals('James Horner', $result->artistName);
        }
    }
    
    public function testResultIterationGetUnknown()
    {
        $results = $this->_getResultMock();
        
        foreach ($results as $result)
        {
            $this->assertEquals(null, $result->artistNameddd);
        }
    }
    
    public function testResultSeekOutOfBounds()
    {
        $results = $this->_getResultMock();
        
        try {
            echo $results->seek(23);
        }
        catch (OutOfBoundsException $e)
        {
            return;
        }
        
        $this->fail('An expected exception has not been raised!');
    }
    
    public function testResultKey()
    {
        $result = $this->_getResultMock();
        
        $this->assertEquals(0, $result->key());
    }
}