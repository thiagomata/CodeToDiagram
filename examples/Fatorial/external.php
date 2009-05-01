<?php

$arrBackTrace = debug_backtrace();
$arrCaller = $arrBackTrace[0];
$strFileCaller = $arrCaller[ 'file' ];

eval( '?>' .  file_get_contents( 'http://localhost/codetodiagram/public/external.php' ) );
CodeToDiagram::getInstance()->setCallerPathByFile( $strFileCaller );
CodeToDiagram::init( basename( $strFileCaller ) );
CodeToDiagram::getInstance()->start();
?>
