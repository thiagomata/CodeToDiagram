<?php
/**
 * UmlClassDiagramPrinterConfigurationInterface - define the interface of Uml
 * Class Diagram Printer Configuration object
 * @package UmlClassDiagram
 */

/**
 * Minimal interface of the configuration object of printers of UmlClassDiagram object.
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 02-07-2009
 */
interface UmlClassDiagramPrinterConfigurationInterface
{
    /**
     * Set the public path of the code execution
     *
     * @see UmlClassDiagramPrinterInterface::setPublicPath( string )
     * @param string $strPublicPath
     * @return UmlClassDiagramPrinterInterface
     */
    public function setPublicPath( $strPublicPath );

    /**
     * Get the public path of the code execution
     *
     * @see UmlClassDiagramPrinterInterface::getPublicPath()
     * @return string
     */
    public function getPublicPath();

    /**
     * Set the caller path of the code execution
     *
     * @see UmlClassDiagramPrinterInterface::setCallerPath( string )
     * @param string $strCallerPath
     * @return UmlClassDiagramPrinterInterface
     */
    public function setCallerPath( $strCallerPath );

    /**
     * Get the caller path of the code execution
     *
     * @see UmlClassDiagramPrinterInterface::getCallerPath()
     * @return string
     */
    public function getCallerPath();

    /**
     * Set <code>true</code> if the code is executed by 
     * external access and <code>false</false> if not
     *
     * @see UmlClassDiagramPrinterInterface::setExternalAccess( boolean )
     * @param boolean $booExternalPath
     * @return UmlClassDiagramPrinterInterface
     */
    public function setExternalAccess( $booExternalPath );

    /**
     * Get <code>true</code> if the code is executed by
     * external access and <code>false</false> if not
     *
     * @see UmlClassDiagramPrinterInterface::getExternalAccess()
     * @return boolean
     */
    public function getExternalAccess();

    /**
     * Set the width in pixels of the diagram in the regular ( 100 ) zoom
     *
     * @see UmlClassDiagramPrinterInterface::setWidth( integer )
     * @param integer $intWidth
     * @return UmlClassDiagramPrinterInterface
     */
    public function setWidth( $intWidth );

    /**
     * Get the width in pixels of the diagram in the regular ( 100 ) zoom
     *
     * @see UmlClassDiagramPrinterInterface::getWidth()
     * @return integer $intWidth
     */
    public function getWidth();

    /**
     * Set the Height in pixels of the diagram in the regular ( 100 ) zoom
     *
     * @see UmlClassDiagramPrinterInterface::setHeight( integer )
     * @param integer $intHeight
     * @return UmlClassDiagramPrinterInterface
     */
    public function setHeight( $intHeight );

    /**
     * Get the Height in pixels of the diagram in the regular ( 100 ) zoom
     *
     * @see UmlClassDiagramPrinterInterface::getHeight()
     * @return integer $intHeight
     */
    public function getHeight();

    /**
     * Set the zoom of the diagram
     *
     * The zoom reduce / enlarge the diagram
     * keeping the proportion beteewn the dimension
     * and images
     *
     * @see UmlClassDiagramPrinterInterface::setZoom( $intZoom )
     * @param integer $intZoom
     * @return UmlClassDiagramPrinterInterface
     */
    public function setZoom( $intZoom );

    /**
     * Get the zoom of the diagram
     *
     * The zoom reduce / enlarge the diagram
     * keeping the proportion beteewn the dimension
     * and images
     * 
     * @see UmlClassDiagramPrinterInterface::getZoom()
     * @return integer $intZoom
     */
    public function getZoom();

}
?>