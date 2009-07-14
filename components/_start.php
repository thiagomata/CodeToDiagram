<?php
define( "COMPONENTS_PATH" , str_replace( "\\" , "/" , str_replace( basename( __FILE__ ) , "" , __FILE__ ) ) );

require_once( COMPONENTS_PATH . "library/_start.php" );
require_once( COMPONENTS_PATH . "loader/_start.php" );
Loader::requireOnce( COMPONENTS_PATH . "_start.php" );
Loader::requireOnce( COMPONENTS_PATH . "match/_start.php" );
Loader::requireOnce( COMPONENTS_PATH . "umlSequenceDiagram/_start.php" );
//Loader::requireOnce( COMPONENTS_PATH . "backtrace/_start.php" );
Loader::requireOnce( COMPONENTS_PATH . "extendedReflection/_start.php" );
Loader::requireOnce( COMPONENTS_PATH . "codeReflection/_start.php" );
Loader::requireOnce( COMPONENTS_PATH . "codeInstrumentation/_start.php" );
Loader::requireOnce( COMPONENTS_PATH . "codeToDiagram/_start.php" );
Loader::requireOnce( COMPONENTS_PATH . "debug/_start.php" );
?>
