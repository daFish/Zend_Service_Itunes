<?php

require_once ('Zend/Service/Itunes.php');

class Zend_Service_Itunes_Search extends Zend_Service_Itunes {

	const BASE_URI = 'http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/wsSearch?';
	
	/**
	 * @var Zend_Http_Client
	 */
	protected $_clientInstance = null;
	
	/**
	 * Query term array
	 * @var array
	 */
	protected $_searchTerms = array();
	
	public function __construct($options)
	{
		parent::setOptions($options);
		
		$this->_clientInstance = parent::getHttpClient();
	}
	
	protected function _buildRequestUri()
	{
		if(empty($this->_searchTerms))
		{
			require_once 'Zend/Service/Itunes/Exception.php';
			throw new Zend_Service_Itunes_Exception('Cannot query service if no searchterms are set!');
		}
		
		$requestParameters = array();
		
		$requestParameters[] = 'term=' . implode('+', array_map('urlencode', $this->_searchTerms));
		
		$request = implode('&', $requestParameters);
		return self::BASE_URI . $request;
	}
	
	/**
	 * Return search term
	 * 
	 * @return array
	 */
	public function getTerms()
	{
		return $this->_terms;
	}
	
	/**
	 * Add new search terms
	 * 
	 * @param string|array 	$term
	 * @return Zend_Service_Itunes Provides a fluent interface
	 */
	public function setTerms($terms = '')
	{
		if(!is_array($terms))
		{
			$terms = (array)$terms;
		}
		
		$this->_searchTerms = array_merge($terms, $this->_searchTerms);
		
		return $this;
	}
}