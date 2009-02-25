<?php

/**
 * Manager the components and extentions loading.
 * This class still is in development into the Php Coruja Framework.
 * Changes into it must be replicated here.
 *
 * @package Components
 * @todo Get the working version of this class and update here
 */
class CorujaComponentsManager implements CorujaComponentsManagerInterface
{
    const x = 1;
    
    const XML_COMPONENTS_CONFIG = "components.xml";

    const FOLDER_CORUJA_ADMIN = "";

    /**
     * Singleton of the class
     * @var CorujaComponentsManager
     */
    protected static $objInstance;

	/**
	 * Error Component
	 *
	 * @var CorujaErrorInterface
	 */
	protected $objErrorComponent;

	/**
	 * Log Component
	 *
	 * @var CorujaLogInterface
	 */
	protected $objLogComponent;

	/**
	 * Cache Component
	 *
	 * @var CorujaCacheInterface
	 */
	protected $objCacheComponent;

	/**
	 * Xml 2 Php Component
	 *
	 * @var CorujaXml2PhpInterface
	 */
	protected $objXml2PhpComponent;

	/**
	 * Authentication Component
	 *
	 * @var CorujaAuthenticationInterface
	 */
	protected $objAuthenticationComponent;

	/**
	 * Notation Component
	 *
	 * @var CorujaNotationInterface
	 */
	protected $objNotationComponent;

	/**
	 * Exception Handler Component
	 *
	 * @var Component
	 */
	protected $objExceptionHandlerComponent;

	/**
	 * Backtrace Component
	 *
	 * @var CorujaBacktraceInterface
	 */
	protected $objBacktraceComponent;

	/**
	 * Backtrace Explaine Component
	 *
	 * @var CorujaBackTraceExplainInterface
	 */
	protected $objBacktraceExplainComponent;

	/**
	 * Session Component
	 *
	 * @var CorujaSessionInterface
	 */
	protected $objSessionComponent;

	/**
	 * Template Component
	 *
	 * @var CorujaTemplateInterface
	 */
	protected $objTemplateComponent;

	/**
	 * Database Component
	 *
	 * @var CorujaDatabaseInterface
	 */
	protected $objDatabaseComponent;

	/**
	 * Query Filter Component
	 *
	 * @var CorujaQueryFilterInterface
	 */
	protected $objQueryFilterComponent;

	/**
	 * Coruja Request Component
	 *
	 * @var CorujaRequestInterface
	 */
	protected $objRequestComponent;

    /**
     * Singleton of CorujaComponentsManager
     *
     * @return CorujaComponentsManager
     */
    public static function getInstance()
    {
        if( self::$objInstance === null )
        {
            self::$objInstance = new CorujaComponentsManager();
        }
        return self::$objInstance;
    }

    public function  __construct() {
        /**
         * @question when external use this component the coruja begins will be required ?
         * @fixme the folder coruja admin it is replicated in here and into the coruja begins
         * @todo this class should work without the coruja begins
         */
        // $strCorujaAdm = CorujaBegins::FOLDER_CORUJA_ADMIN;
        $strCorujaAdm = self::FOLDER_CORUJA_ADMIN;
        $strXml = $strCorujaAdm . self::XML_COMPONENTS_CONFIG;
        if( file_exists( $strXml ) )
        {
            $objXmlComponents = simplexml_load_file( $strXml );
        }
        else
        {
            $objXmlComponents = array();
        }
        /**
         * @question all the components into the xml components config should be allways load ?
         */
        
        foreach( $objXmlComponents as $strClassName => $objXmlComponentConfig )
        {
            $strMethodName = "set" . ucfirst( strtolower( $strTagName ) ) . "Component";
            if( !method_exists($this, $strMethodName ) )
            {
                throw new CorujaComponentManagerException( "Invalid component element " . $strMethodName , " to the component mananger " );
            }


            if( !class_exists( $strClassName ) )
            {
                throw new CorujaComponentManagerException( "Invalid component class " . $strClassName , " to the component mananger " );

            }

            $this->$strMethodName( new $strClassName() );
        }
    }

	/**
	 * Set the Error Component
	 *
	 * @param CorujaErrorInterface $objErrorComponent
	 */
	public function setErrorComponent( CorujaErrorInterface $objErrorComponent )
	{
		$this->objErrorComponent = $objErrorComponent;
	}

	/**
	 * Return a Error Component
	 *
	 * @return CorujaErrorInterface
	 */
	public function getErrorComponent()
	{
		if( $this->objErrorComponent == null )
		{
			throw new CorujaException( "No Error Component was defined. Without it you can not use Error resources." );
		}
		return $this->objErrorComponent;
	}

	/**
	 * Has a Error component
	 *
	 * @return boolean
	 */
	public function hasErrorComponent()
	{
		return ( $this->objErrorComponent !== null );
	}

	/**
	 * Set the Log Component
	 *
	 * @param CorujaLogInterface $objLogComponent
	 */
	public function setLogComponent( CorujaLogInterface $objLogComponent )
	{
		$this->objLogComponent = $objLogComponent;
	}

	/**
	 * Return a Log Component
	 *
	 * @return CorujaLogInterface
	 */
	public function getLogComponent()
	{
		if( $this->objLogComponent == null )
		{
			throw new CorujaException( "No Log Component was defined. Without it you can not use Log resources." );
		}
		return $this->objLogComponent;
	}

	/**
	 * Has Log Component Component
	 *
	 * @return boolean
	 */
	public function hasLogComponent()
	{
		return ( $this->objLogComponent !== null );
	}
	/**
	 * Set the Template Cache Component
	 *
	 * @param CorujaCacheInterface $objCacheComponent
	 */
	public function setCacheComponent( CorujaCacheInterface $objCacheComponent )
	{
		$this->objCacheComponent = $objCacheComponent;
	}

	/**
	 * Get The Template Cache Component
	 *
	 * @return CorujaCacheInterface
	 */
	public function getCacheComponent()
	{
		if( $this->objCacheComponent == null )
		{
			throw new CorujaException( "No Template Cache Component was defined. Without it you can not use Cache resources." );
		}
		return $this->objCacheComponent;
	}

	/**
	 * Has Template Cache Component
	 *
	 * @return boolean
	 */
	public function hasCacheComponent()
	{
		return ( $this->objCacheComponent !== null );
	}

	/**
	 * Set the Template Xml To Script Component
	 *
	 * @param CorujaXml2PhpInterface $objXml2PhpComponent
	 */
	public function setXml2PhpComponent( CorujaXml2PhpInterface $objXml2PhpComponent )
	{
		$this->objXml2PhpComponent = $objXml2PhpComponent;
	}

	/**
	 * Get The Template Xml To Script Component
	 *
	 * @return CorujaXml2PhpInterface
	 */
	public function getXml2PhpComponent()
	{
		if( $this->objXml2PhpComponent == null )
		{
			throw new CorujaException( "No Component Conversor of Template Xml to Script was defined. Without it you can not use Xml to Script resources." );
		}
		return $this->objXml2PhpComponent;
	}

	/**
	 * Has Template Xml To Script Component
	 *
	 * @return boolean
	 */
	public function hasXml2PhpComponent()
	{
		return ( $this->objXml2PhpComponent !== null );
	}

	/**
	 * Set The Authentication Component
	 *
	 * @param CorujaAuthenticationInterface $objAuthenticationComponent
	 */
	public function setAuthenticationComponent( CorujaAuthenticationInterface $objAuthenticationComponent )
	{
		$this->objAuthenticationComponent = $objAuthenticationComponent;
	}

	/**
	 * Get the Authentication Component
	 *
	 * @return CorujaAuthenticationInterface
	 */
	public function getAuthenticationComponent()
	{
		if( $this->objAuthenticationComponent == null )
		{
			throw new CorujaException( "No Authentication Component was defined. Without it you cannot use Authentication resources." );
		}
		return $this->objAuthenticationComponent;
	}

	/**
	 * Has Authentication Component
	 *
	 * @return boolean
	 */
	public function hasAuthenticationComponent()
	{
		return ( $this->objAuthenticationComponent !== null );
	}

	/**
	 * Set The Notation Component
	 *
	 * @param CorujaNotationInterface $objNotationComponent
	 */
	public function setNotationComponent( CorujaNotationInterface $objNotationComponent )
	{
		$this->objNotationComponent = $objNotationComponent;
	}

	/**
	 * Get the Notation Component
	 *
	 * @return CorujaNotationInterface
	 */
	public function getNotationComponent()
	{
		if( $this->objNotationComponent == null )
		{
			throw new CorujaException( "No Notation Component was defined. Without it you cannot use Notation resources." );
		}
		return $this->objNotationComponent;
	}

	/**
	 * Has Notation Component
	 *
	 * @return boolean
	 */
	public function hasNotationComponent()
	{
		return ( $this->objNotationComponent !== null );
	}

	/**
	 * Set The Exception Handler Component
	 *
	 * @param CorujaExceptionHandlerInterface $objExceptionHandlerComponent
	 */
	public function setExceptionHandlerComponent( CorujaExceptionHandlerInterface  $objExceptionHandlerComponent )
	{
		$this->objExceptionHandlerComponent = $objExceptionHandlerComponent;
		$arrExceptionCaller = array( $this->objExceptionHandlerComponent, "handle" );
		set_exception_handler( $arrExceptionCaller );
	}

	/**
	 * Get the Exception Handler Component
	 *
	 * @return CorujaExceptionHandlerInterface
	 */
	public function getExceptionHandlerComponent()
	{
		if( $this->objExceptionHandlerComponent == null )
		{
			throw new CorujaException( "No Exception Handler Component was defined. Without it you cannot use Exception Handler resources." );
		}
		return $this->objExceptionHandlerComponent;
	}

	/**
	 * Has Exception Handler Component
	 *
	 * @return boolean
	 */
	public function hasExceptionHandlerComponent()
	{
		return ( $this->objExceptionHandlerComponent !== null );
	}

	/**
	 * Set The Backtrace Component
	 *
	 * @param CorujaBackTraceInterface $objBackTraceComponent
	 */
	public function setBacktraceComponent( CorujaBackTraceInterface  $objBackTraceComponent )
	{
		$this->objBacktraceComponent = $objBackTraceComponent;
	}

	/**
	 * Get the Backtrace Component
	 *
	 * @return CorujaBackTraceInterface
	 */
	public function getBacktraceComponent()
	{
		if( $this->objBacktraceComponent == null )
		{
			throw new CorujaException( "No Backtrace Component was defined. Without it you cannot use Backtrace resources." );
		}
		return $this->objBacktraceComponent;
	}

	/**
	 * Has Backtrace Component
	 *
	 * @return boolean
	 */
	public function hasBacktraceComponent()
	{
		return ( $this->objBacktraceComponent !== null );
	}

	/**
	 * Set The Backtrace Component
	 *
	 * @param CorujaBackTraceExplainInterface $objBackTraceExplainComponent
	 */
	public function setBacktraceExplainComponent( CorujaBackTraceExplainInterface $objBackTraceExplainComponent )
	{
		$this->objBacktraceComponent = $objBackTraceComponent;
	}

	/**
	 * Get the Backtrace Explain Component
	 *
	 * @return CorujaBackTraceExplainInterface
	 */
	public function getBacktraceExplainComponent()
	{
		if( $this->objBacktraceExplainComponent == null )
		{
			throw new CorujaException( "No Backtrace Explain Component was defined. Without it you cannot use Backtrace Explain resources." );
		}
		return $this->objBacktraceExplainComponent;
	}

	/**
	 * Has Backtrace Explain Component
	 *
	 * @return boolean
	 */
	public function hasBacktraceExplainComponent()
	{
		return ( $this->objBacktraceExplainComponent !== null );
	}

		/**
	 * Alias to loadComponent
	 *
	 * @return boolean
	 * @see CorujaComponentsManager::loadComponent()
	 */
	public function import( $strComponent )
	{
//       print "import $strComponent " . "<br>\n";
		$boolReturn = CorujaComponentsManager::loadComponent( $strComponent );
		return( $boolReturn );
	}

	/**
	 * If the component it is not already include,  require it.
	 *
	 * @param string $srtComponent
	 * @return boolean
	 */
	public function loadComponent( $strComponent )
	{
		$strComponent[0] = strtolower( $strComponent[0] );
		$strComponent = basename( $strComponent );
		$strPath = PATH_CORUJA_COMPONENT . $strComponent . "/_start.php";
		If( file_exists( $strPath ) )
		{
			require_once( $strPath );
		}
		else
		{
			$strPath = PATH_CORUJA_DEFAULT_COMPONENT . $strComponent . "/_start.php";
			If( file_exists( $strPath ) )
			{
				require_once( $strPath );
			}
			else
			{
				throw new ComponentException( "Unable To find the component " . $strComponent );
			}
		}
		return( TRUE );
	}

	/**
	 * Load some extesion and
	 *
	 * @param string $srtExtension
	 * @return boolean
	 */
	public function loadExtension( $strExtension )
	{
		$strExtension = basename( $strExtension );
		$strPath = PATH_CORUJA_EXTENSION . $strExtension . "/_start.php";
		assert ( 'file_exists( $strPath )' );
		require_once( $strPath );
		return( TRUE );
	}
}
?>