<?php
/**
 * @package public
 * @subpackage xmlToDiagram
 */

/**
 * This file convert the http request into a Class diagram into screen.
 * Can be used to external access, to be test, to be a remote tool, etc.
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * 
 */

require_once( "codetodiagram.php" );

UmlClassDiagram::loadDefaultStereotypes();
$strXml = CorujaArrayManipulation::getArrayField( $_REQUEST , "xml" , "" );
if( $strXml == "" )
{
    $strXml = file_get_contents( '../examples/xmls/class1.xml' );
}
$strXml =  html_entity_decode( $strXml );
$strXml = stripslashes( $strXml );
$objXmlClass = UmlClassDiagramFactoryFromXml::getInstance()->setXml( $strXml )->perform();
$objConfiguration = new UmlClassDiagramPrinterConfigurationToHtml();
$objConfiguration->setPublicPath("./" );
UmlClassDiagramPrinterToHtml::getInstance()->setConfiguration( $objConfiguration );
print UmlClassDiagramPrinterToHtml::getInstance()->perform( $objXmlClass );
?>
<script>
    window.box.dblZoom = 0.7;
</script>