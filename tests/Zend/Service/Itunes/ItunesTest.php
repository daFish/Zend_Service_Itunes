<?php
class Zend_Service_Itunes_ItunesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Zend_Service_Itunes_Search
     */
    protected $_itunesSearch =   null;
    
    protected $_filesDir = '';
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_itunesSearch = new Zend_Service_Itunes_Search;
        $this->_filesDir = __DIR__ . '/_files/';
    }
    
    /**
     * Test setter and getter for terms
     */
    public function testTerms()
    {
        $this->_itunesSearch->setTerms(array('christopher', 'gordon'));
        $this->assertEquals(array('christopher', 'gordon'), $this->_itunesSearch->getTerms());
    }
    
    public function testTermsNotArray()
    {
        $this->_itunesSearch->setTerms('star');
        $this->assertEquals(array('star'), $this->_itunesSearch->getTerms());
    }
    
    /*protected function _stubItunes()
    {
        $client = $this->getMock('Zend_Http_Client', array(), array(), '', false);
        
        $response = $this->getMock('Zend_Http_Response', array(), array(), '', false);
        
        return $client;
    }*/
    
    /**
     * Test setting of options using .ini-file
     */
    public function testSetOptionsWithIniFile()
    {
        $config = new Zend_Config_Ini($this->_filesDir . 'settings.ini', 'itunes');
        $this->_itunesSearch->setOptions($config);
        
        $this->assertEquals(array('hans', 'zimmer'), $this->_itunesSearch->getTerms(), 'Test of terms.');
        $this->assertEquals('de', $this->_itunesSearch->country);
        $this->assertEquals('ja_jp', $this->_itunesSearch->language);
        $this->assertEquals(100, $this->_itunesSearch->limit);
        $this->assertEquals('no', $this->_itunesSearch->explicit);
        $this->assertEquals(1, $this->_itunesSearch->version);
        $this->assertEquals('wbCallback', $this->_itunesSearch->callback, 'Testing callback setting');
    }
    
    public function testSetOptionsThroughConstructor()
    {
        $config = new Zend_Config_Ini($this->_filesDir . 'settings.ini', 'itunes');
        $itunes = new Zend_Service_Itunes_Search($config);
        
        $this->assertEquals(array('hans', 'zimmer'), $itunes->getTerms(), 'Test of terms.');
        $this->assertEquals('de', $itunes->country);
        $this->assertEquals('ja_jp', $itunes->language);
        $this->assertEquals(100, $itunes->limit);
        $this->assertEquals('no', $itunes->explicit);
        $this->assertEquals(1, $itunes->version);
        $this->assertEquals('wbCallback', $itunes->callback, 'Testing callback setting');
    }
    
    public function testSetTermsAsString()
    {
        $this->_itunesSearch->setTerms('foobar');
        $this->assertEquals(array('foobar'), $this->_itunesSearch->getTerms());
    }
    
    /**
     * Test setter and getter for limit
     */
    public function testSetGetLimit()
    {
        $this->_itunesSearch->setLimit(42);
        $this->assertEquals(42, $this->_itunesSearch->limit);
    }
    
    /**
     * Test setter and getter for explicity setting
     */
    public function testSetGetExplicity()
    {
        $this->_itunesSearch->setExplicit('yes');
        $this->assertEquals('yes', $this->_itunesSearch->explicit);
    }
    
    /**
     * Test setter and getter for callback with RESULT_JSON
     */
    public function testSetGetCallback()
    {
        $this->_itunesSearch->setResultFormat(Zend_Service_Itunes_ItunesAbstract::RESULT_JSON);
        $this->_itunesSearch->setCallback('wbFoobar');
        $this->assertEquals('wbFoobar', $this->_itunesSearch->callback);
    }
    
    /**
     * Test setter and getter for callback with RESULT_ARRAY
     * and expect exception
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testSetGetCallbackException()
    {
        $this->_itunesSearch->setResultFormat(Zend_Service_Itunes_ItunesAbstract::RESULT_ARRAY);
        $this->_itunesSearch->setCallback('wbFoobar');
        
        $this->fail('An expected exception has not been raised!');
    }
    
    /**
     * Test setter and getter for country
     */
    public function testSetGetCountry()
    {
        $this->_itunesSearch->setCountry('gb');
        $this->assertEquals('gb', $this->_itunesSearch->country);
    }
    
    /**
     * Test setter and getter for unknown country
     * resulting in emtpy country string (uses webservice
     * defined default of 'us')
     */
    public function testSetGetCountryOutOfRange()
    {
        $this->_itunesSearch->setCountry('ddr');
        $this->assertEquals('us', $this->_itunesSearch->country);
    }
    
    /**
     * Test setter and getter for language
     */
    public function testSetGetLanguage()
    {
        $this->_itunesSearch->setLanguage('ja_jp');
        $this->assertEquals('ja_jp', $this->_itunesSearch->language);
    }
    
    /**
     * Test setter and getter media type
     */
    public function testSetGetMediaType()
    {
        $this->_itunesSearch->setMediaType(Zend_Service_Itunes_ItunesAbstract::MEDIATYPE_TVSHOW);
        $this->assertEquals(Zend_Service_Itunes_ItunesAbstract::MEDIATYPE_TVSHOW, $this->_itunesSearch->mediaType);
    }
    
    /**
     * Test setter and getter for result format
     */
    public function testSetGetResultFormat()
    {
        $this->_itunesSearch->setResultFormat(Zend_Service_Itunes_ItunesAbstract::RESULT_ARRAY);
        $this->assertEquals(Zend_Service_Itunes_ItunesAbstract::RESULT_ARRAY, $this->_itunesSearch->getResultFormat());
    }
    
    /**
     * Test setter and getter for entity type
     */
    public function testSetGetEntity()
    {
        $temp = array();
        $temp['music'] = 'musicVideo';
        
        $this->_itunesSearch->setEntity($temp);
        $this->assertEquals($temp, $this->_itunesSearch->entity);
    }
    
    /**
     * Test set entity with empty array
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testSetEntityExceptionCountToLow()
    {
        $this->_itunesSearch->setEntity();
        
        $this->fail('An expected exception has not been raised!');
    }
    
    /**
     * Test set entity with array count of 2
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testSetEntityExceptionCountToHigh()
    {
        $temp = array('foo' => 'bar', 'lorem' => 'ipsum');
        $this->_itunesSearch->setEntity($temp);

        $this->fail('An expected exception has not been raised!');
    }
    
    /**
     * Test set/get version incl. failtest when unvalid version
     * should be set
     */
    public function testSetGetVersion()
    {
        $this->_itunesSearch->setVersion(1);
        $this->assertEquals(1, $this->_itunesSearch->version);
        
        $this->_itunesSearch->setVersion(3);
        $this->assertEquals(1, $this->_itunesSearch->version);
    }
    
    /**
     * Test if an exception is thrown when attempting to query the service without
     * any settings
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testEmptyQuery()
    {
        $this->_itunesSearch->query();
        
        $this->fail('An expected exception has not been raised!');
    }
    
    /**
     * Test if exception is correctly risen when setting a callback
     * and query the service
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testQueryWithCallback()
    {
        $this->_itunesSearch->setCallback('wsCallback');
        
        $this->_itunesSearch->query();
    }
    
    /**
     * Test if exception is correctly risen when trying to get
     * an property
     */
    public function testOptionNotSet()
    {
        $this->assertEquals(null, $this->_itunesSearch->foobar);
    }
    
    /**
     * Test if the raw request url is correctly assembled
     */
    public function testGetRawRequestUrl()
    {
        $this->_itunesSearch->setTerms(array('star', 'trek'))
                           ->setCountry('de')
                           ->setCallback('wsCallback');
        
        $this->assertEquals('http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/wsSearch?entity=album&country=de&callback=wsCallback&term=star+trek', $this->_itunesSearch->getRawRequestUrl());
    }
    
    public function testAttribute()
    {
        $this->_itunesSearch->setMediaType(Zend_Service_Itunes_ItunesAbstract::MEDIATYPE_MUSIC);
        $this->_itunesSearch->setAttribute('albumTerm');
    }
    
    /**
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testAttributeWithEmptyMediaType()
    {
        $this->_itunesSearch->setAttribute('albumTerm');
    }
    
    /**
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testAttributeWrongAttributeToMediaType()
    {
        $this->_itunesSearch->setMediaType(Zend_Service_Itunes_ItunesAbstract::MEDIATYPE_MUSIC);
        $this->_itunesSearch->setAttribute('actorTerm');
    }
    
    public function testGetListOfCountries()
    {
        $this->assertType('array', $this->_itunesSearch->getCountries());
    }
    
    public function testQueryWithCustomSettings()
    {
        $this->_itunesSearch->setMediaType('podcast');
        $this->_itunesSearch->setTerms('star');
        $this->_itunesSearch->setAttribute('authorTerm');
        $this->_itunesSearch->setLanguage('ja_jp');
        $this->_itunesSearch->setLimit(1);
        $this->_itunesSearch->setVersion(1);
        $this->_itunesSearch->setExplicit('no');
        
        $this->_itunesSearch->query();
    }
}