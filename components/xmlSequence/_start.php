<?php
/**
 * XmlSequence Start
 * @package XmlSequence
 */

/**
 * Load the XmlSequence package
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
Loader::requireOnce( 'XmlSequenceException.class.php' , true );
Loader::requireOnce( 'XmlSequenceFactoryInterface.interface.php' , true );
Loader::requireOnce( 'XmlSequencePrinterInterface.interface.php' , true );
Loader::requireOnce( 'XmlSequenceFactoryXml.class.php' , true );
Loader::requireOnce( 'XmlSequencePrinterXml.class.php' , true );
Loader::requireOnce( 'XmlSequencePrinterDiagram.class.php' , true );
Loader::requireOnce( 'XmlSequenceActor.class.php' , true );
Loader::requireOnce( 'XmlSequenceMessage.class.php' , true );
Loader::requireOnce( 'XmlSequenceValue.class.php' , true );
Loader::requireOnce( 'XmlSequence.class.php' , true );
?>