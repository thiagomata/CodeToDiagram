<?php
/**
 * UmlSequenceDiagramPrinterInterface - define the interface of Uml Sequence
 * Diagram Printer object
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
     * Set the configuration of the printer
     * 
     * @param UmlSequenceDiagramPrinterConfigurationInterface $objConfiguration
     * @return UmlSequenceDiagramPrinterInterface me
     */
    public  function setConfiguration( UmlSequenceDiagramPrinterConfigurationInterface $objConfiguration );

    /**
     * Get the configuration of the printer
     *
     * @return UmlSequenceDiagramPrinterConfigurationInterface
     */
    public  function getConfiguration();


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