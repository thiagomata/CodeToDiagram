<?php
/**
 * UmlClassDiagramPrinterInterface - define the interface of Uml Class
 * Diagram Printer object
 * @package UmlClassDiagram
 */

/**
 * Generate the interface of the printer of UmlClassDiagram object
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
interface UmlClassDiagramPrinterInterface
{
    /**
     * Return the singleton of the UmlClassDiagramPrinterDiagram
     * 
     * @return UmlClassDiagramPrinterInterface
     */
     public static function getInstance();	

    /**
     * Set the configuration of the printer
     * 
     * @param UmlClassDiagramPrinterConfigurationInterface $objConfiguration
     * @return UmlClassDiagramPrinterInterface me
     */
    public  function setConfiguration( UmlClassDiagramPrinterConfigurationInterface $objConfiguration );

    /**
     * Get the configuration of the printer
     *
     * @return UmlClassDiagramPrinterConfigurationInterface
     */
    public  function getConfiguration();


    /**
     * Perfom the print process
     *  
     * @param UmlClassDiagram $objUmlClassDiagram
     * @return mixer
     */
     public function perform( UmlClassDiagram $objUmlClassDiagram );

    /**
     * Create the php header to the printer type
     */
    public function getHeader();
}
?>