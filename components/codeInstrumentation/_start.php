<?php
/**
 * Code Instrumentation Start
 * @package CodeInstrumentation
 */

/**
 * Load the Code Instrumentation package
 */
Loader::requireOnce(  "CodeInstrumentationException.class.php" , true );
Loader::requireOnce( "CodeInstrumentationReceiverConfiguration.class.php" , true );
Loader::requireOnce( "CodeInstrumentationReceiver.class.php" , true );
Loader::requireOnce( "CodeInstrumentationParameter.class.php" , true );
Loader::requireOnce( "CodeInstrumentationProperty.class.php" , true );
Loader::requireOnce( "CodeInstrumentationFunction.class.php" , true );
Loader::requireOnce( "CodeInstrumentationMethod.class.php" , true );
Loader::requireOnce( "CodeInstrumentationClass.class.php" , true );
?>