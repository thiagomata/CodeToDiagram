<?php
/* 
 * Examples using the match name list.
 *
 * @package Match
 */

require_once( "_start.php" );

function MatchNameExample1()
{
	$objMatchName = new MatchName();
	$objMatchName->addItem( "Molly" );
	$objMatchName->addItem( "Armitage" );
	$objMatchName->addItem( "Wintermute" , "machine" );
	$objMatchName->addItem( "Case" , "hacker" );
	if ( $objMatchName->found( "Molly" ) !== true ) return false;
	if ( $objMatchName->match( "Molly" ) !== true ) return false;
	if( $objMatchName->match( "Wintermute" ) !== "machine" ) return false;
	if( $objMatchName->match( "Jackson" ) !== false ) return false;
	return true;
}

if( MatchNameExample1() )
{
	print "ok!";
}
else
{
	print "fail!";
}
?>
