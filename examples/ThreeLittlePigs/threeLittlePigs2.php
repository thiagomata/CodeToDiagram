<?php
/**
 * @package examples
 * @subpackage ThreeLittlePigs
 */

/**
 * Three Little Pigs as complex example of the code to diagram
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * This example helps you to see how to
 * create many diagrams based into a single code execution
 * 
 * This can be useful to create the diagrams of each method
 * of some class for example.
 *
 * The comments are just to help understand
 * not been necessary to the execution
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */

// load the start of the code to diagram //
require_once( '../../public/codetodiagram.php' );

# create the diagram of the history and save it into some file {

	// change the output type from screen to file //
	CodeToDiagram::getInstance()->setOutputType( CodeToDiagram::OUTPUT_TYPE_FILE );

	// set the file name //
	CodeToDiagram::getInstance()->setFileName( 'threeLitlePigs.html' );

	// start the code recording //
	CodeToDiagram::getInstance()->start();

		# this code will be saved {
    	require_once( 'Wolf.class.php' );
    	require_once( 'Pig.class.php' );
    	require_once( 'House.class.php' );
    	require_once( 'History.class.php' );
    	new History();
		# } using the file with the specified name

    // save it into the file //
    CodeToDiagram::getInstance()->save();

# } the file is saved //

# this code will not be into any diagram {
	$objPig = new LittlePig();
	$objPig->setName( "GreenPig" );
	$objPig->say( "this will to no diagram " );
# } because the restart command

// this restart clean at all //
CodeToDiagram::getInstance()->restart();

# now reconfig to save the rest of execution into a new file {`

	// output will be a file //
	CodeToDiagram::getInstance()->setOutputType( CodeToDiagram::OUTPUT_TYPE_FILE  );

	// name of the new file //
	CodeToDiagram::getInstance()->setFileName( 'threeLitlePigs2.html' );

	# this code will be saved {
		$objWolf = new Wolf();
		$objWolf->say( "i will be back " . date( "h:i:s") );
		unset( $objWolf );
		CodeToDiagram::getInstance()->save();
	# } into the new file
		
# } the file is saved 		
?>
