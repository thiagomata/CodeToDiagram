<?php 
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