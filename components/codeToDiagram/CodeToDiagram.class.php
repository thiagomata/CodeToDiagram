<?php
class CodeToDiagram
{
    protected $arrFiles = array();

    protected $booStart = false;

    protected $strFileFrom = null;

    protected $strFileName = null;
    
    protected $strOutputType = "screen";

    protected static $objInstance;
    
    const RUN_IN_FILES = false;

    const CODE_TO_DIAGRAM_CLASS_PREFIX = "CodeToDiagram";

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
    }

    public function getStarted()
    {
        return $this->booStart;
    }

    public function setFileFrom( $strFileFrom )
    {
        $this->strFileFrom = $strFileFrom;
    }

    public function getFileFrom()
    {
        return $this->strFileFrom;
    }

    public function setFileName( $strFileName )
    {
        $this->strFileName = $strFileName;
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
    }

    public function hasFile( $strFileFrom , $strFile )
    {
        return in_array( $strFile ,  $this->arrFiles );
    }

    public function CodeToDiagramRequireOnce( $strFileFrom, $strFile )
    {
//        print "CodeToDiagramRequireOnce from: "  . $strFileFrom . "<Br/>\n";
//        print "CodeToDiagramRequireOnce to:  " . $strFile . "<Br/>\n";

        $arrCodeToDiagramBackTrace = debug_backtrace();

        if( !$this->hasFile( $strFileFrom , $strFile ) )
        {
            $this->CodeToDiagramRequire( $strFileFrom, $strFile );
        }
    }

    public function CodeToDiagramIncludeOnce( $strFileFrom, $strFile )
    {
        if( !$this->hasFile( $strFileFrom , $strFile ) )
        {
            $this->CodeToDiagramIncludeOnce( $strFileFrom , $strFile );
        }
    }

    public function CodeToDiagramRequire( $strFileFrom, $strFile )
    {
        $this->loadFile( $strFileFrom , $strFile );
    }

    public function CodeToDiagramInclude( $strFileFrom, $strFile )
    {
        $this->loadFile( $strFileFrom , $strFile );
    }

    public function loadFile( $strFileFrom, $strFile )
    {
//        print "loadfile from: "  . $strFileFrom . "<Br/>\n";
//        print "loadfile to:  " . $strFile . "<Br/>\n";
//        print_r( $this->arrFiles );
        
        if( basename( $strFile ) == 'CodeToDiagram.class.php' )
        {
            return;
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
            // @todo Catch this exception
            throw new CodeToDiagramException( "Unable to find file: " . $strFullFile );
        }

        $strContentFile = file_get_contents( $strFullFile );

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
                '__FILE__',
            ),
            Array(
                'CodeToDiagram::getInstance()->CodeToDiagramRequireOnce("'. $strFile . '",' ,
                'CodeToDiagram::getInstance()->CodeToDiagramRequire("'. $strFile . '",' ,
                'CodeToDiagram::getInstance()->CodeToDiagramInclude("'. $strFile . '",' ,
                'CodeToDiagram::getInstance()->CodeToDiagramIncludeOnce("'. $strFile . '",',
                '"' . CALLER_PATH . $strFullFile . '"',
            ),
            $strContentFile
        );

        $arrLines = explode( "\n"  , $strContentFile );

        $arrOldClasses   = array();
        $arrNewClasses   = array();
        $arrOldInterface = array();
        $arrNewInterface = array();

        foreach( $arrLines as $intLine => $strLine )
        {
            $strTextSearch = "class ";
            if(  substr( strtolower( trim($strLine) ) , 0 , strlen( $strTextSearch ) ) == $strTextSearch )
            {
                //                $strLine = trim($strLine);
                $strBefore = substr( $strLine , 0 , strlen( $strTextSearch ) );
                $strAfter = substr( $strLine , strlen( $strTextSearch ) );
                $arrWords = explode( " " , $strAfter );

                $strOldClassName = $arrWords[0];
                $strNewClassName = self::CODE_TO_DIAGRAM_CLASS_PREFIX . $strOldClassName;

                $arrOldClasses[] = $strOldClassName;
                $arrNewClasses[] = $strNewClassName;

                $arrWords[0] = $strNewClassName;
                $strAfter = implode( " " , $arrWords );
                $strLine = $strBefore . $strAfter;
                $arrLines[ $intLine ] = $strLine;
            }

            $strTextSearch = "interface ";
            if(  substr( strtolower( trim($strLine) ) , 0 , strlen( $strTextSearch ) ) == $strTextSearch )
            {
                //                $strLine = trim($strLine);
                $strBefore = substr( $strLine , 0 , strlen( $strTextSearch ) );
                $strAfter = substr( $strLine , strlen( $strTextSearch ) );
                $arrWords = explode( " " , $strAfter );

                $strOldInterfaceName = $arrWords[0];
                $strNewInterfaceName = self::CODE_TO_DIAGRAM_CLASS_PREFIX . $strOldInterfaceName;

                $arrOldInterface[] = $strOldInterfaceName;
                $arrNewInterface[] = $strNewInterfaceName;

                $arrWords[0] = $strNewInterfaceName;
                $strAfter = implode( " " , $arrWords );
                $strLine = $strBefore . $strAfter;
                $arrLines[ $intLine ] = $strLine;
            }
        }

        $strContentFile = implode( "\n" , $arrLines );

        if( self::RUN_IN_FILES )
        {
            $strFileName = $strFile . "_CodeToDiagram(0).phps";
            file_put_contents( $strFileName , $strContentFile );
            require_once( $strFileName );
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
                $strFileName = $strNewClassName . "_CodeToDiagram(1).phps";
                file_put_contents( $strFileName , '<?' . 'php ' .  $strNewCode );
                require_once( $strFileName );
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
                $strFileName = $strNewClassName . "_CodeToDiagram(1).phps";
                file_put_contents( $strFileName , '<?' . 'php ' .  $strNewCode );
                require_once( $strFileName );
            }
            else
            {
                eval( $strNewCode );
            }
        }

    }
}
?>
