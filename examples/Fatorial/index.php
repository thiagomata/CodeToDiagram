<?php
/** DEBUG_IGNORE **/
$strCodeToDiagramOutputFile="./anyname.html";
require_once( '../../public/codetodiagram.php' );
/** END_DEBUG_IGNORE **/

require_once( "Fatorial.php" );

print Fatorial::play(3);
?>
