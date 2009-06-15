<?php
/* 
 * Examples using the rule match list.
 *
 * @package RuleMatchList
 */

require_once( "_start.php" );

$objRule = new RuleMatchList();
$objRule->addIgnoredName( "something" );
print serialize( $objRule->match( "else" ) ) ; // 1
print serialize( $objRule->match( "something" ) ) ;  // 0
$objRule->addExclusiveName( "noop" );
print serialize( $objRule->match( "else" ) ) ; // 0
print serialize( $objRule->match( "noop" ) ) ;  // 1

?>
