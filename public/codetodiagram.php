<?php

error_reporting( E_ALL | E_NOTICE | E_PARSE );
ini_set( 'display_errors', 'On' );

define( "PUBLIC_PATH" , str_replace( "\\" , "/" , str_replace( basename( __FILE__ ) , "" , __FILE__ ) ) );
require_once( PUBLIC_PATH . '../components/_start.php' );


function error_handler($code, $message, $file, $line)
{
    if (0 == error_reporting())
    {
        return;
    }
    throw new CodeToDiagramException($message, 0, $code, $file, $line);
}

$arrDebugBackTrace = debug_backtrace();
$strFile = ( $arrDebugBackTrace[0][ 'file' ] );
define( "CALLER_PATH", str_replace( basename( $strFile ) , "" , $strFile ) );

CodeToDiagram::init( basename( $strFile ) );

?>
