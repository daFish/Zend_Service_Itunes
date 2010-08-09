<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Service_Itunes
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id $
 */
class Zend_Service_Itunes_LookupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Zend_Service_Itunes_Lookup
     */
    protected $_lookup = null;
    
    /**
     * @var Zend_Http_Client
     */
    protected $_httpClientMock = null;
    
    /**
     * @var Zend_Http_Response
     */
    protected $_httpResponseMock = null;
    
    public function setUp()
    {
        $this->_httpClientMock   = $this->getMock('Zend_Http_Client');
        $this->_httpResponseMock = $this->getMock('Zend_Http_Response', array(), array(), '', false);
        
        $this->_lookup = new Zend_Service_Itunes_Lookup;
        $this->_lookup->setHttpClient($this->_httpClientMock);
    }
    
    /**
     * Test of Zend_Service_Itunes_Lookup::setAmgArtistId
     */
    public function testAmgArtistId()
    {
        $this->_lookup->setAmgArtistId(123456);
        $this->assertContains(123456, $this->_lookup->getAmgArtistIds());
    }
    
    /**
     * Test of Zend_Service_Itunes_Lookup::setLookupId
     */
    public function testLookupId()
    {
        $this->_lookup->setLookupId(123456);
        $this->assertEquals(123456, $this->_lookup->getLookupId());
    }
    
    /**
     * Test of Zend_Service_Itunes_Lookup::query
     */
    public function testQueryWithArrayResult()
    {
        $this->_httpClientMock->expects($this->once())
                              ->method('request')
                              ->will($this->returnValue($this->_httpResponseMock));
                       
        $this->_httpResponseMock->expects($this->once())
                                ->method('getBody')
                                ->will($this->returnValue(file_get_contents(__DIR__ . '/_files/response_lookup.txt')));
                                
        $this->_lookup->setAmgArtistId(39429);
        $this->_lookup->setResultFormat('array');

        $this->assertType('Zend_Service_Itunes_ResultSet', $this->_lookup->query());
    }
    
    /**
     * Test of Zend_Service_Itunes_Lookup::query
     */
    public function testQueryWithJsonResult()
    {
        $this->_httpClientMock->expects($this->once())
                              ->method('request')
                              ->will($this->returnValue($this->_httpResponseMock));
                       
        $this->_httpResponseMock->expects($this->once())
                                ->method('getBody')
                                ->will($this->returnValue(file_get_contents(__DIR__ . '/_files/response_lookup.txt')));
                                
        $this->_lookup->setAmgArtistId(39429);
        
        $this->_lookup->query();

        $this->assertEquals(1, $this->_lookup->getResultCount());
        $this->assertEquals('[{"wrapperType":"artist","artistType":"Artist","artistName":"James Horner","artistLinkUrl":"http:\/\/itunes.apple.com\/us\/artist\/james-horner\/id266740?uo=4","artistId":266740,"amgArtistId":39429,"amgVideoArtistId":null,"primaryGenreName":"Soundtrack","primaryGenreId":16}]', $this->_lookup->getResults());
    }
    
    /**
     * Test of Zend_Service_Itunes_Lookup::query
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testQueryWithNoLookupId()
    {
        $this->_lookup->query();
    }
    
    /**
     * Test of Zend_Service_Itunes_Lookup::query
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testQueryResultSetWithArraySet()
    {
        $this->_httpClientMock->expects($this->once())
                              ->method('request')
                              ->will($this->returnValue($this->_httpResponseMock));
                       
        $this->_httpResponseMock->expects($this->once())
                                ->method('getBody')
                                ->will($this->returnValue(file_get_contents(__DIR__ . '/_files/response_lookup.txt')));
                                
        $this->_lookup->setAmgArtistId(39429);
        $this->_lookup->setResultFormat('array');
        
        $this->_lookup->query();
        
        $this->_lookup->getResults();
    }
    
    /**
     * Test of Zend_Service_Itunes_Lookup::query
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testQueryResultCountSetWithArraySet()
    {
        $this->_httpClientMock->expects($this->once())
                              ->method('request')
                              ->will($this->returnValue($this->_httpResponseMock));
                       
        $this->_httpResponseMock->expects($this->once())
                                ->method('getBody')
                                ->will($this->returnValue(file_get_contents(__DIR__ . '/_files/response_lookup.txt')));
                                
        $this->_lookup->setAmgArtistId(39429);
        $this->_lookup->setResultFormat('array');
        
        $this->_lookup->query();
        
        $this->_lookup->getResultCount();
    }
}