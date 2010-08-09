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
class Zend_Service_Itunes_ResultTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Zend_Service_Itunes_ResultSet
     */
    protected $_resultMock = null;
    
    public function setUp()
    {
        $this->_resultMock = new Zend_Service_Itunes_ResultSet(file_get_contents(dirname(__FILE__) . '/_files/response_search.txt'));
    }
    
    /**
     * Test of Zend_Service_Itunes_ResultSet types
     */
    public function testResultIteration()
    {
        foreach ($this->_resultMock as $result)
        {
            $this->assertType('Zend_Service_Itunes_Result', $result);
        }
    }
    
    /**
     * Test getting of property
     */
    public function testResultIterationGet()
    {
        foreach ($this->_resultMock as $result)
        {
            $this->assertEquals('James Horner', $result->artistName);
        }
    }
    
    /**
     * Test for unknown property
     */
    public function testResultIterationGetUnknown()
    {
        foreach ($this->_resultMock as $result)
        {
            $this->assertEquals(null, $result->artistNameddd);
        }
    }
    
    /**
     * Test of position seek
     */
    public function testSeek()
    {
        $this->_resultMock->seek(0);
    }
    
    /**
     * Test of unknown position seek
     * 
     * @expectedException OutOfBoundsException
     */
    public function testResultSeekOutOfBounds()
    {
        $this->_resultMock->seek(23);
    }
    
    /**
     * Test of current key
     */
    public function testResultKey()
    {
        $this->assertEquals(0, $this->_resultMock->key());
    }
}