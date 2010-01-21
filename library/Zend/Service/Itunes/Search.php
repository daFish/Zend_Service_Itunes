<?php

require_once ('Zend/Service/Itunes.php');

class Zend_Service_Itunes_Search extends Zend_Service_ItunesAbstract
{

    const BASE_URI = 'http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/wsSearch?';
    
    /**
     * @var Zend_Http_Client
     */
    protected $_clientInstance = null;
    
    /**
     * Query term array
     * 
     * @var     array
     */
    protected $_searchTerms = array();
    
    public function __construct($options = null)
    {
        parent::__construct($options);
        
        $this->_clientInstance = parent::getHttpClient();
    }
    
    /**
     * Builds the request uri for parameters specifically used in:
     *     - Zend_Service_Itunes_Search
     * 
     * @throws Zend_Service_Itunes_Exception
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
        
        $this->_rawRequestUrl = self::BASE_URI . $request;
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