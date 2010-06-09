<?php

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Itunes
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Service_Itunes_ItunesAbstract extends Zend_Service_Abstract
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
     * Properties with default values
     * @var array
     */
    protected $_options = array(
        'country'   => 'us',
        'language'  => '',
        'mediatype' => '',
        'entity'    => array(self::MEDIATYPE_ALL => 'album'),
        'attribute' => '',
        'limit'     => 0,
        'callback'  => '',
        'version'   => 2,
        'explicit'  => 'yes'
    );
    
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
     * List of available languages for the result
     * @var $_languageList array
     */
    protected $_languageList = array('en_us', 'ja_jp');
    
    const MEDIATYPE_ALL             = 'all';
    const MEDIATYPE_PODCAST         = 'podcast';
    const MEDIATYPE_MUSIC           = 'music';
    const MEDIATYPE_MUSICVIDEO      = 'musicVideo';
    const MEDIATYPE_AUDIOBOOK       = 'audiobook';
    const MEDIATYPE_SHORTFILM       = 'shortFilm';
    const MEDIATYPE_TVSHOW          = 'tvShow';
    const MEDIATYPE_MOVIE           = 'movie';
    
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
    
    /**
     * List of possible attributes
     * 
     * @var array
     */
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
     * Complete assembled request url.
     * 
     * @var $_rawRequestUrl string
     */
    protected $_rawRequestUrl = '';
    
    /**
     * Array of explicity settings
     * 
     * @var array
     */
    protected $_explicitTypes = array('yes', 'no');
    
    protected $_uri = '';
    
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
         * Set options
         */
        if (null !== $options) {
            $this->setOptions($options);
        }
    }
    
    /**
     * Set configuration
     * 
     * @param   array $options
     * @return  void
     */
    public function setOptions ($options = null)
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        }

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
     * @return  void|Zend_Service_Itunes_Search_Result
     */
    public function query()
    {
        // cannot be called when callback is set
        if ($this->_options['callback'] != '') {
            throw new Zend_Service_Itunes_Exception('Cannot run queryService when callback is set.');
        }
        
        $this->_buildSpecificRequestUri();
        
        self::getHttpClient()->setUri($this->_rawRequestUrl);
        
        $queryResult = self::getHttpClient()->request()->getBody();
        if ($this->_resultFormat === self::RESULT_ARRAY) {
            $resultSet = new Zend_Service_Itunes_ResultSet($queryResult);
        
            return $resultSet;
        } else {
            // convert JSON-string to array
            $jsonString = Zend_Json::decode($queryResult);
            
            $this->_resultCount = (int)$jsonString['resultCount'];
            $this->_results = Zend_Json::encode($jsonString['results']);
        }
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
        if (!empty($this->_options['entity'])) {
            $tmp = array_keys($this->_options['entity']);
            $key = array_pop($tmp);
            $requestParameters[] = 'entity=' . $this->_options['entity'][$key];
        }
        
        // add media type
        if (!empty($this->_options['mediaType'])) {
            $requestParameters[] = 'media=' . $this->_options['mediaType'];
        }
        
        // add attribute
        if (!empty($this->_options['attribute'])) {
            $requestParameters[] = 'attribute=' . $this->_options['attribute'];
        }
        
        // add language
        if (!empty($this->_options['language'])) {
            $requestParameters[] = 'lang=' . $this->_options['language'];
        }
        
        // add limit
        if ($this->_options['limit'] > 0) {
            $requestParameters[] = 'limit=' . $this->_options['limit'];
        }
        
        // add country
        if ($this->_options['country'] != 'us') {
            $requestParameters[] = 'country=' . $this->_options['country'];
        }
        
        // add callback
        if (!empty($this->_options['callback'])) {
            $requestParameters[] = 'callback=' . $this->_options['callback'];
        }
        
        // add version
        if ($this->_options['version'] <> 2) {
            $requestParameters[] = 'version=' . $this->_options['version'];
        }
        
        // add explicity
        if ($this->_options['explicit'] != 'yes') {
            $requestParameters[] = 'explicit=' . $this->_options['explicit'];
        }
        
        return implode('&', $requestParameters);
    }
    
    /**
     * Builds the request uri for parameters specifically used in:
     *     - Zend_Service_Itunes_Lookup
     *     - Zend_Service_Itunes_Search
     */
    protected abstract function _buildSpecificRequestUri();
    
    /**
     * Magic method for retrieving properties
     * 
     * @param   string    $key
     * @return  mixed
     */
    public function getResults()
    {
        if ($this->_resultFormat == self::RESULT_JSON) {
            return $this->_results;
        } else {
            throw new Zend_Service_Itunes_Exception("Cannot call '" . __METHOD__ . "' when using JSON");
        }
    }
    
    /**
     * Get the result count from query()
     * 
     * @return  void
     */
    public function getResultCount()
    {
        if ($this->_resultFormat == self::RESULT_JSON) {
            return $this->_resultCount;
        } else {
            throw new Zend_Service_Itunes_Exception("Cannot call '" . __METHOD__ . "' when using JSON");
        }
    }
    
    /**
     * Magic method for accessing properties
     * 
     * @param   string    $key
     * @return  mixed
     */
    public function __get($key)
    {
        if (isset($this->_options[$key])) {
            return $this->_options[$key];
        }
        
        return null;
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
            $this->_options['country'] = $country;
        }
        
        return $this;
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
            $this->_options['language'] = $language;
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
            $this->_options['mediatype'] = $mediatype;
        }
        
        return $this;
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
     * Set the limit
     * 
     * @param   integer $limit
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function setLimit($limit = 50)
    {
        $this->_options['limit'] = (int)$limit;
        
        return $this;
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
        // check if only one entry is given
        if (count($entity) <> 1) {
            throw new Zend_Service_Itunes_Exception('Must be set with 
                one key/value-pair!');
        }

        // fetch key from parameter
        $_tmp = array_keys($entity);
        $key = array_pop($_tmp);

        // check if the key of the given array exists
        if (array_key_exists($key, $this->_entityList)) {
            // check if value exists for key
            if(in_array($entity[$key], $this->_entityList[$key]))
                $this->_options['entity'] = $entity;
        }

        return $this;
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
        if (empty($this->_options['mediaType'])) {
            throw new Zend_Service_Itunes_Exception('Attribute is relative to set media type. No media type set.');
        }

        // check if the attribute is in the set of attributes for media type
        if (in_array($attribute, $this->_attributesTypes[$this->_mediaType])) {
            $this->_options['attribute'] = $attribute;
        } else {
            throw new Zend_Service_Itunes_Exception('Attribute is not in the set of attributes for this media type.');
        }
    }
    
    /**
     * Set a custom callback function you want to use
     * when returning search results.
     * This setting works only when result format is set to
     * RESULT_JSON
     * 
     * @param   string $callback
     * @throws  Zend_Service_Itunes_Exception
     */
    public function setCallback($callback = '')
    {
        if ($this->getResultFormat() !== self::RESULT_JSON) {
            throw new Zend_Service_Itunes_Exception('Callback can only be set with RESULT_JSON');
        }
        
        $this->_options['callback'] = $callback;
    }
    
    /**
     * Set the flag indicating whether or not you want to include
     * explicit content in your search result
     * 
     * @param   string $setting
     * @return  Zend_Service_Itunes Provides a fluent interface
     */
    public function setExplicit($setting = 'yes')
    {
        if (in_array($setting, $this->_explicitTypes)) {
            $this->_options['explicit'] = $setting;
        }
        
        return $this;
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
        if (in_array($version, array(1, 2))) {
            $this->_options['version'] = $version;
        }
        
        return $this;
    }
    
    /**
     * Get the Uri set to query the service
     * 
     * @return string
     */
    public function getUri()
    {
        return $this->_uri;
    }
}