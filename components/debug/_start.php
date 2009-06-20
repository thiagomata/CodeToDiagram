<?php
/**
 * Library Start
 * @package library
 */

/**
 * Load the library package
 */
if( class_exists( "Loader" ) )
{
    Loader::requireOnce( "CorujaDebug.class.php" , true );
}
else
{
    require_once( "CorujaDebug.class.php" );
}
?>