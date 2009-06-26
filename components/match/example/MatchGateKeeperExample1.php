<?php
/* 
 * Examples using the match gate opener.
 *
 * @package Match
 */

require_once( "_start.php" );

function MatchGateKeeperExample1()
{
    $objMatch = new MatchGateKeeper();
    $objMatch->getAllowedMatch()->addItemName( "just" );
    $objMatch->getAllowedMatch()->addItemName( "us" );
	if ( $objMatch->match( "other" ) !== false ) return false;

    $objMatch = new MatchGateKeeper();
    $objMatch->getForbiddenMatch()->addItemRegularExpression("^set*");
    $objMatch->getForbiddenMatch()->addItemRegularExpression("^get*");
    $objMatch->getForbiddenMatch()->addItemName( "play" );
	if ( $objMatch->match( "setSomething" ) !== false ) return false;
	if ( $objMatch->match( "getSomething" ) !== false ) return false;
	if ( $objMatch->match( "play" ) !== false ) return false;
	if ( $objMatch->match( "other" ) !== true) return false;

    return true;
}

if( MatchGateKeeperExample1() === TRUE )
{
	print "ok!";
}
else
{
	print "fail!";
}
?>
