<?php
/**
 * @package public
 * @subpackage xmlToDiagram
 */

/**
 * This file convert the http request into a sequence diagram into screen.
 * Can be used to external access, to be test, to be a remote tool, etc.
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * 
 */

require_once( "../public/codetodiagram.php" );

$intZoom = (integer)CorujaArrayManipulation::getArrayField( $_POST , "zoom" , 50 );
$strXml = CorujaArrayManipulation::getArrayField( $_POST , "xml" , file_get_contents( 'sequence.xml' ) );
$strXml =  html_entity_decode( $strXml );
$strXml = stripslashes( $strXml );
$objXmlSequence = UmlSequenceDiagramFactoryFromXml::getInstance()->setXml( $strXml )->perform();
$strTitle = CorujaArrayManipulation::getArrayField( $_POST , "title" , 'Sequence Diagram' );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php require_once( "header.php" ) ?>
        <title>
            <?php print $strTitle ?>
        </title>
    </head>
    <body>
            <?php print UmlSequenceDiagramPrinterToHtml::getInstance()->setZoom( $intZoom )->perform( $objXmlSequence ) ?>
            <?php require_once( "footer.php" ); ?>
    </body>
</html>
