<?php
class CodeToDiagram
{
    protected static $arrFiles = array();

    protected static $booStart = false;

    protected static $strFileFrom = null;

    const RUN_IN_FILES = false;

    const CODE_TO_DIAGRAM_CLASS_PREFIX = "CodeToDiagram";
    
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
    public static function isRelativePath( $strFile )
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

    public static function init( $strFile , $strCodeToDiagramOutputFile )
    {
        if( self::$booStart == false )
        {
            $strFileFrom = __FILE__;

            $strFileFrom = str_replace( '/', '\\', $strFileFrom );

            self::loadFile( $strFile , $strFile  );

            $strDiagram = CodeInstrumentationReceiver::getInstance()->getXmlSequence()->show();

            if( $strCodeToDiagramOutputFile == null )
            {
                print $strDiagram;
            }
            else
            {
                file_put_contents($strCodeToDiagramOutputFile, $strDiagram );
            }
            exit();
        }
    }

    public static function fixFileName( $strFileFrom, $strFile )
    {
        $strFileFrom = str_replace( '/', '\\', $strFileFrom );
        $strFile = str_replace( '/', '\\', $strFile );
        $strFilePath = substr( $strFileFrom ,  0 , -(strlen(basename($strFileFrom ) ) ) );
        $strFile = $strFilePath . $strFile;

        return $strFile;
    }

    public static function addFile( $strFileFrom, $strFile )
    {
        $strFile = self::fixFileName( $strFileFrom, $strFile );

        self::$arrFiles[] = $strFile;
    }

    public static function hasFile( $strFileFrom , $strFile )
    {
        return in_array( $strFile ,  self::$arrFiles );
    }

    public static function CodeToDiagramRequireOnce( $strFileFrom, $strFile )
    {
//        print "CodeToDiagramRequireOnce from: "  . $strFileFrom . "<Br/>\n";
//        print "CodeToDiagramRequireOnce to:  " . $strFile . "<Br/>\n";

        $arrCodeToDiagramBackTrace = debug_backtrace();

        if( !self::hasFile( $strFileFrom , $strFile ) )
        {
            self::CodeToDiagramRequire( $strFileFrom, $strFile );
        }
    }

    public static function CodeToDiagramIncludeOnce( $strFileFrom, $strFile )
    {
        if( !self::hasFile( $strFileFrom , $strFile ) )
        {
            self::CodeToDiagramIncludeOnce( $strFileFrom , $strFile );
        }
    }

    public static function CodeToDiagramRequire( $strFileFrom, $strFile )
    {
        self::loadFile( $strFileFrom , $strFile );
    }

    public static function CodeToDiagramInclude( $strFileFrom, $strFile )
    {
        self::loadFile( $strFileFrom , $strFile );
    }

    public static function loadFile( $strFileFrom, $strFile )
    {
//        print "loadfile from: "  . $strFileFrom . "<Br/>\n";
//        print "loadfile to:  " . $strFile . "<Br/>\n";

        if( basename( $strFile ) == 'CodeToDiagram.class.php' )
        {
            return;
        }
        self::addFile( $strFileFrom, $strFile );

        if( self::isRelativePath( $strFile ) )
        {
            $strFullFile = self::fixFileName( $strFileFrom, $strFile );
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

        if( self::$booStart == false )
        {
            self::$booStart = true;
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
                'CodeToDiagram::CodeToDiagramRequireOnce("'. $strFile . '",' ,
                'CodeToDiagram::CodeToDiagramRequire("'. $strFile . '",' ,
                'CodeToDiagram::CodeToDiagramInclude("'. $strFile . '",' ,
                'CodeToDiagram::CodeToDiagramIncludeOnce("'. $strFile . '",',
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
