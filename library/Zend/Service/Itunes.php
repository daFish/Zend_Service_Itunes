<?php

require_once('Zend/Service/Abstract.php');

abstract class Zend_Service_ItunesAbstract extends Zend_Service_Abstract
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
     * Default country for request
     * @var string
     */
    protected $_country = 'us';
    
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
    protected $_languageList = array('en_us', 'ja_jp');
    
    const MEDIATYPE_ALL         = 'all';
    const MEDIATYPE_PODCAST     = 'podcast';
    const MEDIATYPE_MUSIC         = 'music';
    const MEDIATYPE_MUSICVIDEO     = 'musicVideo';
    const MEDIATYPE_AUDIOBOOK    = 'audiobook';
    const MEDIATYPE_SHORTFILM    = 'shortFilm';
    const MEDIATYPE_TVSHOW        = 'tvShow';
    const MEDIATYPE_MOVIE        = 'movie';
    
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
        self::MEDIATYPE_ALL,
        self::MEDIATYPE_AUDIOBOOK,
        self::MEDIATYPE_MUSIC,
        self::MEDIATYPE_MUSICVIDEO,
        self::MEDIATYPE_PODCAST,
        self::MEDIATYPE_SHORTFILM,
        self::MEDIATYPE_TVSHOW
    );
    
    /**
     * Default entity type
     * @var array
     */
    protected $_entity = array(self::MEDIATYPE_ALL => 'album');
    
    /**
     * List of all available entity types
     * 
     * @var $_entityList array
     */
    protected $_entityList = array(
        self::MEDIATYPE_MOVIE => array(
            'movieArtist',
            'movie'
            ),
        self::MEDIATYPE_PODCAST => array(
            'podcastAuthor',
            'podcast'
            ),
        self::MEDIATYPE_MUSIC => array(
            'musicArtist',
            'musicTrack',
            'album',
            'musicVideo',
            'mix'
            ),
        self::MEDIATYPE_MUSICVIDEO => array(
            'musicArtist',
            'musicVideo'
            ),
        self::MEDIATYPE_AUDIOBOOK => array(
            'audiobookAuthor',
            'audiobook'
            ),
        self::MEDIATYPE_SHORTFILM => array(
            'shortFilmArtist',
            'shortFilm'
            ),
        self::MEDIATYPE_TVSHOW => array(
            'tvEpisode',
            'tvSeason'
            ),
        self::MEDIATYPE_ALL => array(
            'movie',
            'album',
            'allArtist',
            'podcast',
            'musicVideo',
            'mix', 
            'audiobook',
            'tvSeason',
            'allTrack'
            ),
    );
    
    protected $_attribute = '';
    
    protected $_attributesTypes = 
        array(
            self::MEDIATYPE_MOVIE => array(
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
            self::MEDIATYPE_PODCAST => array(
                'titleTerm', 
                'languageTerm', 
                'authorTerm', 
                'genreIndex', 
                'artistTerm', 
                'ratingIndex', 
                'keywordsTerm', 
                'descriptionTerm'
            ),
            self::MEDIATYPE_MUSIC => array(
                'mixTerm', 
                'genreIndex', 
                'artistTerm', 
                'composerTerm', 
                'albumTerm', 
                'ratingIndex', 
                'songTerm', 
                'musicTrackTerm'
            ),
            self::MEDIATYPE_MUSICVIDEO => array(
                'genreIndex', 
                'artistTerm', 
                'albumTerm', 
                'ratingIndex', 
                'songTerm'
            ),
            self::MEDIATYPE_AUDIOBOOK => array(
                'titleTerm', 
                'authorTerm', 
                'genreIndex', 
                'ratingIndex'
            ),
            self::MEDIATYPE_SHORTFILM => array(
                'genreIndex', 
                'artistTerm', 
                'shortFilmTerm', 
                'ratingIndex', 
                'descriptionTerm'
            ),
            self::MEDIATYPE_TVSHOW => array(
                'genreIndex', 
                'tvEpisodeTerm', 
                'showTerm', 
                'tvSeasonTerm', 
                'ratingIndex', 
                'descriptionTerm'
            ),
            self::MEDIATYPE_ALL => array(
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
     * 
     * @var $_resultFormat unknown_type
     */
    protected $_resultFormat = self::RESULT_JSON;
    
    /**
     * Default limit for results
     * 
     * @var $_limit integer
     */
    protected $_limit = 0;
    
    /**
     * Name of the custom callback Javascript function
     * which can be used in combination with getRawRequestUrl()
     * 
     * @var $_callback string
     */
    protected $_callback = '';
    
    /**
     * Complete assembled request url.
     * 
     * @var $_rawRequestUrl string
     */
    protected $_rawRequestUrl = '';
    
    /**
     * The iTunes Store search result key version you want to receive 
     * back from your search.
     * 
     * @var $_version integer
     */
    protected $_version = 2;
    
    /**
     * A flag indicating whether or not you want the iTunes Store to include 
     * explicit content in your search results.
     * 
     * @var $_explicit string
     */
    protected $_explicit = 'yes';
    
    protected $_explicitTypes = array('yes', 'no');
    
    /**
     * Default constructor
     */
    public function __construct ($options = null)
    {
        /**
         * Init Zend_Http_Client object
         * 
         * @var Zend_Http_Client
         */
        $this->_clientInstance = self::getHttpClient();
        
        /*
         * Convert Zend_Config argument to config array.
         */
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        }
        
        /**
         * Verify $options is an array
         */
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    /**
     * Set configuration
     * 
     * @param   array $options
     * @return  void
     */
    public function setOptions (array $options)
    {
        foreach ($options as $key => $value) {
            $option = str_replace('_', ' ', strtolower($key)); 
            $option = str_replace(' ', '', ucwords($option)); 
            $method = 'set' . $option;
            
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
    
    /**
     * Query the service and save result
     * 
     * @uses    Zend_Service_Itunes::_buildRequestUri()
     * @throws  Zend_Service_Itunes_Exception
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function queryService()
    {
        // cannot be called when callback is set
        if (!empty($this->_callback)) {
            require_once 'Zend/Service/Itunes/Exception.php';
            throw new Zend_Service_Itunes_Exception('Cannot run queryService 
                when callback is set.');
        }
        
        $this->_buildSpecificRequestUri();
        
        $this->_clientInstance->setUri($this->_rawRequestUrl);
        
        $queryResult = $this->_clientInstance->request()->getBody();
        if ($this->_resultFormat === self::RESULT_ARRAY) {
            $tmp = Zend_Json::decode($queryResult);
            $this->_results = $tmp['results'];
            $this->_resultCount = (int)$tmp['resultCount'];
        } else {
            // convert JSON-string to array
            $jsonString = Zend_Json::decode($queryResult);
            
            $this->_resultCount = (int)$jsonString['resultCount'];
            $this->_results = Zend_Json::encode($jsonString['results']);
        }
        
        return $this;
    }
    
    /**
     * Build the request uri for all common parameters
     * 
     * @return  void
     */
    protected function _buildRequestUri()
    {
        $requestParameters = array();
        
        // add entity
        if (!empty($this->_entity)) {
            $key = array_pop(array_keys($this->_entity));
            $requestParameters[] = 'entity=' . $this->_entity[$key];
        }
        
        // add media type
        if (!empty($this->_mediaType))
            $requestParameters[] = 'media=' . $this->_mediaType;
        
        // add attribute
        if (!empty($this->_attribute))
            $requestParameters[] = 'attribute=' . $this->_attribute;
        
        // add language
        if (!empty($this->_language))
            $requestParameters[] = 'lang=' . $this->_language;    
        
        // add limit
        if ($this->_limit > 0)
            $requestParameters[] = 'limit=' . $this->_limit;
            
        // add country
        if ($this->_country != 'us')
            $requestParameters[] = 'country=' . $this->_country;
        
        // add callback
        if (!empty($this->_callback))
            $requestParameters[] = 'callback=' . $this->_callback;
        
        // add version
        if ($this->_version <> 2)
            $requestParameters[] = 'version=' . $this->_version;
            
        // add explicity
        if ($this->_explicit != 'yes')
            $requestParameters[] = 'explicit=' . $this->_explicit;
            
        return implode('&', $requestParameters);
    }
    
    /**
     * Builds the request uri for parameters specifically used in:
     *     - Zend_Service_Itunes_Lookup
     *     - Zend_Service_Itunes_Search
     */
    protected abstract function _buildSpecificRequestUri();
    
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
     * 
     * @return  void
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
     * @param   string              $country
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function setCountry($country = '')
    {
        if (in_array($country, $this->_countryList)) {
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
     * @param   string  $_language Language to set
     * @return Zend_Service_Itunes Provides a fluent interface
     */
    public function setLanguage($language = '') 
    {
        if (in_array($language, $this->_languageList)) {
            $this->_language = $language;
        }
        
        return $this;
    }
    
    /**
     * Set the used mediatype
     * 
     * @param   string $mediatype
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function setMediaType($mediatype = '')
    {
        if (in_array($mediatype, $this->_mediaTypes)) {
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
     * @param   string $format
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function setResultFormat($format = self::RESULT_ARRAY)
    {
        if (in_array($format, $this->_resultFormats)) {
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
     * @param   integer $limit
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function setLimit($limit = 50)
    {
        $this->_limit = (int)$limit;
        
        return $this;
    }
    
    /**
     * Return the entity for the result
     * 
     * @return  string
     */
    public function getEntity()
    {
        return $this->_entity;
    }
    
    /**
     * Set the entity for the result
     * 
     * @param   array   $entity
     * @throws  Zend_Service_Itunes_Exception
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function setEntity($entity = array())
    {
        // check if only one key => value pair is given
        if (count($entity) <> 1) {
            require_once 'Zend/Service/Itunes/Exception.php';
            throw new Zend_Service_Itunes_Exception('Must be set with 
                one key/value-pair!');
        }
        
        $key = array_pop(array_keys($entity));
        
        // check if the key of the given array exists
        if (array_key_exists($key, $this->_entityList)) {
            // check if value exists for key
            if(in_array($entity[$key], $this->_entityList[$key]))
                $this->_entity = $entity;
        }
        
        return $this;
    }
    
    /**
     * Get the set attribute
     * 
     * @return  string
     */
    public function getAttribute()
    {
        return $this->_attribute;
    }
    
    /**
     * Set the attribute you want to search in the iTunes
     * store.
     * This is relative to the set media type.
     * 
     * @param   string $attribute
     * @throws  Zend_Service_Itunes_Exception
     */
    public function setAttribute($attribute = '')
    {
        require_once 'Zend/Service/Itunes/Exception.php';
        
        if (empty($this->_mediaType)) {
            throw new Zend_Service_Itunes_Exception('Attribute is relative to 
                set media type. No media type set.');
        }

        // check if the attribute is in the set of attributes for media type
        if (in_array($attribute, $this->_attributesTypes[$this->_mediaType])) {
            $this->_attribute = $attribute;
        } else {
            throw new Zend_Service_Itunes_Exception('Attribute is not in the 
                set of attributes for this media type.');
        }
    }
    
    /**
     * Get the custom set callback function
     * 
     * @return string
     */
    public function getCallback()
    {
        return $this->_callback;
    }
    
    /**
     * Set a custom callback function you want to use
     * when returning search results.
     * 
     * @param string $callback
     */
    public function setCallback($callback = '')
    {
        $this->_callback = $callback;
    }
    
    /**
     * Get complete assembled request url.
     * 
     * @return string
     */
    public function getRawRequestUrl()
    {
        if (empty($this->_rawRequestUrl))
            $this->_buildSpecificRequestUri();
            
        return $this->_rawRequestUrl;
    }
    
    /**
     * Get the flag indicating whether or not you want to include
     * explicit content in your search result.
     * 
     * @return string
     */
    public function getExplicitSetting()
    {
        return $this->_explicit;
    }
    
    /**
     * Set the flag indicating whether or not you want to include
     * explicit content in your search result
     * 
     * @param   string $setting
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function setExplicitSetting($setting = 'yes')
    {
        if (in_array($setting, $this->_explicitTypes)) {
            $this->_explicit = $setting;
        }
        
        return $this;
    }
    
    /**
     * Get the iTunes Store search result key version you want 
     * to receive back from your search.
     * 
     * @return integer
     */
    public function getVersion()
    {
        return $this->_version;
    }
    
    /**
     * Set the iTunes Store search result key version you want 
     * to receive back from your search.
     * 
     * @param   integer $version
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function setVersion($version = 2)
    {
        if (!in_array($version, array(1,2))) {
            $this->_version = $version;
        }
        
        return $this;
    }
}