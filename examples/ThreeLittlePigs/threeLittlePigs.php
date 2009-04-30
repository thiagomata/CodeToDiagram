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

// 3. load the necessary classes
require_once( 'Wolf.class.php' );
require_once( 'Pig.class.php' );
require_once( 'House.class.php' );
require_once( 'History.class.php' );

// 4. start the history
new History();

?>