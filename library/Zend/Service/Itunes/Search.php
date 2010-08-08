<?php

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Itunes
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_Itunes_Search extends Zend_Service_Itunes_ItunesAbstract
{
    /**
     * URI for search service
     * 
     * @var string
     */
    protected $_uri = 'http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/wsSearch?';
    
    /**
     * Query term array
     * 
     * @var     array
     */
    protected $_searchTerms = array();
    
    /**
     * Builds the request uri for parameters specifically used in:
     *     - Zend_Service_Itunes_Search
     * 
     * @throws  Zend_Service_Itunes_Exception
     * @return  void
     */
    protected function _buildSpecificRequestUri()
    {
        $requestParameters = array();
        
        // trigger parent::_buildRequestUri
        $_uri = parent::_buildRequestUri();
        if (!empty($_uri))
            $requestParameters[] = $_uri;
        
        if (empty($this->_searchTerms)) {
            require_once 'Zend/Service/Itunes/Exception.php';
            throw new Zend_Service_Itunes_Exception('Cannot query service if 
                no terms are set!');
        }
        
        // add terms
        $requestParameters[] = 'term=' . 
            implode('+', array_map('urlencode', $this->_searchTerms));
        
        // build request parameter string
        $request = implode('&', $requestParameters);
        
        $this->_rawRequestUrl = $this->getUri() . $request;
    }
    
    public function getRawRequestUrl()
    {
        if ($this->_rawRequestUrl == '') {
            $this->_buildSpecificRequestUri();
        }
        
        return $this->_rawRequestUrl;
    }
    
    /**
     * Return search term
     * 
     * @return array
     */
    public function getTerms()
    {
        return $this->_searchTerms;
    }
    
    /**
     * Add new search terms
     * 
     * @param   string|array     $term
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function setTerms($terms = '')
    {
        if (!is_array($terms)) {
            $terms = (array)$terms;
        }
        
        // replace all whitespaces with +
        foreach ($terms as &$term) {
            $term = str_replace(' ', '+', $term);
        }
        
        $this->_searchTerms = array_merge($terms, $this->_searchTerms);
        
        return $this;
    }
}