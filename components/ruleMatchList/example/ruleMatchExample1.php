<?php
/* 
 * Examples using the rule match list.
 *
 * @package RuleMatchList
 */

require_once( "_start.php" );

$objRule = new RuleMatch();
$objRule->addRegularExpression( "some*" );
print serialize( $objRule->match( "else" ) ) ; // 0
print serialize( $objRule->match( "something" ) ) ;  // 1
$objRule->addRegularExpression( "n*p" , ":D");
print serialize( $objRule->match( "else" ) ) ; // 0
print serialize( $objRule->match( "noop" ) ) ;  // :D
$objRule->addName( "noop" , ":D");
print serialize( $objRule->match( "else" ) ) ; // 0
print serialize( $objRule->match( "noop" ) ) ;  // :D
?>
