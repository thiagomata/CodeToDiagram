<?php
class DebugExecution
{
    protected static $arrFiles = array();

    protected static $booStart = false;

    const RUN_IN_FILES = false;
    
    public static function init( $strFile )
    {
        if( self::$booStart == false )
        {
            self::$booStart = true;

            $strFileFrom = __FILE__;

            $strFileFrom = str_replace( '/', '\\', $strFileFrom );

            self::loadFile( $strFile , $strFile  );

            print DebugRefletionReceiver::getInstance()->getXmlSequence()->show();
            exit();
        }
    }

    public static function fixFileName( $strFileFrom, $strFile  )
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

    public static function debugRequireOnce( $strFileFrom, $strFile )
    {
        $arrDebugBackTrace = debug_backtrace();

        if( !self::hasFile( $strFileFrom , $strFile ) )
        {
            self::debugRequire( $strFileFrom, $strFile );
        }
    }

    public static function debugIncludeOnce( $strFileFrom, $strFile )
    {
        if( !self::hasFile( $strFileFrom , $strFile ) )
        {
            self::debugIncludeOnce( $strFileFrom , $strFile );
        }
    }

    public static function debugRequire( $strFileFrom, $strFile )
    {
        self::loadFile( $strFileFrom , $strFile );
    }

    public static function debugInclude( $strFileFrom, $strFile )
    {
        self::loadFile( $strFileFrom , $strFile );
    }

    public static function loadFile( $strFileFrom, $strFile )
    {
        if( basename( $strFile ) == 'DebugExecution.class.php' )
        {
            return;
        }
        self::addFile( $strFileFrom, $strFile);

        $strFullFile = self::fixFileName($strFileFrom, $strFile);
        $strContentFile = file_get_contents($strFullFile );

        $strContentFile = str_replace(
                Array(
                    'require_once(' ,
                    'require(' ,
                    'include(' ,
                    'include_once(',
                    '/** DEBUG_IGNORE **/',
                    '/** END_DEBUG_IGNORE **/',
                ),
                Array(
                    'DebugExecution::debugRequireOnce("'. $strFile . '",' ,
                    'DebugExecution::debugRequire("'. $strFile . '",' ,
                    'DebugExecution::debugInclude("'. $strFile . '",' ,
                    'DebugExecution::debugIncludeOnce("'. $strFile . '",',
                    '/** DEBUG_IGNORE ' ,
                    'END_DEBUG_IGNORE **/',
                ),
                $strContentFile
            );

        $arrLines = explode( "\n"  , $strContentFile );

        $arrOldClasses = array();
        $arrNewClasses = array();
        
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
                $strNewClassName = "Debug" . $strOldClassName;

                $arrOldClasses[] = $strOldClassName;
                $arrNewClasses[] = $strNewClassName;
                
                $arrWords[0] = $strNewClassName;
                $strAfter = implode( " " , $arrWords );
                $strLine = $strBefore . $strAfter;
                $arrLines[ $intLine ] = $strLine;
            }
        }

        $strContentFile = implode( "\n" , $arrLines );

        if( self::RUN_IN_FILES )
        {
            file_put_contents( $strFile . "debug_before.php" , $strContentFile );
           require_once( $strFile . "debug_before.php" );
        }
        else
        {
            eval( '?' . '>' . $strContentFile . '' );
        }

        foreach( $arrNewClasses as $intKey => $strNewClassName )
        {
            $oReflectionCode = new DebugReflectionClass( $strNewClassName , $strContentFile );
            $oReflectionCode->setClassName( $arrOldClasses[ $intKey ] );
            $strNewCode = $oReflectionCode->getCode();
           if( self::RUN_IN_FILES )
           {
               file_put_contents( $strNewClassName . "debug.php" , '<?' . 'php ' .  $strNewCode );
               require_once( $strNewClassName . "debug.php" );
           }
           else
           {
               eval( $strNewCode );
           }
        }
    }
}
?>