<?php
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Zend_Service_ItunesTest::main');
}

require_once '../../../bootstrap.php';

/** Zend_Service_Itunes */
require_once 'Zend/Service/Itunes/Search.php';

/** Zend_Http_Client */
require_once 'Zend/Http/Client.php';

/** Zend_Http_Client_Adapter_Test */
require_once 'Zend/Http/Client/Adapter/Test.php';

class Zend_Service_Itunes_AbstractTest extends PHPUnit_Framework_TestCase
{
    protected $_filesDir = '';
    
    /* @var Zend_Service_Itunes_Search */
    protected $itunesSearch =   null;
    
    protected function setUp()
    {
        $this->itunesSearch = new Zend_Service_Itunes_Search();
        $this->_filesDir = dirname(__FILE__) . '/_files/';
    }
    
    protected function _stubItunes()
    {
        $client = $this->getMock('Zend_Http_Client', array(), array(), '', false);
        
        $response = $this->getMock('Zend_Http_Response', array(), array(), '', false);
        
        return $client;
    }

    /**
     * Runs the test methods of this class.
     *
     * @return void
     */
    public static function main()
    {
        $suite = new PHPUnit_Framework_TestSuite(__CLASS__);
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }
    
    /**
     * Test setting of options using .ini-file
     */
    public function testSetOptionsWithIniFile()
    {
        $config = new Zend_Config_Ini($this->_filesDir . 'settings.ini', 'itunes');
        $this->itunesSearch->setOptions($config);
        
        $this->assertEquals(array('hans', 'zimmer'), $this->itunesSearch->getTerms(), 'Test of terms.');
        $this->assertEquals('de', $this->itunesSearch->country);
        $this->assertEquals('ja_jp', $this->itunesSearch->language);
        $this->assertEquals(100, $this->itunesSearch->limit);
        $this->assertEquals('no', $this->itunesSearch->explicit);
        $this->assertEquals(1, $this->itunesSearch->version);
        $this->assertEquals('wbCallback', $this->itunesSearch->callback, 'Testing callback setting');
    }
    
    /**
     * Test setter and getter for terms
     */
    public function testSetGetTerms()
    {
        $this->itunesSearch->setTerms(array('christopher', 'gordon'));
        $this->assertEquals(array('christopher', 'gordon'), $this->itunesSearch->getTerms());
    }
    
    public function testSetTermsAsString()
    {
        $this->itunesSearch->setTerms('foobar');
        $this->assertEquals(array('foobar'), $this->itunesSearch->getTerms());
    }
    
    /**
     * Test setter and getter for limit
     */
    public function testSetGetLimit()
    {
        $this->itunesSearch->setLimit(42);
        $this->assertEquals(42, $this->itunesSearch->limit);
    }
    
    /**
     * Test setter and getter for explicity setting
     */
    public function testSetGetExplicity()
    {
        $this->itunesSearch->setExplicit('yes');
        $this->assertEquals('yes', $this->itunesSearch->explicit);
    }
    
    /**
     * Test setter and getter for callback with RESULT_JSON
     */
    public function testSetGetCallback()
    {
        $this->itunesSearch->setResultFormat(Zend_Service_Itunes_ItunesAbstract::RESULT_JSON);
        $this->itunesSearch->setCallback('wbFoobar');
        $this->assertEquals('wbFoobar', $this->itunesSearch->callback);
    }
    
    /**
     * Test setter and getter for callback with RESULT_ARRAY
     * and expect exception
     */
    public function testSetGetCallbackException()
    {
        try {
            $this->itunesSearch->setResultFormat(Zend_Service_Itunes_ItunesAbstract::RESULT_ARRAY);
            $this->itunesSearch->setCallback('wbFoobar');
        }
        catch (Zend_Service_Itunes_Exception $e) {
            return;
        }
        
        $this->fail('An expected exception has not been raised!');
    }
    
    /**
     * Test setter and getter for country
     */
    public function testSetGetCountry()
    {
        $this->itunesSearch->setCountry('gb');
        $this->assertEquals('gb', $this->itunesSearch->country);
    }
    
    /**
     * Test setter and getter for unknown country
     * resulting in emtpy country string (uses webservice
     * defined default of 'us')
     */
    public function testSetGetCountryOutOfRange()
    {
        $this->itunesSearch->setCountry('ddr');
        $this->assertEquals('us', $this->itunesSearch->country);
    }
    
    /**
     * Test setter and getter for language
     */
    public function testSetGetLanguage()
    {
        $this->itunesSearch->setLanguage('ja_jp');
        $this->assertEquals('ja_jp', $this->itunesSearch->language);
    }
    
    /**
     * Test setter and getter media type
     */
    public function testSetGetMediaType()
    {
        $this->itunesSearch->setMediaType(Zend_Service_Itunes_ItunesAbstract::MEDIATYPE_TVSHOW);
        $this->assertEquals(Zend_Service_Itunes_ItunesAbstract::MEDIATYPE_TVSHOW, $this->itunesSearch->mediatype);
    }
    
    /**
     * Test setter and getter for result format
     */
    public function testSetGetResultFormat()
    {
        $this->itunesSearch->setResultFormat(Zend_Service_Itunes_ItunesAbstract::RESULT_ARRAY);
        $this->assertEquals(Zend_Service_Itunes_ItunesAbstract::RESULT_ARRAY, $this->itunesSearch->getResultFormat());
    }
    
    /**
     * Test setter and getter for entity type
     */
    public function testSetGetEntity()
    {
        $temp = array();
        $temp['music'] = 'musicVideo';
        
        $this->itunesSearch->setEntity($temp);
        $this->assertEquals($temp, $this->itunesSearch->entity);
    }
    
    /**
     * Test set entity with empty array
     */
    public function testSetEntityExceptionCountToLow()
    {
        try {
            $this->itunesSearch->setEntity();
        }
        catch (Zend_Service_Itunes_Exception $e) {
            return;
        }
        
        $this->fail('An expected exception has not been raised!');
    }
    
    /**
     * Test set entity with array count of 2
     */
    public function testSetEntityExceptionCountToHigh()
    {
        try {
            $temp = array('foo' => 'bar', 'lorem' => 'ipsum');
            $this->itunesSearch->setEntity($temp);
        }
        catch (Zend_Service_Itunes_Exception $e) {
            return;
        }
        
        $this->fail('An expected exception has not been raised!');
    }
    
    /**
     * Test set/get version incl. failtest when unvalid version
     * should be set
     */
    public function testSetGetVersion()
    {
        $this->itunesSearch->setVersion(1);
        $this->assertEquals(1, $this->itunesSearch->version);
        
        $this->itunesSearch->setVersion(3);
        $this->assertEquals(1, $this->itunesSearch->version);
    }
    
    /**
     * Test if an exception is thrown when attempting to query the service without
     * any settings
     */
    public function testEmptyQuery()
    {
        try {
            $this->itunesSearch->query();
        }
        catch (Zend_Service_Itunes_Exception $e) {
            return;
        }
        
        $this->fail('An expected exception has not been raised!');
    }
    
    /**
     * Test if exception is correctly risen when setting a callback
     * and query the service
     */
    public function testQueryWithCallback()
    {
        $this->itunesSearch->setCallback('wsCallback');
        
        try {
            $this->itunesSearch->query();
        }
        catch (Zend_Service_Itunes_Exception $e) {
            return;
        }
        
        $this->fail('An expected exception has not been raised!');
    }
    
    /**
     * Test if the query successfully calls the service and returns
     * an result
     */
    public function testQuery()
    {
        $this->itunesSearch->setTerms(array('karate', 'kid', 'james', 'horner'))
                           ->setHttpClient($this->_stubItunes());
        
        $this->itunesSearch->query();
    }
    
    /**
     * Test if exception is correctly risen when trying to get
     * an property
     */
    public function testOptionNotSet()
    {
        $this->assertEquals(null, $this->itunesSearch->foobar);
    }
    
    /**
     * Test if the raw request url is correctly assembled
     */
    public function testGetRawRequestUrl()
    {
        $this->itunesSearch->setTerms(array('star', 'trek'))
                           ->setCountry('de');
        
        $this->assertEquals('http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/wsSearch?entity=album&country=de&term=star+trek', $this->itunesSearch->getRawRequestUrl());
    }
}