<?php 
/**
 * This file convert the http request into a sequence diagram into screen.
 * Can be used to external access, to be test, to be a remote tool, etc.
 * 
 * @package public
 * @subpackage xmlToDiagram
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * 
 */

require_once( '../classes/_start.php' );

$intZoom = (integer)getArrayElement( $_POST , "zoom" , 50 );
$strXml = getArrayElement( $_POST , "xml" , '<sequence></sequence>' );
$strTitle = getArrayElement( $_POST , "title" , 'Sequence Diagram' );

$objXmlSequence = new XmlSequence();
$objXmlSequence->setZoom( $intZoom);
$objXmlSequence->setXml( $strXml );

?>
<html>
    <head>
        <title>
            <?php print $strTitle ?>
        </title>
    </head>
    <body>
            <?php print $objXmlSequence->show(); ?>
    </body>
</html>