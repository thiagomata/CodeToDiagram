<?php
error_reporting( E_ALL | E_NOTICE | E_PARSE );
ini_set( 'display_errors', 'On' );

require_once( '../_start.php' );


function error_handler($code, $message, $file, $line)
{
    if (0 == error_reporting())
    {
        return;
    }
    throw new DebugExecutionException($message, 0, $code, $file, $line);
}

$arrDebugBackTrace = debug_backtrace();
$strFile = ( $arrDebugBackTrace[0][ 'file' ] );

DebugExecution::init( basename( $strFile ) );

?>
