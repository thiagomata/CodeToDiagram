<?php
/* 
 * Examples using the match.
 *
 * @package Match
 */

require_once( "_start.php" );

function MatchExample1()
{
    $objMatch = new MatchGroup();
    $objMatch->addItemName( "Flatline" );
    $objMatch->addItemName( "Matrix" );
    $objMatch->addItemName( "Wintermute" , "artificial" );
    $objMatch->addItemName( "Case" , "hacker" );
    $objMatch->addItemRegularExpression( "M(.*)y" );
    $objMatch->addItemRegularExpression( "A(.*)e" );
    $objMatch->addItemRegularExpression( "Winter(.*)" , "machine" );
    $objMatch->addItemRegularExpression( "^Case$" , "cowboy" );

	if ( $objMatch->found( "Molly" ) !== true ) return false;
	if ( $objMatch->match( "Molly" ) !== true ) return false;
	if ( $objMatch->match( "Wintermute" ) !== "artificial" ) return false;
	if ( $objMatch->match( "Wintertime" ) !== "machine" ) return false;
	if ( $objMatch->match( "Case" ) !== "hacker" ) return false;
	if ( $objMatch->match( "Jackson" ) !== false ) return false;
	return true;
}

if( MatchExample1() === TRUE )
{
	print "ok!";
}
else
{
	print "fail!";
}
?>
