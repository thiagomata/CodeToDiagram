<?php
/**
 * UmlSequenceDiagramPrinterConfigurationToXml - Configuration object to the
 * UmlSequenceDiagramPrinterToXml
 * @package UmlSequenceDiagram
 */

/**
 * Configuration object to the UmlSequenceDiagramPrinterToXml
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class UmlSequenceDiagramPrinterConfigurationToXml implements UmlSequenceDiagramPrinterConfigurationInterface
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
     * Height of each line in relative proporsion to the width
     *
     * @var integer
     * @default 10
     */
    protected $intLinePercentHeight = 25;

    /**
     * Height of each line in relative proporsion to the width
     *
     * @var integer
     * @default 10
     */
    protected $intLineActorPercentHeight = 40;

    /**
     * The zoom reduce / enlarge the diagram
     * keeping the proportion beteewn the dimension
     * and images
     *
     * @var integer
     * @default  100
     */
    protected $intZoom = 100;

    /**
     * width ( in percent ) for each actor header
     * relating to the width of one actor
     *
     * @var integer
     * @default 10
     */
    protected $intActorHeaderPercentWidth = 75;

    /**
     * width ( in percent ) of the logo image into
     * the actor header
     * 
     * @var integer
     * @default 70
     */
    protected $intActorLogoPercentWidth = 70;

    /**
     * width ( in percent ) for each actor bar
     * relating to the width of one actor
     *
     * @var integer
     * @default 2
     */
    protected $intActorBarPercentWidth = 2;

    /**
     * size ( in percent ) of text font
     * relating to the width of one actor
     *
     * @var integer
     * @default 10
     */
    protected $intPercentFont = 30;
    
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
    
    /**
     * Set the public path of the code execution
     *
     * @see UmlSequenceDiagramPrinterInterface::setPublicPath( string )
     * @param string $strPublicPath
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
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
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
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
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
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
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
     */
    public function setWidth( $intWidth )
    {
        $this->intWidth = (integer)$intWidth;
        return $this;
    }

    /**
     * Get the width in pixels of the diagram
     *
     * @see UmlSequenceDiagramPrinterInterface::getWidth()
     * @return integer $intWidth
     */
    public function getWidth()
    {
        return $this->intWidth;
    }

    /**
     * Set the zoom of the diagram
     *
     * The zoom reduce / enlarge the diagram
     * keeping the proportion beteewn the dimension
     * and images
     *
     * @see UmlSequenceDiagramPrinterInterface::setZoom( $intZoom )
     * @param integer $intZoom
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
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
     * @see UmlSequenceDiagramPrinterInterface::getZoom()
     * @return integer $intZoom
     */
    public function getZoom()
    {
        return $this->intZoom;
    }

    /**
     * Set the height of each line in relative proporsion to the width
     *
     * @see UmlSequenceDiagramPrinterInterface::setLinePercentHeight( integer )
     * @param integer $intPercentHeight
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
     */
    public function setLinePercentHeight( $intPercentHeight )
    {
        $this->intLinePercentHeight = (integer)$intPercentHeight;
        return $this;
    }

    /**
     * Get the height of each line in relative proporsion to the width
     *
     * @see UmlSequenceDiagramPrinterInterface::getLinePercentHeight()
     * @return integer;
     */
    public function getLinePercentHeight()
    {
        return $this->intLinePercentHeight;
    }

    /**
     * Set the height of each line in relative proporsion to the width
     *
     * @see UmlSequenceDiagramPrinterInterface::setLineActorPercentHeight( integer )
     * @param integer $intActorPercentHeight
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
     */
    public function setLineActorPercentHeight( $intActorPercentHeight )
    {
        $this->intLineActorPercentHeight = (integer)$intActorPercentHeight;
        return $this;
    }

    /**
     * Get the height of the actor line in relative proporsion to the width
     *
     * @see UmlSequenceDiagramPrinterInterface::getLineActorPercentHeight()
     * @return integer;
     */
    public function getLineActorPercentHeight()
    {
        return $this->intLineActorPercentHeight;
    }

    /**
     * Set the actor header percent width
     *
     * Set the width of the actor header relating to the width of one actor area
     * into the diagram
     *
     * @see UmlSequenceDiagramPrinterInterface::setActorHeaderPercentWidth( $intActorHeaderPercentWidth )
     * @param integer $intActorHeaderPercentWidth
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
     */
    public function setActorHeaderPercentWidth( $intActorHeaderPercentWidth )
    {
        $this->intActorHeaderPercentWidth = (integer)$intActorHeaderPercentWidth;
        return $this;
    }

    /**
     * Get the actor header percent width
     *
     * Set the width of the actor header relating to the width of one actor area
     * into the diagram
     *
     * @see UmlSequenceDiagramPrinterInterface::getActorHeaderPercentWidth()
     * @return integer $intActorHeaderPercentWidth
     */
    public function getActorHeaderPercentWidth()
    {
        return $this->intActorHeaderPercentWidth;
    }

    /**
     * Set the width ( in percent ) of the logo image into the actor header
     *
     * @see UmlSequenceDiagramPrinterInterface::setActorLogoPercentWidth( $intActorLogoPercentWidth )
     * @param integer $intActorLogoPercentWidth
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
     */
    public function setActorLogoPercentWidth( $intActorLogoPercentWidth )
    {
        $this->intActorLogoPercentWidth = (integer)$intActorLogoPercentWidth;
        return $this;
    }

    /**
     * Get the width ( in percent ) of the logo image into the actor header
     *
     * @see UmlSequenceDiagramPrinterInterface::getActorLogoPercentWidth()
     * @return integer $intActorLogoPercentWidth
     */
    public function getActorLogoPercentWidth()
    {
        return $this->intActorLogoPercentWidth;
    }

    /**
     * Set the actor bar percent width
     *
     * Set the width of the actor bar relating to the width of one actor area
     * into the diagram
     *
     * @see UmlSequenceDiagramPrinterInterface::setActorBarPercentWidth( $intActorBarPercentWidth )
     * @param integer $intActorBarPercentWidth
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
     */
    public function setActorBarPercentWidth( $intActorBarPercentWidth )
    {
        $this->intActorBarPercentWidth = (integer)$intActorBarPercentWidth;
        return $this;
    }

    /**
     * Get the actor bar percent width
     *
     * Set the width of the actor bar relating to the width of one actor area
     * into the diagram
     *
     * @see UmlSequenceDiagramPrinterInterface::getActorBarPercentWidth()
     * @return integer $intActorBarPercentWidth
     */
    public function getActorBarPercentWidth()
    {
        return $this->intActorBarPercentWidth;
    }

    /**
     * Set the size of the font in percent width
     *
     * Set the size of the font in percent width relating to the width of
     * one actor area into the diagram
     *
     * @see UmlSequenceDiagramPrinterInterface::setPercentFont( $intPercentFont )
     * @param integer $intPercentFont
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
     */
    public function setPercentFont( $intPercentFont )
    {
        $this->intPercentFont = (integer)$intPercentFont;
        return $this;
    }

    /**
     * Get the size of the font in percent width
     *
     * Get the size of the font in percent width relating to the width of
     * one actor area into the diagram
     * and images
     *
     * @see UmlSequenceDiagramPrinterInterface::getPercentFont()
     * @return integer $intPercentFont
     */
    public function getPercentFont()
    {
        return $this->intPercentFont;
    }

    /**
     * Set if the diagram is embeded
     *
     * @param integer $booEmbeded
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
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
     * @return UmlSequenceDiagramPrinterConfigurationToXml me
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
     * @param UmlSequenceDiagram $objUmlSequenceDiagram
     * @return string
     */
    public function perform( $objUmlSequenceDiagram )
    {
        return UmlSequenceDiagramPrinterToXml::getInstance()->perform( $objUmlSequenceDiagram );
    }
}
?>
