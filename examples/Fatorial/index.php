<?php
$strCodeToDiagramOutputFile="./anyname.html";
CodeToDiagram::getInstance()->start();

require_once( "Fatorial.php" );

print Fatorial::play(3);
?>
