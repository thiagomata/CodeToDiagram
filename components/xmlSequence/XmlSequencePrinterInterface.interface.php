<?php
/**
 * Generate the xml output of the XmlSequence
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @package XmlSequence
 */
interface XmlSequencePrinterInterface
{
	/**
	 * Return the singleton of the XmlSequencePrinterDiagram
	 * 
	 * @return XmlSequencePrinterInterface
	 */
	public static function getInstance();	

	/**
	 * Perfom the print process
	 *  
	 * @param XmlSequence $objXmlSequence
	 * @return mixer
	 */
	public function perform( XmlSequence $objXmlSequence );
}
?>