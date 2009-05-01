<?php
/**
 * Loader Start
 * @package loader
 */

/**
 * Load the loader package
 */
if ( class_exists( "Loader" ) )
{
    Loader::requireOnce( "Loader.class.php" , true );
}
else
{
    require_once( "Loader.class.php" );
}
?>