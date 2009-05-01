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
    Loader::requireOnce( "CorujaArrayManipulation.class.php" , true );
    Loader::requireOnce( "CorujaClassManipulation.class.php" , true );
    Loader::requireOnce( "CorujaStringManipulation.class.php" , true );
    Loader::requireOnce( "CorujaFileManipulation.class.php" , true );
}
else
{
    require_once( "CorujaArrayManipulation.class.php" );
    require_once( "CorujaClassManipulation.class.php" );
    require_once( "CorujaStringManipulation.class.php" );
    require_once( "CorujaFileManipulation.class.php" );    
}
?>