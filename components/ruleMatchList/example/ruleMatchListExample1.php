<?php
/* 
 * Examples using the rule match list.
 *
 * @package RuleMatchList
 */

require_once( "_start.php" );

$objRule = new RuleMatchList();
$objRule->addIgnoredName( "something" );
print serialize( $objRule->validate( "else" ) ) ; // 1
print serialize( $objRule->validate( "something" ) ) ;  // 0
$objRule->addExclusiveName( "noop" );
print serialize( $objRule->validate( "else" ) ) ; // 0
print serialize( $objRule->validate( "noop" ) ) ;  // 1

?>
