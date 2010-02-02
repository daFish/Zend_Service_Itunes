<?php

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Itunes
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_Itunes_ResultSet implements SeekableIterator
{
    /**
     * Resultsset
     * 
     * @var array
     */
    protected $_results = array();
    
    /**
     * Iterator position
     * 
     * @var int
     */
    protected $_position = 0;
    
    /**
     * Constructor
     * 
     * @param array $result
     */
    public function __construct(array $result)
    {
        $results = Zend_Json::decode($result);
        $this->_results = $results['results'];
    }

    /**
     * Return current result from resultset
     * 
     * @return  Zend_Service_Itunes_Search_Result
     */
    public function current ()
    {
        return new Zend_Service_Itunes_Result($this->_results[$this->_position]);
    }

    /**
     * Return the current position
     * 
     * @return int
     */
    public function key ()
    {
        return $this->_position;
    }

    /**
     * Increment position by 1
     */
    public function next ()
    {
        $this->_position++;
    }

    /**
     * Set position to 0
     */
    public function rewind ()
    {
        $this->_position = 0;
    }

    /**
     * Set position to specific position
     * 
     * @param   int $position
     * @throws  OutOfBoundsException
     */
    public function seek ($position = 0)
    {
        $this->_position = $position;
        
        if (!$this->valid()) {
            throw new OutOfBoundsException('Invalid seek position.');
        }
    }

    /**
     * Check if current position is valid
     * 
     * @return bool
     */
    public function valid ()
    {
        if ($this->_position < count($this->_results)) {
            return true;
        }
        
        return false;
    }
}