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
class Zend_Service_Itunes_ItunesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Zend_Service_Itunes_Search
     */
    protected $_itunesSearch =   null;
    
    /**
     * @var string
     */
    protected $_filesDir = '';
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_itunesSearch = new Zend_Service_Itunes_Search;
        $this->_filesDir = __DIR__ . '/_files/';
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setTerms
     */
    public function testTerms()
    {
        $this->_itunesSearch->setTerms(array('christopher', 'gordon'));
        $this->assertEquals(array('christopher', 'gordon'), $this->_itunesSearch->getTerms());
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setTerms
     */
    public function testTermsNotArray()
    {
        $this->_itunesSearch->setTerms('star');
        $this->assertEquals(array('star'), $this->_itunesSearch->getTerms());
    }
    
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
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::__constructor
     */
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
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setLimit
     */
    public function testSetGetLimit()
    {
        $this->_itunesSearch->setLimit(42);
        $this->assertEquals(42, $this->_itunesSearch->limit);
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setExplicit
     */
    public function testSetGetExplicity()
    {
        $this->_itunesSearch->setExplicit('yes');
        $this->assertEquals('yes', $this->_itunesSearch->explicit);
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setCallback
     */
    public function testSetGetCallback()
    {
        $this->_itunesSearch->setResultFormat(Zend_Service_Itunes_ItunesAbstract::RESULT_JSON);
        $this->_itunesSearch->setCallback('wbFoobar');
        $this->assertEquals('wbFoobar', $this->_itunesSearch->callback);
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setCallback
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
     * Test of Zend_Service_Itunes_ItunesAbstract::setCountry
     */
    public function testSetGetCountry()
    {
        $this->_itunesSearch->setCountry('gb');
        $this->assertEquals('gb', $this->_itunesSearch->country);
    }
    
    /**
     * Test of default value for country
     */
    public function testCountryDefaultValue()
    {
        $this->assertEquals('us', $this->_itunesSearch->country);
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
     * Test of Zend_Service_Itunes_ItunesAbstract::setLanguage
     */
    public function testSetGetLanguage()
    {
        $this->_itunesSearch->setLanguage('ja_jp');
        $this->assertEquals('ja_jp', $this->_itunesSearch->language);
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setMediaType
     */
    public function testSetGetMediaType()
    {
        $this->_itunesSearch->setMediaType(Zend_Service_Itunes_ItunesAbstract::MEDIATYPE_TVSHOW);
        $this->assertEquals(Zend_Service_Itunes_ItunesAbstract::MEDIATYPE_TVSHOW, $this->_itunesSearch->mediaType);
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setResultFormat
     */
    public function testSetGetResultFormat()
    {
        $this->_itunesSearch->setResultFormat(Zend_Service_Itunes_ItunesAbstract::RESULT_ARRAY);
        $this->assertEquals(Zend_Service_Itunes_ItunesAbstract::RESULT_ARRAY, $this->_itunesSearch->getResultFormat());
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setEntity
     */
    public function testSetGetEntity()
    {
        $temp = array();
        $temp['music'] = 'musicVideo';
        
        $this->_itunesSearch->setEntity($temp);
        $this->assertEquals($temp, $this->_itunesSearch->entity);
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setEntity
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testSetEntityExceptionCountToLow()
    {
        $this->_itunesSearch->setEntity();
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setEntity
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
     * Test of Zend_Service_Itunes_ItunesAbstract::setVersion
     */
    public function testSetGetVersion()
    {
        $this->_itunesSearch->setVersion(1);
        $this->assertEquals(1, $this->_itunesSearch->version);
        
        $this->_itunesSearch->setVersion(3);
        $this->assertEquals(1, $this->_itunesSearch->version);
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::query
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testEmptyQuery()
    {
        $this->_itunesSearch->query();
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::query
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
     * Test of Zend_Service_Itunes_ItunesAbstract::getRawRequestUrl
     */
    public function testGetRawRequestUrl()
    {
        $this->_itunesSearch->setTerms(array('star', 'trek'))
                            ->setCountry('de')
                            ->setCallback('wsCallback');
        
        $this->assertEquals('http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/wsSearch?entity=album&country=de&callback=wsCallback&term=star+trek', $this->_itunesSearch->getRawRequestUrl());
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setAttribute
     */
    public function testAttribute()
    {
        $this->_itunesSearch->setMediaType(Zend_Service_Itunes_ItunesAbstract::MEDIATYPE_MUSIC);
        $this->_itunesSearch->setAttribute('albumTerm');
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setAttribute
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testAttributeWithEmptyMediaType()
    {
        $this->_itunesSearch->setAttribute('albumTerm');
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::setAttribute
     * 
     * @expectedException Zend_Service_Itunes_Exception
     */
    public function testAttributeWrongAttributeToMediaType()
    {
        $this->_itunesSearch->setMediaType(Zend_Service_Itunes_ItunesAbstract::MEDIATYPE_MUSIC);
        $this->_itunesSearch->setAttribute('actorTerm');
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::getCountries
     */
    public function testGetListOfCountries()
    {
        $this->assertType('array', $this->_itunesSearch->getCountries());
    }
    
    /**
     * Test of Zend_Service_Itunes_ItunesAbstract::query
     */
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