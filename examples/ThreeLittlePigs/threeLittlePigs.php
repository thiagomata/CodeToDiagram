<?php
require_once( '../../public/codetodiagram.php' );
CodeToDiagram::getInstance()->start();

require_once( 'Wolf.class.php' );
require_once( 'Pig.class.php' );
require_once( 'House.class.php' );
require_once( 'History.class.php' );

new History();



?>
