<?php
/**
 * Example of the CodeToDiagram into a fatorial function
 *
 * 1. require once the code to diagram core
 * 2. start the code to diagram
 * 3. require once the necessary classes
 * 4. start the class service
 */
require_once( '../../public/codetodiagram.php' );
CodeToDiagram::getInstance()->start();

require_once( "Fatorial.php" );

print Fatorial::play(3);
?>
