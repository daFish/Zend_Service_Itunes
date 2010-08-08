<?php
class Zend_Service_Itunes_ResultTest extends PHPUnit_Framework_TestCase
{
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
    
    public function testSeek()
    {
        $results = $this->_getResultMock();
        $results->seek(0);
    }
    
    /**
     * @expectedException OutOfBoundsException
     */
    public function testResultSeekOutOfBounds()
    {
        $results = $this->_getResultMock();
        $results->seek(23);
    }
    
    public function testResultKey()
    {
        $result = $this->_getResultMock();
        
        $this->assertEquals(0, $result->key());
    }
}