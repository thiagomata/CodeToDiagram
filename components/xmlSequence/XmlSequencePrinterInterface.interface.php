<?php
/**
 * XmlSequencePrinterInterface - define the interface of XmlSequence object
 * @package XmlSequence
 */

/**
 * Generate the interface of the printer of XmlSequence object
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
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