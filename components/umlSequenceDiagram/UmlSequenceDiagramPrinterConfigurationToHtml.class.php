<?php
/**
 * UmlSequenceDiagramPrinterConfigurationToHtml - Configuration object to the
 * UmlSequenceDiagramPrinterToHtml
 * @package UmlSequenceDiagram
 */

/**
 * Configuration object to the UmlSequenceDiagramPrinterToHtml
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class UmlSequenceDiagramPrinterToHtml implements UmlSequenceDiagramPrinterConfigurationInterface
{
    /**
     * public path of the code execution
     * 
     * @var string
     */
    protected $strPublicPath;

    /**
     * caller path of the code execution
     * 
     * @var string
     */
    protected $strCallerPath;

    /**
     * flag if the access is by external link
     * 
     * @var boolean
     */
    protected $booExternalAccess;

    /**
     * Width in pixels of the diagram
     *
     * @var integer
     */
    protected $intWidth;

    /**
     * Height in pixels of each line of the diagram
     *
     * @var integer
     */
    protected $intLineHeight;
    
    /**
     * Set the public path of the code execution
     *
     * @see UmlSequenceDiagramPrinterInterface::setPublicPath( string )
     * @param string $strPublicPath
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setPublicPath( $strPublicPath )
    {
        $this->strPublicPath = (string)$strPublicPath;
        return $this;
    }

    /**
     * Get the public path of the code execution
     *
     * @see UmlSequenceDiagramPrinterInterface::getPublicPath()
     * @return string
     */
    public function getPublicPath()
    {
        return $this->strPublicPath;
    }

    /**
     * Set the caller path of the code execution
     *
     * @see UmlSequenceDiagramPrinterInterface::setCallerPath( string )
     * @param string $strCallerPath
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setCallerPath( $strCallerPath )
    {
        $this->strCallerPath = (string)$strCallerPath;
        return $this;
    }

    /**
     * Get the caller path of the code execution
     *
     * @see UmlSequenceDiagramPrinterInterface::getCallerPath()
     * @return string
     */
    public function getCallerPath()
    {
        return $this->strCallerPath;
    }

    /**
     * Set <code>true</code> if the code is executed by
     * external access and <code>false</false> if not
     *
     * @see UmlSequenceDiagramPrinterInterface::setExternalAccess( boolean )
     * @param boolean $booExternalPath
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setExternalAccess( $booExternalAccess )
    {
        $this->booExternalAccess = (boolean)$booExternalAccess;
        return $this;
    }

    /**
     * Get <code>true</code> if the code is executed by
     * external access and <code>false</false> if not
     *
     * @see UmlSequenceDiagramPrinterInterface::getExternalAccess()
     * @return boolean
     */
    public function getExternalAccess()
    {
        return $this->booExternalAccess;
    }

    /**
     * Set the width in pixels of the diagram
     *
     * @see UmlSequenceDiagramPrinterInterface::setWidth( integer )
     * @param integer $intWidth
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setWidth( $intWidth )
    {
        $this->intWidth = (integer)$intWidth;
    }

    /**
     * Get the width in pixels of the diagram
     *
     * @see UmlSequenceDiagramPrinterInterface::getWidth()
     * @return integer $intWidth
     */
    public function getWidth( $intWidth )
    {
        return $this->intWidth;
    }

    /**
     * Set the height in pixels of each line
     * of the diagram
     *
     * @see UmlSequenceDiagramPrinterInterface::setLineHeight( integer )
     * @param integer $intHeight
     * @return UmlSequenceDiagramPrinterInterface
     */
    public function setLineHeight( $intHeight )
    {
        $this->intLineHeight = (integer)$intHeight;
    }

    /**
     * Set the height in pixels of each line
     * of the diagram
     *
     * @see UmlSequenceDiagramPrinterInterface::getLineHeight()
     * @return integer;
     */
    public function getLineHeight()
    {
        return $this->intLineHeight;
    }
    
}
?>
