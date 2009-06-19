<?php
/**
 * Match Start
 * @package Match
 */

/**
 * Load the Match package
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
if ( class_exists( "Loader" ) )
{
    Loader::requireOnce( "MatchInterface.interface.php" , true );
	Loader::requireOnce( "MatchName.class.php" , true );
    Loader::requireOnce( "MatchRegularExpression.class.php" , true );
}
else
{
    require_once( "MatchInterface.interface.php" );
    require_once( "MatchName.class.php" );
    require_once( "MatchRegularExpression.class.php" );
}
?>
