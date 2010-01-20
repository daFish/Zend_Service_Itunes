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
	
	public function __construct($options)
	{
		parent::__construct($options);
		
		$this->_clientInstance = parent::getHttpClient();
	}
	
	/**
	 * 
	 */
	protected function _buildRequestUri() 
	{
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
		
		$requestParameters = array();
		
		if($this->_lookupId > 0)
			$requestParameters[] = 'id=' . $this->_lookupId;
		
		if(!empty($this->_amgArtistIds))
			$requestParameters[] = 'amgArtistId=' . implode(',', $this->_amgArtistIds);
		
		if(!empty($this->_entity))
		{
			$key = array_pop(array_keys($this->_entity));
			$requestParameters[] = 'entity=' . $this->_entity[$key];
		}
			
		$request = implode('&', $requestParameters);

		return self::BASE_URI . $request;
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