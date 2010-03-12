<?php
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Zend_Service_SearchTest::main');
}

require_once '../../../bootstrap.php';

/** Zend_Service_Itunes */
require_once 'Zend/Service/Itunes/Search.php';

/** Zend_Http_Client */
require_once 'Zend/Http/Client.php';

/** Zend_Http_Client_Adapter_Test */
require_once 'Zend/Http/Client/Adapter/Test.php';

class Zend_Service_Itunes_SearchTest extends PHPUnit_Framework_TestCase
{
    /* @var Zend_Service_Itunes_Search */
    protected $itunesSearch;
    
    protected function setUp()
    {
        $this->itunesSearch = new Zend_Service_Itunes_Search();
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
    public function testCreateInstance()
    {
        $this->assertThat($this->itunesSearch, $this->isInstanceOf('Zend_Service_Itunes_Search'));
    }
}