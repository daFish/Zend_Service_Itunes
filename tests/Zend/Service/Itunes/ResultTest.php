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
}