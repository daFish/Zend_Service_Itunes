<?php
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Zend_Service_LookupTest::main');
}

require_once '../../../bootstrap.php';

/** Zend_Service_Itunes */
require_once 'Zend/Service/Itunes/Search.php';

/** Zend_Http_Client */
require_once 'Zend/Http/Client.php';

/** Zend_Http_Client_Adapter_Test */
require_once 'Zend/Http/Client/Adapter/Test.php';

class Zend_Service_Itunes_LookupTest extends PHPUnit_Framework_TestCase
{
    /* @var Zend_Service_Itunes_Lookup */
    protected $itunesLookup;
    
    protected function setUp()
    {
        $this->itunesLookup = new Zend_Service_Itunes_Lookup();
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
     * Test of correct instance creation
     */
    public function testInstance()
    {
        $this->assertThat($this->itunesLookup, $this->isInstanceOf('Zend_Service_Itunes_ItunesAbstract'));
        $this->assertThat($this->itunesLookup, $this->isInstanceOf('Zend_Service_Itunes_Lookup'));
    }
    
    public function testCheckLookupUri()
    {
        $this->assertEquals('http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/wsLookup?', $this->itunesLookup->getUri());
    }
    
    
}