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

$strXml = CorujaArrayManipulation::getArrayField( $_REQUEST , "xml" , "" );
if( $strXml == "" )
{
    $strXml = file_get_contents( 'sequence.xml' );
}
$strXml =  html_entity_decode( $strXml );
$strXml = stripslashes( $strXml );
$objXmlSequence = UmlSequenceDiagramFactoryFromXml::getInstance()->setXml( $strXml )->perform();
$strTitle = CorujaArrayManipulation::getArrayField( $_REQUEST, "title" , 'Sequence Diagram' );
$intFont = (integer)CorujaArrayManipulation::getArrayField( $_REQUEST , "font" , 40 );
$intZoom = (integer)CorujaArrayManipulation::getArrayField( $_REQUEST , "zoom" , 50 );
$booDetails = (boolean)CorujaArrayManipulation::getArrayField( $_REQUEST , "detais" , false );
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
            <?php print UmlSequenceDiagramPrinterToHtml::getInstance()->
                    getConfiguration()->
                    setZoom( $intZoom )->
                    setPercentFont( $intFont )->
                    setShowDetails( $booDetails )->
                    perform( $objXmlSequence ) ?>
            <?php require_once( "footer.php" ); ?>
    </body>
</html>