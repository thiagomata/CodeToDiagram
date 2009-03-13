<?php
define( "COMPONENTS_PATH" , str_replace( "\\" , "/" , str_replace( basename( __FILE__ ) , "" , __FILE__ ) ) );

require_once( COMPONENTS_PATH . "_start.php" );
require_once( COMPONENTS_PATH . "library/_start.php" );
//require_once( COMPONENTS_PATH . "backtrace/_start.php" );
require_once( COMPONENTS_PATH . "extendedReflection/_start.php" );
require_once( COMPONENTS_PATH . "codeReflection/_start.php" );
require_once( COMPONENTS_PATH . "codeInstrumentation/_start.php" );
require_once( COMPONENTS_PATH . "xmlSequence/_start.php" );
require_once( COMPONENTS_PATH . "codeToDiagram/_start.php" );
?>
