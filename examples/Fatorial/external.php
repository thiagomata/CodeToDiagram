<?php
set_time_limit(0);

$arrBackTrace = debug_backtrace();
$arrCaller = $arrBackTrace[0];
$strFileCaller = $arrCaller[ 'file' ];

eval( '?>' .  file_get_contents( 'http://www.thiagomata.com/codetodiagram/svn/public/external.php' ) );
CodeToDiagram::getInstance()->setExternalAcess( true );
CodeToDiagram::getInstance()->setCallerPathByFile( $strFileCaller );
CodeToDiagram::init( basename( $strFileCaller ) );
CodeToDiagram::getInstance()->start();
?>
