<?php
/* 
 * Examples using the rule match list.
 *
 * @package RuleMatchList
 */

require_once( "_start.php" );


function MatchRegularExpressionExample1()
{
       $objMatchRegularExpression = new MatchRegularExpression();
       $objMatchRegularExpression->addItem( "M(.*)y" );
       $objMatchRegularExpression->addItem( "A(.*)e" );
       $objMatchRegularExpression->addItem( "Winter(.*)" , "machine" );
       $objMatchRegularExpression->addItem( "^Case$" , "hacker" );

       if ( $objMatchRegularExpression->found( "Molly" ) !== true ) return false;
       if ( $objMatchRegularExpression->match( "Molly" ) !== true ) return false;
       if( $objMatchRegularExpression->match( "Wintermute" ) !== "machine" ) return false;
       if( $objMatchRegularExpression->match( "Flatline" ) !== false ) return false;
       return true;
}

if( MatchRegularExpressionExample1() === true )
{
	print "ok!";
}
else
{
	print "fail!";
}
?>
