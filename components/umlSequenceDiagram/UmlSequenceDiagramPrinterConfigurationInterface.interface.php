<?php
/**
 * UmlSequenceDiagramPrinterConfigurationInterface - define the interface of Uml
 * Sequence Diagram Printer Configuration object
 * @package UmlSequenceDiagram
 */

/**
 * Minimal interface of the configuration object of printers of UmlSequenceDiagram object.
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 02-07-2009
 */
interface UmlSequenceDiagramPrinterConfigurationInterface
{
    /**
     * Set the public path of the code execution
     *
     * @see UmlSequenceDiagramPrinterInterface::setPublicPath( string )
     * @param string $strPublicPath
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setPublicPath( $strPublicPath );

    /**
     * Get the public path of the code execution
     *
     * @see UmlSequenceDiagramPrinterInterface::getPublicPath()
     * @return string
     */
    public function getPublicPath();

    /**
     * Set the caller path of the code execution
     *
     * @see UmlSequenceDiagramPrinterInterface::setCallerPath( string )
     * @param string $strCallerPath
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setCallerPath( $strCallerPath );

    /**
     * Get the caller path of the code execution
     *
     * @see UmlSequenceDiagramPrinterInterface::getCallerPath()
     * @return string
     */
    public function getCallerPath();

    /**
     * Set <code>true</code> if the code is executed by 
     * external access and <code>false</false> if not
     *
     * @see UmlSequenceDiagramPrinterInterface::setExternalAccess( boolean )
     * @param boolean $booExternalPath
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setExternalAccess( $booExternalPath );

    /**
     * Get <code>true</code> if the code is executed by
     * external access and <code>false</false> if not
     *
     * @see UmlSequenceDiagramPrinterInterface::getExternalAccess()
     * @return boolean
     */
    public function getExternalAccess();

    /**
     * Set the width in pixels of the diagram in the regular ( 100 ) zoom
     *
     * @see UmlSequenceDiagramPrinterInterface::setWidth( integer )
     * @param integer $intWidth
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setWidth( $intWidth );

    /**
     * Get the width in pixels of the diagram in the regular ( 100 ) zoom
     *
     * @see UmlSequenceDiagramPrinterInterface::getWidth()
     * @return integer $intWidth
     */
    public function getWidth();

    /**
     * Set the height in pixels of each line
     * of the diagram in the regular ( 100 ) zoom
     * 
     * @see UmlSequenceDiagramPrinterInterface::setLineHeight( integer )
     * @param integer $intHeight
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setLinePercentHeight( $intHeight );

    /**
     * Set the height in pixels of each line
     * of the diagram in the regular ( 100 ) zoom
     *
     * @see UmlSequenceDiagramPrinterInterface::getLineHeight()
     * @return integer;
     */
    public function getLinePercentHeight();

    /**
     * Set the zoom of the diagram
     *
     * The zoom reduce / enlarge the diagram
     * keeping the proportion beteewn the dimension
     * and images
     *
     * @see UmlSequenceDiagramPrinterInterface::setZoom( $intZoom )
     * @param integer $intZoom
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setZoom( $intZoom );

    /**
     * Get the zoom of the diagram
     *
     * The zoom reduce / enlarge the diagram
     * keeping the proportion beteewn the dimension
     * and images
     * 
     * @see UmlSequenceDiagramPrinterInterface::getZoom()
     * @return integer $intZoom
     */
    public function getZoom();

}
?>