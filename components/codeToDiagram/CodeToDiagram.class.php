<?php
class CodeToDiagram
{
    protected $arrFiles = array();

    protected $booStart = false;

    protected $strFileFrom = null;

    protected $strFileName = null;
    
    protected $strOutputType = "screen";

    protected static $objInstance;
    
    const RUN_IN_FILES = true;

    const REMOVE_FILES = true;

    const CODE_TO_DIAGRAM_CLASS_PREFIX = "CTD";

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
    }

    public function getOutputType()
    {
        return $this->strOutputType;
    }

    public static function hasInstance()
    {
        return ( self::$objInstance !== null );
    }

    /**
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

    public function setStarted( $booStarted )
    {
        $this->booStart = $booStarted;
        return $this;
    }

    public function getStarted()
    {
        return $this->booStart;
    }

    public function setFileFrom( $strFileFrom )
    {
        $this->strFileFrom = $strFileFrom;
        return $this;
    }

    public function getFileFrom()
    {
        return $this->strFileFrom;
    }

    public function setFileName( $strFileName )
    {
        $this->strFileName = $strFileName;
        return $this;
    }

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

    public function start()
    {
        if( $this->getStarted() )
        {
            return;
        }
        CodeInstrumentationReceiver::getInstance()->restart();
        $this->CodeToDiagramRequireOnce($this->getFileFrom() , $this->getFileFrom() );
        exit();
    }

    public function restart()
    {
        CodeInstrumentationReceiver::getInstance()->restart();
        return $this;
    }

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

    public function  __destruct() {

       $this->save();
    }

    public static function init( $strFile )
    {
        if( self::getInstance()->getStarted() == false )
        {
            self::getInstance()->setFileFrom( $strFile );
        }
    }

    public function fixFileName( $strFileFrom, $strFile )
    {
        $strFileFrom = str_replace( '/', '\\', $strFileFrom );
        $strFile = str_replace( '/', '\\', $strFile );
        $strFilePath = substr( $strFileFrom ,  0 , -(strlen(basename($strFileFrom ) ) ) );
        $strFile = $strFilePath . $strFile;

        return $strFile;
    }

    public function addFile( $strFileFrom, $strFile )
    {
        $strFile = $this->fixFileName( $strFileFrom, $strFile );

        $this->arrFiles[] = $strFile;

        return $this;
    }

    public function hasFile( $strFileFrom , $strFile )
    {
        return in_array( $strFile ,  $this->arrFiles );
    }

    public function CodeToDiagramRequireOnce( $strFileFrom, $strFile )
    {
        $arrCodeToDiagramBackTrace = debug_backtrace();

        if( !$this->hasFile( $strFileFrom , $strFile ) )
        {
            $this->CodeToDiagramRequire( $strFileFrom, $strFile );
        }
        return $this;
    }

    public function CodeToDiagramIncludeOnce( $strFileFrom, $strFile )
    {
        if( !$this->hasFile( $strFileFrom , $strFile ) )
        {
            $this->CodeToDiagramIncludeOnce( $strFileFrom , $strFile );
        }
        return $this;
    }

    public function CodeToDiagramRequire( $strFileFrom, $strFile )
    {
        $this->loadFile( $strFileFrom , $strFile );
        return $this;
    }

    public function CodeToDiagramInclude( $strFileFrom, $strFile )
    {
        $this->loadFile( $strFileFrom , $strFile );
        return $this;
    }

    public function CodeToDiagramExit( $strFileFrom, $strMessage = '')
    {
        print "Exit called into $strFileFrom ($strMessage ) ";
        exit();
    }

    public function convertFileContent( $strContentFile , $strFile , $strFullFile )
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

    public function codeInstrumentationFile( $strFile , $strContentFile )
    {
        $arrLines = explode( "\n"  , $strContentFile );
        $arrOldClasses   = array();
        $arrNewClasses   = array();
        $arrOldInterface = array();
        $arrNewInterface = array();

        $this->codeInstrumentationClass( "class " , $arrOldClasses , $arrNewClasses, $arrLines );
        $this->codeInstrumentationClass( "interface " , $arrOldInterface , $arrNewInterface, $arrLines );

        $strContentFile = implode( "\n" , $arrLines );

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

    public function loadFile( $strFileFrom, $strFile )
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
