<?php

require_once('Zend/Service/Abstract.php');

abstract class Zend_Service_Itunes extends Zend_Service_Abstract
{
	/**
	 * Result set data
	 * @var array
	 */
	protected $_results = array();
	
	/**
	 * Result count
	 * @var integer
	 */
	protected $_resultCount = 0;
	
	/**
	 * Country for request
	 * @var string
	 */
	protected $_country = '';
	
	/**
	 * List of countries were iTunes is available
	 * @var array
	 */
	protected $_countryList = array(
		'ar', 'au', 'at', 'be', 'br', 'ca', 'cl', 'cn',
        'co', 'cr', 'hr', 'cz', 'dk', 'do', 'ec', 'eg',
        'sv', 'ee', 'fi', 'fr', 'de', 'gr', 'gt', 'hn',
        'hk', 'hu', 'in', 'id', 'ie', 'il', 'it', 'jm',
        'jp', 'kz', 'kr', 'kw', 'lv', 'lb', 'lt', 'lu',
        'mo', 'my', 'mt', 'mx', 'md', 'nl', 'nz', 'ni',
        'no', 'pk', 'pa', 'py', 'pe', 'ph', 'pl', 'pt',
        'qa', 'ro', 'ru', 'sa', 'sg', 'sk', 'si', 'za',
        'es', 'lk', 'se', 'ch', 'tw', 'th', 'tr', 'gb',
        'us', 'ae', 'uy', 've', 'vn'
	);
	
	/**
	 * Default language of the result
	 * @var $_language string
	 */
	protected $_language = '';
	
	/**
	 * List of available languages for the result
	 * @var $_languageList array
	 */
	protected $_languageList = array(
		'en_us',
		'ja_jp'
	);
	
	/**
	 * Default media type
	 * @var $_mediaType string
	 */
	protected $_mediaType = '';
	
	/**
	 * List of available media types
	 * @var $_mediaTypes array
	 */
	protected $_mediaTypes = array(
		'movie',
		'podcast',
		'music',
		'musicVideo',
		'audiobook',
		'shortFilm',
		'tvShow',
		'all'
	);
	
	/**
	 * Default entity type
	 * @var array
	 */
	protected $_entity = array('all' => 'album');
	
	/**
	 * List of all available entity types
	 * 
	 * @var $_entityList array
	 */
	protected $_entityList = array(
		'movie' => array(
			'movieArtist', 'movie'
			),
		'podcast' => array(
			'podcastAuthor', 'podcast'
			),
		'music' => array(
			'musicArtist', 'musicTrack', 'album', 'musicVideo', 'mix'
			),
		'musicVideo' => array(
			'musicArtist', 'musicVideo'
			),
		'audiobook' => array(
			'audiobookAuthor', 'audiobook'
			),
		'shortFilm' => array(
			'shortFilmArtist', 'shortFilm'
			),
		'tvShow' => array(
			'tvEpisode', 'tvSeason'
			),
		'all' => array(
			'movie', 'album', 'allArtist', 'podcast', 'musicVideo', 'mix', 'audiobook', 'tvSeason', 'allTrack'
			),
	);
	
	protected $_attributesTypes = 
		array(
			'movie' => array(
				'actorTerm', 
				'genreIndex', 
				'artistTerm', 
				'shortFilmTerm', 
				'producerTerm', 
				'ratingTerm', 
				'directorTerm', 
				'releaseYearTerm', 
				'featureFilmTerm', 
				'movieArtistTerm', 
				'movieTerm', 
				'ratingIndex', 
				'descriptionTerm'
			),
			'podcast' => array(
				'titleTerm', 
				'languageTerm', 
				'authorTerm', 
				'genreIndex', 
				'artistTerm', 
				'ratingIndex', 
				'keywordsTerm', 
				'descriptionTerm'
			),
			'music' => array(
				'mixTerm', 
				'genreIndex', 
				'artistTerm', 
				'composerTerm', 
				'albumTerm', 
				'ratingIndex', 
				'songTerm', 
				'musicTrackTerm'
			),
			'musicVideo' => array(
				'genreIndex', 
				'artistTerm', 
				'albumTerm', 
				'ratingIndex', 
				'songTerm'
			),
			'audiobook' => array(
				'titleTerm', 
				'authorTerm', 
				'genreIndex', 
				'ratingIndex'
			),
			'shortFilm' => array(
				'genreIndex', 
				'artistTerm', 
				'shortFilmTerm', 
				'ratingIndex', 
				'descriptionTerm'
			),
			'tvShow' => array(
				'genreIndex', 
				'tvEpisodeTerm', 
				'showTerm', 
				'tvSeasonTerm', 
				'ratingIndex', 
				'descriptionTerm'
			),
			'all' => array(
				'actorTerm', 
				'languageTerm', 
				'allArtistTerm', 
				'tvEpisodeTerm', 
				'shortFilmTerm', 
				'directorTerm', 
				'releaseYearTerm', 
				'titleTerm', 
				'featureFilmTerm', 
				'ratingIndex', 
				'keywordsTerm', 
				'descriptionTerm', 
				'authorTerm', 
				'genreIndex', 
				'mixTerm', 
				'allTrackTerm', 
				'artistTerm', 
				'composerTerm', 
				'tvSeasonTerm', 
				'producerTerm', 
				'ratingTerm', 
				'songTerm', 
				'movieArtistTerm', 
				'showTerm', 
				'movieTerm', 
				'albumTerm'
			)
	);
		
	/**
	 * Result type is JSON
	 * @var string
	 */
	const RESULT_JSON = 'json';

	/**
	 * Result type is an PHP array
	 * @var string
	 */
	const RESULT_ARRAY = 'array';
	
	/**
	 * @var $_resultFormats array
	 */
	protected $_resultFormats = array(
		self::RESULT_ARRAY,
		self::RESULT_JSON
	);
	
	/**
	 * Default result format
	 * @var $_resultFormat unknown_type
	 */
	protected $_resultFormat = self::RESULT_JSON;
	
	/**
	 * Custom limit for results
	 * @var $_limit integer
	 */
	protected $_limit = -1;
	
	/**
	 * Default constructor
	 */
	public function __construct($options = null)
	{
		/**
		 * Init Zend_Http_Client object
		 * @var Zend_Http_Client
		 */
		$this->_clientInstance = self::getHttpClient();
		
		/*
         * Convert Zend_Config argument to config array.
         */
		if($options instanceof Zend_Config)
		{
			$options = $options->toArray();
		}
		
		/**
		 * Verify $options is an array
		 */
		if(is_array($options))
		{
			$this->setOptions($options);
		}
	}
	
	/**
	 * Set configuration
	 * 
	 * @param array $options
	 */
	public function setOptions(array $options)
	{
		foreach($options as $key => $value)
		{
			$option = str_replace('_', ' ', strtolower($key)); 
        	$option = str_replace(' ', '', ucwords($option)); 
			$method = 'set' . $option;
			
			if(method_exists($this, $method))
			{
				$this->$method($value);
			}
		}
	}
	
	/**
	 * Query the service and save result
	 * 
	 * @uses Zend_Service_Itunes::_buildRequestUri()
	 * @return Zend_Service_Itunes Provides a fluent interface
	 */
	public function queryService()
	{
		$this->_clientInstance->setUri($this->_buildRequestUri());
		
		$queryResult = $this->_clientInstance->request()->getBody();
		if($this->_resultFormat === self::RESULT_ARRAY)
		{
			$tmp = Zend_Json::decode($queryResult);
			$this->_results = $tmp['results'];
			$this->_resultCount = (int)$tmp['resultCount'];
		}
		else
		{
			// convert JSON-string to array for extraction of results and resultcount
			$jsonString = Zend_Json::decode($queryResult);
			
			$this->_resultCount = (int)$jsonString['resultCount'];
			$this->_results = Zend_Json::encode($jsonString['results']);
		}
		
		return $this;
	}
	
	/**
	 * Build the request uri
	 */
	protected abstract function _buildRequestUri();
	
	/**
	 * Get the results from query()
	 * 
	 * @return array|string
	 */
	public function getResults()
	{
		return $this->_results;
	}
	
	/**
	 * Get the result count from query()
	 */
	public function getResultCount()
	{
		return $this->_resultCount;
	}
	
	/**
	 * Return country
	 * 
	 * @return string
	 */
	public function getCountry()
	{
		return $this->_country;
	}
	
	/**
	 * Set country for search
	 * 
	 * @param string	$country
	 * @return Zend_Service_Itunes Provides a fluent interface
	 */
	public function setCountry($country = '')
	{
		if(in_array($country, $this->_countryList))
		{
			$this->_country = $country;
		}
		
		return $this;
	}
	
	/**
	 * Return language for result set
	 * 
	 * @return the $_language
	 */
	public function getLanguage()
	{
		return $this->_language;
	}

	/**
	 * Sets the language for the result
	 * 
	 * @param $_language the $_language to set
	 * @return Zend_Service_Itunes Provides a fluent interface
	 */
	public function setLanguage($language = '') 
	{
		if(in_array($language, $this->_languageList))
		{
			$this->_language = $language;
		}
		
		return $this;
	}
	
	/**
	 * Set the used mediatype
	 * 
	 * @param string $mediatype
	 * @return Zend_Service_Itunes Provides a fluent interface
	 */
	public function setMediaType($mediatype = '')
	{
		if(in_array($mediatype, $this->_mediaTypes))
		{
			$this->_mediaType = $mediatype;
		}
		
		return $this;
	}
	
	/**
	 * Get the actual set mediatype
	 * 
	 * @return string
	 */
	public function getMediaType()
	{
		return $this->_mediaType;
	}
	
	/**
	 * Set the result format
	 * 
	 * @param string $format
	 * @return Zend_Service_Itunes Provides a fluent interface
	 */
	public function setResultFormat($format = self::RESULT_ARRAY)
	{
		if(in_array($format, $this->_resultFormats))
		{
			$this->_resultFormat = $format;
		}
		
		return $this;
	}
	
	/**
	 * Get the result format
	 * 
	 * @return string
	 */
	public function getResultFormat()
	{
		return $this->_resultFormat;
	}
	
	/**
	 * Get the actual set limit
	 * 
	 * @return integer
	 */
	public function getLimit()
	{
		return $this->_limit;
	}
	
	/**
	 * Set the limit
	 * 
	 * @param integer $limit
	 * @return Zend_Service_Itunes Provides a fluent interface
	 */
	public function setLimit($limit = -1)
	{
		$this->_limit = (int)$limit;
		
		return $this;
	}
	
	/**
	 * Return the entity for the result
	 */
	public function getEntity()
	{
		return $this->_entity;
	}
	
	/**
	 * Set the entity for the result
	 * 
	 * @param unknown_type $entity
	 * @return Zend_Service_Itunes Provides a fluent interface
	 */
	public function setEntity($entity = array())
	{
		// check if only one key => value pair is given
		if(count($entity) <> 1)
		{
			require_once 'Zend/Service/Itunes/Exception.php';
			throw new Zend_Service_Itunes_Exception('Must be set with one key/value-pair!');
		}
		
		$key = array_pop(array_keys($entity));
		
		// check if the key of the given array exists
		if(array_key_exists($key, $this->_entityList))
		{
			// check if value exists for key
			if(in_array($entity[$key], $this->_entityList[$key]))
				$this->_entity = $entity;
		}
		
		return $this;
	}
}