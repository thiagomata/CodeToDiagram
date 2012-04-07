<?php
/**
 * UmlClassDiagramPrinterConfigurationToXml - Configuration object to the
 * UmlClassDiagramPrinterToXml
 * @package UmlClassDiagram
 */

/**
 * Configuration object to the UmlClassDiagramPrinterToXml
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class UmlClassDiagramPrinterConfigurationToHtml implements UmlClassDiagramPrinterConfigurationInterface
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
     * @default false
     */
    protected $booExternalAccess = false;

    /**
     * Width in pixels of the diagram
     *
     * @var integer
     * @default 800
     */
    protected $intWidth = 800;

    /**
     * Height in pixels of the diagram
     *
     * @var integer
     * @default 800
     */
    protected $intHeight = 800;

    /**
     * If embeded the script will not create the Xml header tags
     * but just paste a script with the diagram element.
     *
     * If not embeded the script will create the full Xml with all
     * the header needed.
     *
     * @var boolean
     * @default false
     */
    protected $booEmbeded = false;

    /**
     * Flag to control if the detail description should be print
     * into the diagram.
     *
     * @var boolean
     * @default true
     */
    protected $booShowDetails = true;
    
    protected static $strDefaultCanvasId = "canvasboxdiagram";
    
    protected $strCanvasId;
    
    public static function getDefaultCanvasId()
    {
        return self::$strDefaultCanvasId;
    }
    
    public function __construct()
    {
        $this->strCanvasId = self::$strDefaultCanvasId;
    }
    
    public function getCanvasId()
    {
        return $this->strCanvasId;
    }
    
    public function setCanvasId( $strCanvasId )
    {
        $this->strCanvasId = $strCanvasId;
    }
    
    /**
     * Set the public path of the code execution
     *
     * @see UmlClassDiagramPrinterInterface::setPublicPath( string )
     * @param string $strPublicPath
     * @return UmlClassDiagramPrinterConfigurationToXml me
     */
    public function setPublicPath( $strPublicPath )
    {
        $this->strPublicPath = (string)$strPublicPath;
        return $this;
    }

    /**
     * Get the public path of the code execution
     *
     * @see UmlClassDiagramPrinterInterface::getPublicPath()
     * @return string
     */
    public function getPublicPath()
    {
        return $this->strPublicPath;
    }

    /**
     * Set the caller path of the code execution
     *
     * @see UmlClassDiagramPrinterInterface::setCallerPath( string )
     * @param string $strCallerPath
     * @return UmlClassDiagramPrinterConfigurationToXml me
     */
    public function setCallerPath( $strCallerPath )
    {
        $this->strCallerPath = (string)$strCallerPath;
        return $this;
    }

    /**
     * Get the caller path of the code execution
     *
     * @see UmlClassDiagramPrinterInterface::getCallerPath()
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
     * @see UmlClassDiagramPrinterInterface::setExternalAccess( boolean )
     * @param boolean $booExternalPath
     * @return UmlClassDiagramPrinterConfigurationToXml me
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
     * @see UmlClassDiagramPrinterInterface::getExternalAccess()
     * @return boolean
     */
    public function getExternalAccess()
    {
        return $this->booExternalAccess;
    }

    /**
     * Set the width in pixels of the diagram
     *
     * @see UmlClassDiagramPrinterInterface::setWidth( integer )
     * @param integer $intWidth
     * @return UmlClassDiagramPrinterConfigurationToXml me
     */
    public function setWidth( $intWidth )
    {
        $this->intWidth = (integer)$intWidth;
        return $this;
    }

    /**
     * Get the width in pixels of the diagram
     *
     * @see UmlClassDiagramPrinterInterface::getWidth()
     * @return integer $intWidth
     */
    public function getWidth()
    {
        return $this->intWidth;
    }

    /**
    /**
     * Set the Height in pixels of the diagram
     *
     * @see UmlClassDiagramPrinterInterface::setHeight( integer )
     * @param integer $intHeight
     * @return UmlClassDiagramPrinterConfigurationToXml me
     */
    public function setHeight( $intHeight )
    {
        $this->intHeight = (integer)$intHeight;
        return $this;
    }

    /**
     * Get the Height in pixels of the diagram
     *
     * @see UmlClassDiagramPrinterInterface::getHeight()
     * @return integer $intHeight
     */
    public function getHeight()
    {
        return $this->intHeight;
    }

    /**
     * Set the zoom of the diagram
     *
     * The zoom reduce / enlarge the diagram
     * keeping the proportion beteewn the dimension
     * and images
     *
     * @see UmlClassDiagramPrinterInterface::setZoom( $intZoom )
     * @param integer $intZoom
     * @return UmlClassDiagramPrinterConfigurationToXml me
     */
    public function setZoom( $intZoom )
    {
        $this->intZoom = (integer)$intZoom;
        return $this;
    }

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
    public function getZoom()
    {
        return $this->intZoom;
    }

    /**
     * Set if the diagram is embeded
     *
     * @param integer $booEmbeded
     * @return UmlClassDiagramPrinterConfigurationToXml me
     */
    public function setEmbeded( $booEmbeded )
    {
        $this->booEmbeded = $booEmbeded;
        return $this;
    }

    /**
     * Get if the diagram is embeded
     *
     * @return integer
     */
    public function getEmbeded()
    {
        return $this->booEmbeded;
    }

    /**
     * Set if the diagram should show the details
     *
     * @param integer $booShowDetails
     * @return UmlClassDiagramPrinterConfigurationToXml me
     */
    public function setShowDetails( $booShowDetails )
    {
        $this->booShowDetails = $booShowDetails;
        return $this;
    }

    /**
     * Get if the diagram should show the details
     *
     * @return integer
     */
    public function getShowDetails()
    {
        return $this->booShowDetails;
    }

    /**
     * Get the public folder path
     *
     * @return string
     */
    public function getPublicFolderPath()
    {
        if( $this->getExternalAccess() )
        {
            $strPublicPath = $this->getPublicPath();
        }
        else
        {
            if  (
                    ( $this->getCallerPath() != null )
                    and
                    ( $this->getPublicPath() != null )
                )
            {
                $strPublicPath = CorujaFileManipulation::getRelativePath(
                    $this->getCallerPath(),
                    $this->getPublicPath()
                );
            }
            elseif
                (
                    ( $this->getCallerPath() == null )
                    and
                    ( $this->getPublicPath() != null )
                )
            {
                $strPublicPath = $this->getPublicPath();
            }
            else
            {
                $strPublicPath = "./";
            }
        }
        return $strPublicPath;
    }

    /**
     *
     * @param UmlClassDiagram $objUmlClassDiagram
     * @return string
     */
    public function perform( $objUmlClassDiagram )
    {
        return UmlClassDiagramPrinterToXml::getInstance()->perform( $objUmlClassDiagram );
    }
}
?>