<?php
require_once( '../../public/codetodiagram.php' );
CodeToDiagram::getInstance()->start();

require_once( "Fatorial.php" );

print Fatorial::play(3);
?>
