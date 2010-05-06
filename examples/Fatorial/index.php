<?php
/**
 * @package examples
 * @subpackage Fatorial
 */

/**
 * Fatorial Example
 *
 * Example of the CodeToDiagram into a fatorial function
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * 1. require once the code to diagram core
 * 2. start the code to diagram
 * 3. require once the necessary classes
 * 4. start the class service
 * 
 */

// 1. require once the code to diagram core
require_once( '../../public/codetodiagram.php' );

// 2. start the code to diagram
CodeToDiagram::getInstance()->start();

// 3. require once the necessary classes

ini_set( "xdebug.collect_params" , "4" );

//xdebug_start_trace( "xdebug.txt" );

require_once( "Fatorial.php" );

// 4. start the class service
print Fatorial::play(3);

?>
