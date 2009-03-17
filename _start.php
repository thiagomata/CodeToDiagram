<?php

define( "PATH_CODE_TO_DIAGRAM" , str_replace( "\\" , "/" , str_replace( basename( __FILE__ ) , "" , __FILE__ ) ) );
define( "PATH_CODE_TO_DIAGRAM_COMPONENT" , PATH_CORUJA . "components/" );

require_once( PATH_CODE_TO_DIAGRAM_COMPONENT . "_start.php" );

?>
