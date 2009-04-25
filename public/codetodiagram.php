<?php

/**
 * Active all the errors messages
 */
error_reporting( E_ALL | E_NOTICE | E_PARSE );
ini_set( 'display_errors', 'On' );

if( !isset( $strPublicPath  ) )
{
    #1. Define the public path
    $strPublicPath =str_replace( "\\" , "/" , str_replace( basename( __FILE__ ) , "" , __FILE__ ) );

    #2. Load the components of the code to diagram
    require_once( $strPublicPath . '../components/_start.php' );

    #3. redefine the error handler function to the code to diagram

    function error_handler($code, $message, $file, $line)
    {
        if (0 == error_reporting())
        {
            return;
        }

        throw new CodeToDiagramException($message, 0, $code, $file, $line);
    }

    #4. get the caller path
    $arrDebugBackTrace = debug_backtrace();
    $strFile = ( $arrDebugBackTrace[0][ 'file' ] );
    $strCallerPath = ( str_replace( basename( $strFile ) , "" , $strFile ) );

    #5. get the relative path of the code to diagram bootstrap
    $strPathFile = CorujaStringManipulation::getRelativePath( $strCallerPath , $strPublicPath );

    #6. add a instance of the code to diagram bootstrap into the load files array for the recursive call
    CodeToDiagram::getInstance()->addFile( $strPathFile . basename( __FILE__ ) , basename( __FILE__ ) );

    #7. init the code to diagram
    CodeToDiagram::init( basename( $strFile ) );
    CodeToDiagram::getInstance()->setPublicPath( $strPublicPath );
    CodeToDiagram::getInstance()->setCallerPath( $strCallerPath );
}
?>