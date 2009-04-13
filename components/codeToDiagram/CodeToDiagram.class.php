<?php
class CodeToDiagram
{
    /**
     * Array of files already load
     *
     * @var <arrayList>string
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
    protected $strFileName = null;

    /**
     * Type of output of graph
     * 
     * @var string
     */
    protected $strOutputType = "screen";

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
    const RUN_IN_FILES = true;

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
     * Set the output type of the diagram
     *
     * @example
     * <code>
     *      $this->setOutputType( "screen" )->getOutputType() == "screen"
     * </code>
     * @example
     * <code>
     *      $this->setOutputType( "file" )->getOutputType() == "file"
     * </code>
     * @example
     * <code>
     *      $this->setOutputType( "somethingElse" )->getOutputType() throws CodeToDiagramException
     * </code>
     * @assert( "screen" )
     * @assert( "file" )
     * @assert( "somethingElse" ) throws CodeToDiagramException
     * @param string $strType
     */
    public function setOutputType( $strType )
    {
        switch( $strType )
        {
            case "screen":
            {
                $this->strOutputType = $strType;
                break;
            }
            case "file":
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
     *      $this->setOutputType( "screen" )->getOutputType() == "screen"
     * </code>
     * @example
     * <code>
     *      $this->setOutputType( "file" )->getOutputType() == "file"
     * </code>
     * 
     * @return string
     */
    public function getOutputType()
    {
        return $this->strOutputType;
    }

    /**
     * Returns if the element has a instance
     *
     * @example
     * <code>
     *      self::hasInstance() == false;
     * </code>
     * @example
     * <code>
     *      self::getInstance();
     *      self::hasInstance() == true
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
     *      get_class( self::getInstance() ) == "CodeToDiagram"
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
     *      $this->setStarted( true )->getStarted() == true
     * </code>
     * @example
     * <code>
     *      $this->setStarted( false )->getStarted() == false
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
     *      $this->setStarted( true )->getStarted() == true
     * </code>
     * @example
     * <code>
     *      $this->setStarted( false )->getStarted() == false
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
     *      $this->setFileFrom( __FILE__ )->getFileFrom() == __FILE__
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
     *      $this->setFileFrom( __FILE__ )->getFileFrom() == __FILE__
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
     * Check if a address is relative
     *
     * @assert( "c:\www\temp.php" ) == false
     * @assert( "d:/www/temp.php" ) == false
     * @assert( "temp.php" ) == true
     * @assert( "./temp.php" ) == true
     * @assert( "/www/something.php" ) == false
     * @assert( "./www/something.php" ) == true
     * @assert( ".\www\something.php" ) == true
     * @assert( "..\www\something.php" ) == true
     * @assert( "..\www\something.php" ) == true
     *
     */
    public function isRelativePath( $strFile )
    {
        $strFile = str_replace( "\\", "/", $strFile);
        if(
            ( strpos( $strFile, "./") === 0 )
            or
            ( strpos( $strFile, "../") === 0 )
         )
        {
            return true;
        }
        elseif( strpos( $strFile, "/") === false )
        {
            return true;
        }
        else
        {
            return false;
        }
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
        if( $this->getStarted() )
        {
            return $this;
        }
        CodeInstrumentationReceiver::getInstance()->restart();
        $this->CodeToDiagramRequireOnce($this->getFileFrom() , $this->getFileFrom() );
        exit();

        // just to safety //
        return $this;
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
     *
     * @return CodeToDiagram
     */
    public function save()
    {
        if( $this->getStarted() )
        {
            $strDiagram = CodeInstrumentationReceiver::getInstance()->getXmlSequence()->show();

            if( $this->getOutputType() == "screen")
            {
                print $strDiagram;
            }
            else
            {
                file_put_contents( $this->getFileName() , $strDiagram );
            }
            CodeInstrumentationReceiver::getInstance()->restart();
        }
        return $this;
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
    protected function addFile( $strFileFrom, $strFile )
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
    public function CodeToDiagramExit( $strFileFrom, $strMessage = '')
    {
        print "Exit called into $strFileFrom ($strMessage ) ";
        exit();
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
                '"' . CALLER_PATH . $strFullFile . '"',
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

    protected function preloadFile( $strFileName , $strContentFile )
    {
        if( self::RUN_IN_FILES )
        {
            $strFileName = $strFile . "(0).phps";
            file_put_contents( $strFileName , $strContentFile );
            require_once( $strFileName );
            if( self::REMOVE_FILES )
            {
                unlink( $strFileName );
            }
        }
        else
        {
            eval( '?' . '>' . $strContentFile . '' );
        }
    }
    
    /**
     * Implement a code instrumentation into a file
     *
     * @param string $strFile
     * @param string $strContentFile
     */
    protected function codeInstrumentationFile( $strFile , $strContentFile )
    {
        $arrLines = explode( "\n"  , $strContentFile );
        $arrOldClasses   = array();
        $arrNewClasses   = array();
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

        if( $this->isRelativePath( $strFile ) )
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
}
?>
