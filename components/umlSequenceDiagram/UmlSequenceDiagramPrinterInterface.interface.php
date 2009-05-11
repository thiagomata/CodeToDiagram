<?php
/**
 * UmlSequenceDiagramPrinterInterface - define the interface of UmlSequenceDiagram object
 * @package UmlSequenceDiagram
 */

/**
 * Generate the interface of the printer of UmlSequenceDiagram object
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
interface UmlSequenceDiagramPrinterInterface
{
	/**
	 * Return the singleton of the UmlSequenceDiagramPrinterDiagram
	 * 
	 * @return UmlSequenceDiagramPrinterInterface
	 */
	public static function getInstance();	

	/**
	 * Perfom the print process
	 *  
	 * @param UmlSequenceDiagram $objUmlSequenceDiagram
	 * @return mixer
	 */
	public function perform( UmlSequenceDiagram $objUmlSequenceDiagram );

    /**
     * Create the php header to the printer type
     */
    public function getHeader();
}
?>