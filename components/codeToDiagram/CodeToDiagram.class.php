<?php
/**
 * CodeToDiagram - make the execution create a sequence diagram
 * @package CodeToDiagram
 */

/**
 * Code to diagram master class.
 * Take to itself the service of include and require. Make code instrumentation
 * of all the classes includes making this way possible to wacth some code execution.
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class CodeToDiagram
{
	/**
	 * Array of files already load
	 *
	 * @var string[]
	 */
	protected $arrFiles = array();

	/**
	 * Flag of control if is the first load
	 *
	 * @var boolean
	 */
	protected $booStart = false;

	/**
	 * File from the execution start
	 * 
	 * @var string
	 */
	protected $strFileFrom = null;

	/**
	 * File of actual load
	 *
	 * @var string
	 */
	protected $strFileName = "diagram.html";

	/**
	 * Diagram output type
	 *
	 * @default CodeToDiagram::::OUTPUT_TYPE_SCREEN
	 * @var string
	 */
	protected $strOutputType = self::OUTPUT_TYPE_SCREEN;

	/**
	 * Diagram printer type
	 *
	 * @default CodeToDiagram::::PRINTER_TYPE_HTML
	 * @var string
	 */
	protected $strPrinterType = self::PRINTER_TYPE_HTML;

	/**
	 * Caller Path of the execution
	 * 
	 * @var string
	 */
	protected $strCallerPath;

	/**
	 * Public Path of the project
	 * 
	 * @var string
	 */
	protected $strPublicPath;
	
	/**
	 * Controls if the access it is been maded by a external link call
	 * 
	 * @var boolean
	 * @default false
	 */
	protected $booExternalAccess = false;
	/**
	 * Singleton of this class
	 *
	 * @var CodeToDiagram
	 */
	protected static $objInstance;

	/**
	 * Should the code instrumentation run in files
	 * If not will run into a eval function
	 *
	 * @var boolean
	 */
	const RUN_IN_FILES = false;

	/**
	 * If the execution happen into files the
	 * new file will be destroy just after be
	 * executed. This will prevent the existence
	 * of garbage files.
	 *
	 * @var boolean
	 */
	const REMOVE_FILES = true;

	/**
	 * Prefix of the code instrumentation classes
	 * of the code to diagram
	 */
	const CODE_TO_DIAGRAM_CLASS_PREFIX = "CTD";

	/**
	 * The CodeToDiagram don't print anything into screen
	 * and returns the string generetad by the printer
	 *
	 * Ouputput type string
	 */
	const OUTPUT_TYPE_STRING = "string";

	/**
	 * The CodeToDiagram don't print anything into screen
	 * and save into a file the string generetad by the
	 * printer
	 *
	 * Ouputput type file
	 */
	const OUTPUT_TYPE_FILE = "file";

	/**
	 * The CodeToDiagram print into screen the string
	 * generetad by the printer, returning it too
	 */
	const OUTPUT_TYPE_SCREEN = "screen";

	/**
	 * Printer type xml.
	 *
	 * Convert the UmlSequenceDiagram into a xml file
	 *
	 */
	const PRINTER_TYPE_XML = "xml";

	/**
	 * Printer type html.
	 *
	 * Convert the UmlSequenceDiagram into a html file
	 *
	 */
	const PRINTER_TYPE_HTML = "html";

    const MSG_NO_WRITE_PERMISSION = " The user of the system does not have permission to write the code to diagram files. Change the RUN_IN_FILES to false and save your files into a allowed folder.";

    /**
     * array with the name of the default stereotypes
     *
     * @var string[]
     */
    protected static $arrDefaultStereotypes = array( 'user' , 'system' , 'user' , 'entity' , 'controller' , 'boundary' , 'database');

    public function __construct()
    {
        $this->loadDefaultsStereotypes();
    }

    /**
     * Load the default stereotype list
     */
    protected function loadDefaultsStereotypes()
    {
        foreach( self::$arrDefaultStereotypes as $strDefaultStereotype )
        {
            $objStereotype = new UmlSequenceDiagramStereotype();
            $objStereotype->setName( $strDefaultStereotype  )->setDefault( true );
            UmlSequenceDiagramStereotype::addStereotype( $objStereotype );
        }

    }

	/**
	 * Get if the configuration of the factory
	 *
	 * @see CodeInstrumentationReceiver::getConfiguration()
	 * @return CodeInstrumentationReceiverConfiguration
	 */
	public function getConfiguration()
	{
		return CodeInstrumentationReceiver::getInstance()->getConfiguration();
	}

	 /**
	 * Set the output type of the diagram.;
	 *
	 * The output type it is how the class should deal with the result of the printer
	 *
	 * @example
	 * <code>
	 *	  $this->setOutputType( CodeToDiagram::OUTPUT_TYPE_SCREEN )->getOutputType() == CodeToDiagram::OUTPUT_TYPE_SCREEN
	 * </code>
	 * @example
	 * <code>
	 *	  $this->setOutputType( CodeToDiagram::OUTPUT_TYPE_FILE )->getOutputType() == CodeToDiagram::OUTPUT_TYPE_FILE
	 * </code>
	 * @example
	 * <code>
	 *	  $this->setOutputType( CodeToDiagram::OUTPUT_TYPE_STRING )->getOutputType() == CodeToDiagram::OUTPUT_TYPE_STRING
	 * </code>
	 * @example
	 * <code>
	 *	  $this->setOutputType( "something" ) throws CodeToDiagramException
	 * </code>
	 * @assert( CodeToDiagram::OUTPUT_TYPE_SCREEN  )
	 * @assert( CodeToDiagram::OUTPUT_TYPE_FILE )
	 * @assert( CodeToDiagram::OUTPUT_TYPE_STRING )
	 * @assert( "somethingElse" ) throws CodeToDiagramException
	 * @param string $strType
	 */
	public function setOutputType( $strType )
	{
		switch( $strType )
		{
			case CodeToDiagram::OUTPUT_TYPE_SCREEN:
			case CodeToDiagram::OUTPUT_TYPE_STRING:
			case CodeToDiagram::OUTPUT_TYPE_FILE :
			{
				$this->strOutputType = $strType;
				break;
			}
			default:
			{
				throw new CodeToDiagramException( "Invalid output type. ('" . $strType . "')" );
				break;
			}
		}
		return $this;
	}

	/**
	 * Get the output type of the diagram
	 *
	 * @example
	 * <code>
	 *	  $this->setOutputType( CodeToDiagram::OUTPUT_TYPE_SCREEN )->getOutputType() == CodeToDiagram::OUTPUT_TYPE_SCREEN
	 * </code>
	 * @example
	 * <code>
	 *	  $this->setOutputType( CodeToDiagram::OUTPUT_TYPE_FILE )->getOutputType() == CodeToDiagram::OUTPUT_TYPE_FILE
	 * </code>
	 * @example
	 * <code>
	 *	  $this->setOutputType( CodeToDiagram::OUTPUT_TYPE_STRING )->getOutputType() == CodeToDiagram::OUTPUT_TYPE_STRING
	 * </code>
	 * @example
	 * <code>
	 *	  $this->setOutputType( "something" ) throws CodeToDiagramException
	 * </code>
	 *
	 * @return string
	 */
	public function getOutputType()
	{
		return $this->strOutputType;
	}

	/**
	 * Set the printer type of the diagram.
	 *
	 * Set the printer what will deal with the UmlSequenceDiagram Object
	 *
	 * @example{
	 * <code>
	 *	  $this->setPrinterType( CodeToDiagram::PRINTER_TYPE_XML )->getPrinterType() == CodeToDiagram::PRINTER_TYPE_XML
	 * </code>}
	 * @example{
	 * <code>
	 *	  $this->setPrinterType( CodeToDiagram::PRINTER_TYPE_HTML )->getPrinterType() == CodeToDiagram::PRINTER_TYPE_HTML
	 * </code>}
	 * @example{
	 * <code>
	 *	  $this->setPrinterType( "something" ) throws CodeToDiagramException
	 * </code>}
	 *
	 * @assert( CodeToDiagram::PRINTER_TYPE_HTML )
	 * @assert( CodeToDiagram::PRINTER_TYPE_XML )
	 * @assert( "somethingElse" ) throws CodeToDiagramException
	 * @param string $strType
	 */
	public function setPrinterType( $strType )
	{
		switch( $strType )
		{
			case CodeToDiagram::PRINTER_TYPE_HTML:
			case CodeToDiagram::PRINTER_TYPE_XML:
			{
				$this->strPrinterType = $strType;
				break;
			}
			default:
			{
				throw new CodeToDiagramException( "Invalid printer type. ('" . $strType . "')" );
				break;
			}
		}
		return $this;
	}

	/**
	 * Get the printer type of the diagram
	 *
	 * @example{
	 * <code>
	 *	  $this->setPrinterType( CodeToDiagram::PRINTER_TYPE_XML )->getPrinterType() == CodeToDiagram::PRINTER_TYPE_XML
	 * </code>}
	 * @example{
	 * <code>
	 *	  $this->setPrinterType( CodeToDiagram::PRINTER_TYPE_HTML )->getPrinterType() == CodeToDiagram::PRINTER_TYPE_HTML
	 * </code>}
	 * @example{
	 * <code>
	 *	  $this->setPrinterType( "something" ) throws CodeToDiagramException
	 * </code>}
	 *
	 * @return string
	 */
	public function getPrinterType()
	{
		return $this->strPrinterType;
	}

	/**
	 * Set if the acess it is as a external call
	 *
	 * @see CodeToDiagram::getExternalAcess()
	 * @see CodeToDiagram->boolExternalAccess
	 * @param boolean $booExternalAccess
	 * @return CodeToDiagram me
	 */
	public function setExternalAcess( $booExternalAccess )
	{
		$this->booExternalAccess = (boolean)$booExternalAccess;
		return $this;
	}

	/**
	 * Get if the acess it is as a external call
	 *
	 * @see CodeToDiagram::setExternalAcess( boolean )
	 * @see CodeToDiagram->boolExternalAccess
	 * @return boolean
	 */
	public function getExternalAcess()
	{
		return $this->booExternalAccess;
	}

	/**
	 * Returns if the element has a instance
	 *
	 * @example
	 * <code>
	 *	  self::hasInstance() == false;
	 * </code>
	 * @example
	 * <code>
	 *	  self::getInstance();
	 *	  self::hasInstance() == true
	 * </code>
	 *
	 * @return boolean
	 */
	public static function hasInstance()
	{
		return ( self::$objInstance !== null );
	}

	/**
	 * Get a singleton instance of the class
	 *
	 * @example
	 * <code>
	 *	  get_class( self::getInstance() ) == "CodeToDiagram"
	 * </code>
	 * 
	 * @return CodeToDiagram
	 */
	public static function getInstance()
	{
		if( self::$objInstance === null )
		{
			self::$objInstance = new CodeToDiagram();
		}
		return self::$objInstance;
	}

	/**
	 * Set if the diagram creation has started
	 *
	 * @example
	 * <code>
	 *	  $this->setStarted( true )->getStarted() == true
	 * </code>
	 * @example
	 * <code>
	 *	  $this->setStarted( false )->getStarted() == false
	 * </code>
	 * @assert( true )
	 * @assert( false )
	 * @param bool $booStarted
	 * @return CodeToDiagram
	 */
	public function setStarted( $booStarted )
	{
		$this->booStart = $booStarted;
		return $this;
	}

	/**
	 * Get if the diagram creation has started
	 * @example
	 * <code>
	 *	  $this->setStarted( true )->getStarted() == true
	 * </code>
	 * @example
	 * <code>
	 *	  $this->setStarted( false )->getStarted() == false
	 * </code>
	 * @assert() == false
	 * @return boolean
	 */
	public function getStarted()
	{
		return $this->booStart;
	}

	/**
	 * Set the file what the execution start from.
	 * This should be edit with very care
	 *
	 * @example
	 * <code>
	 *	  $this->setFileFrom( __FILE__ )->getFileFrom() == __FILE__
	 * </code>
	 * @assert( __FILE__ );
	 * @param string $strFileFrom
	 * @return CodeToDiagram
	 */
	public function setFileFrom( $strFileFrom )
	{
		$this->strFileFrom = $strFileFrom;
		return $this;
	}

	/**
	 * Get the file what the execution start from.
	 *
	 * @example
	 * <code>
	 *	  $this->setFileFrom( __FILE__ )->getFileFrom() == __FILE__
	 * </code>
	 *
	 * @return string
	 */
	public function getFileFrom()
	{
		return $this->strFileFrom;
	}

	/**
	 * Set the actual file in code instrumentation
	 *
	 * @example
	 * <code>
	 *  $this->setFileName( "index.php" )->getFileName() == "index.php"
	 * </code>
	 * @param string $strFileName
	 * @return CodeToDiagram
	 */
	public function setFileName( $strFileName )
	{
		$this->strFileName = $strFileName;
		return $this;
	}

	/**
	 * Get the file name of the actual file in code instrumentation
	 *
	 * @example
	 * <code>
	 *  $this->setFileName( "index.php" )->getFileName() == "index.php"
	 * </code>
	 * @return string
	 */
	public function getFileName()
	{
		return $this->strFileName;
	}
	
	/**
	 * Set the caller path
	 * 
	 * @param string $strCallerPath
	 * @return CodeToDiagram me
	 */
	public function setCallerPath( $strCallerPath )
	{
		$this->strCallerPath = $strCallerPath;
		return $this;
	}
	
	/**
	 * Get the caller path
	 * 
	 * @return string
	 */
	public function getCallerPath()
	{
		return $this->strCallerPath;
	}
	
	/**
	 * Set the public path
	 * 
	 * @param string $strPublicPath
	 * @return CodeToDiagram me
	 */
	public function setPublicPath( $strPublicPath )
	{
	 	$this->strPublicPath = $strPublicPath;
		return $this;
	}
	
	/**
	 * Get the public path
	 * 
	 * @return string
	 */
	public function getPublicPath()
	{
		return $this->strPublicPath;	
	}
	
	/**
	* Start the log of the execution and restart if already have
	*
	* @assert()
	*
	* @return CodeToDiagram
	*/
	public function start()
	{
        ob_start();
		if( $this->getStarted() )
		{
			return $this;
		}
		else
		{
			CodeInstrumentationReceiver::getInstance()->restart();
			$this->CodeToDiagramRequireOnce($this->getFileFrom() , $this->getFileFrom() );
			exit();

			// just to safety //
			return $this;
		}
	}

	/**
	 * Restart the informations inside the code instrumentation receiver
	 *
	 * @assert()
	 * 
	 * @return CodeToDiagram
	 */
	public function restart()
	{
		CodeInstrumentationReceiver::getInstance()->restart();
		return $this;
	}

    /**
     * Check if the user has permission to write into the file folder.
     *
     * @throws CodeToDiagramException
     * @param string $strFileName
     * @return boolean
     */
    private function checkPermissionToWrite( $strFileName )
    {
        $strPath = CorujaFileManipulation::getPathOfFile( $strFileName );

        if( $strPath == "" )
        {
            $strPath = $this->getPublicPath();
        }

        if( file_exists( $strFileName ) )
        {
            if( !is_writable( $strFileName ) )
            {
                throw new CodeToDiagramException( 1 .  self::MSG_NO_WRITE_PERMISSION );
            }
            return TRUE;
        }

        if( is_dir( $strPath ) )
        {
            if( !is_writable( $strFileName ) )
            {
                throw new CodeToDiagramException(2 . self::MSG_NO_WRITE_PERMISSION );
            }
        }

        if( !mkdir( $strPath , 0777, TRUE ) )
        {
                throw new CodeToDiagramException(3 . self::MSG_NO_WRITE_PERMISSION );
        }
        return TRUE;
    }

	/**
	 * Save the actual information from the code instrumentation into the 
	 * selected output.
	 *
	 * @example
	 * <code>
	 *  CodeToDiagram::getInstance()->restart();
	 *  // output will be a file //
	 *  CodeToDiagram::getInstance()->setOutputType( 'file' );
	 *  // name of the new file //
	 *  CodeToDiagram::getInstance()->setFileName( 'myFile.html' );
	 *  # this code will be saved {
	 *  $objWolf = new Wolf();
	 *  $objWolf->say( "i will be back " . date( "h:i:s") );
	 *  CodeToDiagram::getInstance()->save();
	 *  # } into the new file
	 * </code>
	 *
	 * @return string
	 */
	public function save()
	{
		$strReturn = "";
		$strDiagram = "";
		
		if( $this->getStarted() )
		{
            $strContent = ob_get_contents();
            ob_end_clean();
			$objUmlSequenceDiagram = CodeInstrumentationReceiver::getInstance()->getUmlSequenceDiagram();
            $objUmlSequenceDiagram->setOutput( $strContent );

			switch( $this->getPrinterType() )
			{
				case self::PRINTER_TYPE_HTML:
				{
					$objPrinter = UmlSequenceDiagramPrinterToHtml::getInstance();
					UmlSequenceDiagramPrinterToHtml::getInstance()->setPublicPath( $this->getPublicPath() );
					UmlSequenceDiagramPrinterToHtml::getInstance()->setCallerPath( $this->getCallerPath() );
					UmlSequenceDiagramPrinterToHtml::getInstance()->setExternalAcess( $this->getExternalAcess() );
					$strDiagram = UmlSequenceDiagramPrinterToHtml::getInstance()->perform( $objUmlSequenceDiagram );
					break;
				}
				case self::PRINTER_TYPE_XML:
				{
					$objPrinter = UmlSequenceDiagramPrinterToXml::getInstance();
					$strDiagram = UmlSequenceDiagramPrinterToXml::getInstance()->perform( $objUmlSequenceDiagram );
					break;
				}
				default:
				{
					throw new CodeToDiagramException( "Invalid printer type ({$this->getPrinterType()})" );
					break;
				}
			}
 			switch( $this->getOutputType() )
			{
				case self::OUTPUT_TYPE_SCREEN:
				{
					$objPrinter->getHeader();
                    ob_flush();
                    flush();
					print $strDiagram;
					break;
				}
				case self::OUTPUT_TYPE_STRING:
				{
					$strReturn = $strDiagram;
					break;
				}
				case self::OUTPUT_TYPE_FILE:
				{
                    $this->checkPermissionToWrite( $this->getFileName() );
					file_put_contents( $this->getFileName() , $strDiagram );
					$strReturn = $strDiagram;
					break;
				}
				default:
				{
					throw new CodeToDiagramException( "Invalid output type ({$this->getOutputType()})" );
					break;
				}
			}
			CodeInstrumentationReceiver::getInstance()->restart();
		}
		return $strReturn;
	}

	/**
	 * On destruct it will save the actual diagram any way
	 */
	public function  __destruct() {

		$this->save();
	}

	/**
	 * Init the code to diagram
	 *
	 * @param string $strFile
	 * @return CodeToDiagram
	 */
	public static function init( $strFile )
	{
		if( self::getInstance()->getStarted() == false )
		{
			self::getInstance()->setFileFrom( $strFile );
		}
		return self::getInstance();
	}

	/**
	 * Make the link reference possible
	 *
	 *
	 * @param string $strFileFrom
	 * @param string $strFile
	 * @return string
	 */
	protected function fixFileName( $strFileFrom, $strFile )
	{
		$strFileFrom = str_replace( '/', '\\', $strFileFrom );
		$strFile = str_replace( '/', '\\', $strFile );
		$strFilePath = substr( $strFileFrom ,  0 , -(strlen(basename($strFileFrom ) ) ) );
		$strFile = $strFilePath . $strFile;

		return $strFile;
	}

	/**
	 * Add a file into the code instrumentation process
	 *
	 * @param string $strFileFrom
	 * @param string $strFile
	 * @return CodeToDiagram
	 */
	public function addFile( $strFileFrom, $strFile )
	{
		$strFile = $this->fixFileName( $strFileFrom, $strFile );

		$this->arrFiles[] = $strFile;

		return $this;
	}

	/**
	 * Check if the file already was loaded
	 *
	 * @param string $strFileFrom
	 * @param string $strFile
	 * @return boolean
	 */
	protected function hasFile( $strFileFrom , $strFile )
	{
		return in_array( $strFile ,  $this->arrFiles );
	}

	/**
	 * Method what will be called in replace of the original
	 * require_once function
	 *
	 * @param string $strFileFrom
	 * @param string $strFile
	 * @return CodeToDiagram
	 */
	public function CodeToDiagramRequireOnce( $strFileFrom, $strFile )
	{		
		$arrCodeToDiagramBackTrace = debug_backtrace();

		if( !$this->hasFile( $strFileFrom , $strFile ) )
		{
			$this->CodeToDiagramRequire( $strFileFrom, $strFile );
		}
		return $this;
	}

	/**
	 * Method what will be called in replace of the original
	 * include_once function
	 *
	 * @param string $strFileFrom
	 * @param string $strFile
	 * @return CodeToDiagram
	 */
	public function CodeToDiagramIncludeOnce( $strFileFrom, $strFile )
	{
		if( !$this->hasFile( $strFileFrom , $strFile ) )
		{
			$this->CodeToDiagramIncludeOnce( $strFileFrom , $strFile );
		}
		return $this;
	}

	/**
	 * Method what will be called in replace of the original
	 * require function
	 *
	 * @param string $strFileFrom
	 * @param string $strFile
	 * @return CodeToDiagram
	 */
	public function CodeToDiagramRequire( $strFileFrom, $strFile )
	{
		$this->loadFile( $strFileFrom , $strFile );
		return $this;
	}

	/**
	 * Method what will be called in replace of the original
	 * include function
	 *
	 * @param string $strFileFrom
	 * @param string $strFile
	 * @return CodeToDiagram
	 */
	public function CodeToDiagramInclude( $strFileFrom, $strFile )
	{
		$this->loadFile( $strFileFrom , $strFile );
		return $this;
	}

	/**
	 * Method what will be called in replace of the original
	 * exit function
	 *
	 * @param string $strFileFrom
	 * @param string $strMessage
	 * @return CodeToDiagram
	 */
	public function CodeToDiagramExit( $strFileFrom = '', $strMessage = '')
	{
		print "Exit called into $strFileFrom ($strMessage ) ";
	}

	/**
	 * Replace the php function with the CodeToDiagram function
	 *
	 * @param string $strContentFile
	 * @param string $strFile
	 * @param string $strFullFile
	 * @return string
	 */
	protected function convertFileContent( $strContentFile , $strFile , $strFullFile )
	{
		if( self::getInstance()->getStarted() == false )
		{
			self::getInstance()->setStarted( true );
			$strContentFile = preg_replace('/require_once/', '//require_once', $strContentFile, 1);
		}

		$strContentFile = str_replace(
			Array(
				'require_once(' ,
				'require(' ,
				'include(' ,
				'include_once(',
				'exit()',
				'exit(',
				'__FILE__',
			),
			Array(
				'CodeToDiagram::getInstance()->CodeToDiagramRequireOnce("'. $strFile . '",' ,
				'CodeToDiagram::getInstance()->CodeToDiagramRequire("'. $strFile . '",' ,
				'CodeToDiagram::getInstance()->CodeToDiagramInclude("'. $strFile . '",' ,
				'CodeToDiagram::getInstance()->CodeToDiagramIncludeOnce("'. $strFile . '",',
				'CodeToDiagram::getInstance()->CodeToDiagramExit("'. $strFile . '")',
				'CodeToDiagram::getInstance()->CodeToDiagramExit("'. $strFile . '",',
				'"' . $this->getCallerPath() . $strFullFile . '"',
			),
			$strContentFile
		);

		return $strContentFile;
	}

	/**
	 * Implement the code instrumentation into a code line
	 *
	 * @param string $strLine
	 * @param string $strTextSearch
	 * @return array
	 */
	public function codeInstrumentationLine( $strLine, $strTextSearch )
	{
		$arrResult = array();

		if(  substr( strtolower( trim( $strLine ) ) , 0 , strlen( $strTextSearch ) ) == $strTextSearch )
		{
			$strLine = trim( $strLine );
			$strBefore = substr( $strLine , 0 , strlen( $strTextSearch ) );
			$strAfter = substr( $strLine , strlen( $strTextSearch ) );
			$arrWords = explode( " " , $strAfter );

			$strOldClassName = $arrWords[0];
			$strNewClassName = self::CODE_TO_DIAGRAM_CLASS_PREFIX . $strOldClassName;

			$arrWords[0] = $strNewClassName;
			$strAfter = implode( " " , $arrWords );
			$strLine = $strBefore . $strAfter;

			$arrResult[ "line" ] = $strLine;
			$arrResult[ "class_old" ] = $strOldClassName;
			$arrResult[ "class_new" ] = $strNewClassName;

		}
		return $arrResult;
	}

	/**
	 * Implements a code instrumentation into a class
	 *
	 * @param string $strTextSearch
	 * @param array $arrOldClasses
	 * @param array $arrNewClasses
	 * @param array $arrLines
	 */
	protected function codeInstrumentationClass( $strTextSearch, array &$arrOldClasses , array &$arrNewClasses , array &$arrLines )
	{
		foreach( $arrLines as $intLine => $strLine )
		{
			$arrResult = $this->codeInstrumentationLine( $strLine , $strTextSearch  );

			if( sizeof( $arrResult ) !== 0 )
			{
				$arrOldClasses[] = $arrResult[ "class_old" ];
				$arrNewClasses[] = $arrResult[ "class_new" ];
				$arrLines[ $intLine ] = $arrResult[ "line" ];
			}
		}
	}

	/**
	 * Pre load the file into is's context 
	 * 
	 * @param string $strFileName
	 * @param string $strContentFile
	 * @return CodeToDiagram
	 */
	protected function preloadFile( $strFileName , $strContentFile )
	{
		if( self::RUN_IN_FILES )
		{
			$strFileName = $strFileName . "(0).phps";
            print $strFileName;
            $this->checkPermissionToWrite( $strFileName );
			file_put_contents( $strFileName , $strContentFile );
			require_once( $strFileName );
			if( self::REMOVE_FILES )
			{
				unlink( $strFileName );
			}
		}
		else
		{
			eval( '?' . '>' . $strContentFile );
		}
		return $this;
	}
	
	/**
	 * Implement a code instrumentation into a file
	 *
	 * @param string $strFile
	 * @param string $strContentFile
	 */
	protected function codeInstrumentationFile( $strFileName , $strContentFile )
	{
		$arrLines = explode( "\n"  , $strContentFile );
		$arrOldClasses	= array();
		$arrNewClasses	= array();
		$arrOldInterface = array();
		$arrNewInterface = array();

		$this->codeInstrumentationClass( "class " , $arrOldClasses , $arrNewClasses, $arrLines );
		$this->codeInstrumentationClass( "interface " , $arrOldInterface , $arrNewInterface, $arrLines );

		$strContentFile = implode( "\n" , $arrLines );

		$this->preloadFile( $strFileName , $strContentFile );

		foreach( $arrNewClasses as $intKey => $strNewClassName )
		{
			$oReflectionCode = new CodeInstrumentationClass( $strNewClassName , $strContentFile );
			$oReflectionCode->setClassName( $arrOldClasses[ $intKey ] );
			$strNewCode = $oReflectionCode->getCode();
			if( self::RUN_IN_FILES )
			{
				$strFileName = trim( $strNewClassName ) . "(1).phps";
                $this->checkPermissionToWrite( $strFileName );
                file_put_contents( $strFileName , '<?' . 'php ' .  $strNewCode );
				require_once( $strFileName );
				if( self::REMOVE_FILES )
				{
					unlink( $strFileName );
				}
			}
			else
			{
				eval( $strNewCode );
			}
		}
		foreach( $arrNewInterface as $intKey => $strNewInterfaceName )
		{
			$strOldInterface = $arrOldInterface[ $intKey ];
			/** @fixme the real codeinstrumentation of interfaces fails by mysterious reasons */
			$strNewCode = "interface $strOldInterface {} ";
			if( self::RUN_IN_FILES )
			{
				$strFileName = trim( $strNewInterfaceName ) . "(1).phps";
                $this->checkPermissionToWrite( $strFileName );
				file_put_contents( $strFileName , '<?' . 'php ' .  $strNewCode );
				require_once( $strFileName );
				if( self::REMOVE_FILES )
				{
					unlink( $strFileName );
				}
			}
			else
			{
				eval( $strNewCode );
			}
		}
	}

	/**
	 *  Load some file implement the code instrumentation
	 *
	 * @param string $strFileFrom
	 * @param string $strFile
	 * @return CodeToDiagram
	 */
	protected function loadFile( $strFileFrom, $strFile )
	{
		if( basename( $strFile ) == 'CodeToDiagram.class.php' )
		{
			return $this;
		}
		$this->addFile( $strFileFrom, $strFile );

		if( CorujaFileManipulation::isRelativePath( $strFile ) )
		{
			$strFullFile = $this->fixFileName( $strFileFrom, $strFile );
		}
		else
		{
			$strFullFile = $strFile;
		}

		if( ! file_exists( $strFullFile ) )
		{
			throw new CodeToDiagramException( "Unable to find file: " . $strFullFile );
		}

		$strContentFile = file_get_contents( $strFullFile );
		$strContentFile = $this->convertFileContent( $strContentFile , $strFile , $strFullFile );
		$this->codeInstrumentationFile( $strFile, $strContentFile );
		
		return $this;
	}

	/**
	 * Set the caller path receiving the caller file
	 *
	 * @param string $strCallerFile
	 */
	public function setCallerPathByFile( $strCallerFile )
	{
		$this->setCallerPath( CorujaFileManipulation::getPathOfFile( $strCallerFile ) );
	}

    public function __call( $strMethod , $arrArguments )
    {
        throw new CodeToDiagramException( "unknow method " . $strMethod . " in " . get_class( $this ) );
    }
}

?>