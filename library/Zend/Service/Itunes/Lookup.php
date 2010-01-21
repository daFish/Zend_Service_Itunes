<?php

require_once ('Zend/Service/Itunes.php');

class Zend_Service_Itunes_Lookup extends Zend_Service_Itunes {
	
	const BASE_URI = 'http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/wsLookup?';

	/**
	 * @var Zend_Http_Client
	 */
	protected $_clientInstance = null;
	
	/**
	 * Lookup can be either:
	 * 	-	artistId
	 * 	-	collectionId
	 * 
	 * @var $_lookupId integer
	 */
	protected $_lookupId = 0;
	
	/**
	 * amgArtistId
	 * 
	 * @var $_amgArtistId integer
	 */
	protected $_amgArtistIds = array();
	
	/**
	 * Resetting any entities set by the parent class.
	 * This is due to the standard request format for
	 * any lookup.
	 * 
	 * @var $_entity string
	 */
	protected $_entity = '';
	
	public function __construct($options = null)
	{
		parent::__construct($options);
		
		$this->_clientInstance = parent::getHttpClient();
	}
	
	/**
	 * Builds the request uri for parameters specifically used in:
	 * 	- Zend_Service_Itunes_Lookup
	 */
	protected function _buildSpecificRequestUri() 
	{
		$requestParameters = array();
		
		// trigger parent::_buildRequestUri
		$_uri = parent::_buildRequestUri();
		if(!empty($_uri))
			$requestParameters[] = $_uri;
		
		require_once 'Zend/Service/Itunes/Exception.php';
		if($this->_lookupId === 0 XOR !empty($this->_amgArtistIds))
		{
			throw new Zend_Service_Itunes_Exception('There is no lookupId or amgArtistId set.');
		}
		
		// check if both lookupId and amgArtistId are set
		if($this->_lookupId > 0 AND !empty($this->_amgArtistIds))
		{
			throw new Zend_Service_Itunes_Exception('Please use either lookupId or amgArtistId.');
		}
		
		
		
		// add lookupId
		if($this->_lookupId > 0)
			$requestParameters[] = 'id=' . $this->_lookupId;
		
		// add amgArtistIds if present
		if(!empty($this->_amgArtistIds))
			$requestParameters[] = 'amgArtistId=' . implode(',', $this->_amgArtistIds);
		
		// build request parameter string
		$request = implode('&', $requestParameters);
		
		$this->_rawRequestUrl = self::BASE_URI . $request;
	}
	
	/**
	 * Set the lookupId
	 * 
	 * @param integer $id
	 * @return Zend_Service_Itunes Provides a fluent interface
	 */
	public function setLookupId($id = 0)
	{
		$this->_lookupId = (int)$id;
		
		return $this;
	}
	
	/**
	 * Get the set lookupId
	 * 
	 * @return integer
	 */
	public function getLookupId()
	{
		return $this->_lookupId;
	}
	
	/**
	 * Set an amgArtistId
	 * 
	 * @param integer $id
	 * @return Zend_Service_Itunes Provides a fluent interface
	 */
	public function setAmgArtistId($id = 0)
	{
		$this->_amgArtistIds[] = (int)$id;
		
		return $this;
	}
	
	/**
	 * Get all set amgArtistIds
	 * 
	 * return array
	 */
	public function getAmgArtistIds()
	{
		return $this->_amgArtistIds;
	}
}