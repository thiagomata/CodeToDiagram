<?php

define( "PATH_CORUJA" , str_replace( "\\" , "/" , str_replace( basename( __FILE__ ) , "" , __FILE__ ) ) );
define( "PATH_CORUJA_COMPONENT" , PATH_CORUJA . "components/" );

require_once( PATH_CORUJA_COMPONENT . "_start.php" );

?>
