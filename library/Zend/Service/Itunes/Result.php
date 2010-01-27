<?php

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Itunes
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_Itunes_Result
{
    /**
     * Result
     * 
     * @var array
     */
    protected $_result = array();
    
    /**
     * Constructor
     * 
     * @param array $result
     */
    public function __construct($result = array())
    {
        foreach ($result as $key => $val) {
            $this->_result[$key] = $val;
        }
    }
    
    /**
     * Magic method for retrieving values
     * from result
     * 
     * @param string    $key
     */
    public function __get($key = '')
    {
        if (isset($this->_result[$key])) {
            return $this->_result[$key];
        }
    }
}