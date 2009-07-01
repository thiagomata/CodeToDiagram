<?php
/**
 * @package examples
 * @subpackage ThreeLittlePigs
 */

/**
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * Three Little Pigs as simple example of the code to diagram
 *
 * 1. require once the code to diagram started
 * 2. start the code to diagram
 * 3. load the necessary classes
 * 4. start the history
 */

// 1. require once the code to diagram started
require_once( '../../public/codetodiagram.php' );

// 2. start the code to diagram

CodeToDiagram::getInstance()->start();

CodeToDiagram::getInstance()->getMatchGroupStereotypes()
    ->addItemName( "History"   , UmlSequenceDiagramStereotype::getStereotypeByName( "boundary" ) )
    ->addItemName( "Wolf"      , UmlSequenceDiagramStereotype::getStereotypeByName( "user" ) )
    ->addItemName( "LittlePig" , UmlSequenceDiagramStereotype::getStereotypeByName( "controller" ) )
    ->addItemName( "House"     , UmlSequenceDiagramStereotype::getStereotypeByName( "entity" ) )
;

// recursive calls should be ignored into this diagram //
CodeToDiagram::getInstance()
    ->setIgnoreRecursiveCalls( true )
    ->setMergeSameClassObjects( false);

// the class history should be ignored //
// all the gets and sets should be ignored //
CodeToDiagram::getInstance()->getGatekeeperClasses()->getForbiddenMatch()
    ->addItemName( "History" )
    ->addItemRegularExpression( "^(get(.*)|set(.*))$" )
;

// an alternative way to remove the class house //
// just to show how to regular expression can be flexibe //
//CodeToDiagram::getInstance()->addIgnoredMethodRegex( "^House::(.*)$" );

// 3. load the necessary classes
require_once( 'Wolf.class.php' );
require_once( 'Pig.class.php' );
require_once( 'House.class.php' );
require_once( 'History.class.php' );

// 4. start the history
new History();

?>