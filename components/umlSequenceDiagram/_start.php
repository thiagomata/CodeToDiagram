<?php
/**
 * UmlSequenceDiagram Start
 * @package UmlSequenceDiagram
 */

/**
 * Load the UmlSequenceDiagram package
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
Loader::requireOnce( 'UmlSequenceDiagramException.class.php' , true );
Loader::requireOnce( 'UmlSequenceDiagramFactoryInterface.interface.php' , true );
Loader::requireOnce( 'UmlSequenceDiagramPrinterInterface.interface.php' , true );
Loader::requireOnce( 'UmlSequenceDiagramFactoryFromXml.class.php' , true );
Loader::requireOnce( 'UmlSequenceDiagramPrinterToXml.class.php' , true );
Loader::requireOnce( 'UmlSequenceDiagramPrinterToHtml.class.php' , true );
Loader::requireOnce( 'UmlSequenceDiagramActor.class.php' , true );
Loader::requireOnce( 'UmlSequenceDiagramMessage.class.php' , true );
Loader::requireOnce( 'UmlSequenceDiagramValue.class.php' , true );
Loader::requireOnce( 'UmlSequenceDiagram.class.php' , true );
?>