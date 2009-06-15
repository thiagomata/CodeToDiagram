<?php
/**
 * RuleMatch Start
 * @package RuleMach
 */

/**
 * Load the RuleMatch package
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
if ( class_exists( "Loader" ) )
{
    Loader::requireOnce( "RuleNameMatch.class.php" , true );
    Loader::requireOnce( "RuleRegularExpressionMatch.class.php" , true );
    Loader::requireOnce( "RuleMatchList.class.php" , true );
    Loader::requireOnce( "RuleMatch.class.php" , true );
}
else
{
    require_once( "RuleNameMatch.class.php" );
    require_once( "RuleRegularExpressionMatch.class.php" );
    require_once( "RuleMatchList.class.php" );
    require_once( "RuleMatch.class.php" );
}
?>