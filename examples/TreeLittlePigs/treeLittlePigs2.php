<?php
/**
 * This example helps you to see how to
 * create many diagrams based into a single code execution
 * 
 * This can be useful to create the diagrams of each method
 * of some class for example.
 *
 * The comments are just to help understand
 * not been necessary to the execution
 */

require_once( '../../public/codetodiagram.php' );
// change the output type from screen to file //
CodeToDiagram::getInstance()->setOutputType( 'file' );
// set the file name //
CodeToDiagram::getInstance()->setFileName( 'treeLitlePigs.html' );
// start the code recording //
CodeToDiagram::getInstance()->start();

# this code will be saved {
    require_once( 'Wolf.class.php' );
    require_once( 'Pig.class.php' );
    require_once( 'House.class.php' );
    require_once( 'History.class.php' );
    new History();
# } using the file with the specified name
CodeToDiagram::getInstance()->save();

# this code will not be into any diagram {
$objPig = new LittlePig();
$objPig->setName( "GreenPig" );
$objPig->say( "this will to no diagram " );
# } because the restart command
CodeToDiagram::getInstance()->restart();

// output will be a file //
CodeToDiagram::getInstance()->setOutputType( 'file' );
// name of the new file //
CodeToDiagram::getInstance()->setFileName( 'treeLitlePigs2.html' );
# this code will be saved {
$objWolf = new Wolf();
$objWolf->say( "i will be back " . date( "h:i:s") );
CodeToDiagram::getInstance()->save();
# } into the new file
?>
