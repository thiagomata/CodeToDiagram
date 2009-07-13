<?php
/**
 * UmlSequenceDiagramPrinterToXml - Convert a UmlSequenceDiagram into a Xml
 * @package UmlSequenceDiagram
 */

/**
 * Generate a Xml from the Uml Sequence Diagram object
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class UmlSequenceDiagramPrinterToXml implements UmlSequenceDiagramPrinterInterface
{
	/**
	 * Uml Sequence Diagram object what will be print
	 * 
	 * @see UmlSequenceDiagramPrinterInterface->objUmlSequenceDiagram
	 * @var UmlSequenceDiagram
	 */
	protected $objUmlSequenceDiagram;

    /**
     * Uml Sequence Diagram Printer Configuration To Xml
     *
     * @todo Create the class configuration to the xml
     * @var UmlSequenceDiagramPrinterConfigurationToXml
     */
    protected $objConfiguration;

	/**
	 * Singleton of the UmlSequenceDiagramPrinterToXml
	 * 
	 * @see UmlSequenceDiagramPrinterInterface::$objInstance
	 * @var UmlSequenceDiagramPrinterToXml
	 */
	protected static $objInstance;	

	/**
	 * Return the singleton of the UmlSequenceDiagramPrinterToXml
	 * 
	 * @see UmlSequenceDiagramPrinterInterface::getInstance
	 * @return UmlSequenceDiagramPrinterToXml
	 */
	public static function getInstance()
	{
		if( self::$objInstance == null )
		{
			self::$objInstance = new UmlSequenceDiagramPrinterToXml();
		}
		return self::$objInstance;
	}

    /**
     * Get the header of the xml printer type
     */
    public function getHeader()
    {
        header( "Content-type: text/xml" );
    }

	/**
	 * Perfom the print process
	 *  
	 * @see UmlSequenceDiagramPrinterInterface::perform( UmlSequenceDiagram )
	 * @param UmlSequenceDiagram $objUmlSequenceDiagram
	 * @return mixer
	 */
	public function perform( UmlSequenceDiagram $objUmlSequenceDiagram )
	{
		$this->objUmlSequenceDiagram = $objUmlSequenceDiagram;
		return $this->createXml();	
	}

    /**
     * Create and return the xml of the sequence diagram object
     *
     * @see UmlSequenceDiagramPrinterToXml::createXmlHeader()
     * @see UmlSequenceDiagramPrinterToXml::createXmlActors()
     * @see UmlSequenceDiagramPrinterToXml::createXmlFooter()
     * @return string
     */
    public function createXml()
    {
        $strXml = '';
        $strXml .= $this->createXmlHeader();
        $strXml .= $this->createXmlActors();
        $strXml .= $this->createXmlMessages();
        $strXml .= $this->createXmlFooter();
        return $strXml;
    }

    /**
     * Create and return the header slice of the xml
     *
     * @return string
     */
    public function createXmlHeader()
    {
        return "<sequence>\n";
    }

    /**
     * Create and return the footer slice of the xml
     *
     * @return string
     */
    public function createXmlFooter()
    {
        return "</sequence>\n";
    }

    /**
     * Create and return the actors slice of the xml
     *
     * @return string
     */
    public function createXmlActors()
    {
    	$arrActors = $this->objUmlSequenceDiagram->getActors();
    	
        $strXmlActors = "\t<actors>\n";
        foreach( $arrActors as $objActor )
        {
            /** @var $objActor UmlSequenceDiagramActor */
            $strXmlActors .= "\t\t";
            $strXmlActors .= "<actor ";
            $strXmlActors .= 'id="' . $objActor->getId() . '" ';
            $strXmlActors .= 'type="' . $objActor->getType() . '" ';
            $strXmlActors .= '>';
            $strXmlActors .= $objActor->getName() . ':' . $objActor->getClassName();
            $strXmlActors .= "</actor>\n";
        }
        $strXmlActors .= "\t</actors>\n";
        return $strXmlActors;
    }

    /**
     * Create and return the messages slice of the xml
     *
     * @return string
     */
    public function createXmlMessages()
    {
    	$arrMessages = $this->objUmlSequenceDiagram->getMessages();
    	
    	$strXmlMessages = "\t<messages>\n";
        foreach( $arrMessages as $objMessage )
        {
            /** @var $objMessage UmlSequenceDiagramMessage */

            $strXmlMessages .= "\t\t";
            $strXmlMessages .= "<message ";
            $strXmlMessages .= 'type="' . $objMessage->getType() . '" ';
            $strXmlMessages .= 'from="' . $objMessage->getActorFrom()->getId() . '" ';
            $strXmlMessages .= 'to="' . $objMessage->getActorTo()->getId() . '" ';
            $strXmlMessages .= 'text="' . htmlentities( $objMessage->getText() ) . '" ';
            $strXmlMessages .= '>' . "\n";

            $strXmlMessages .= "\t\t\t";
            $strXmlMessages .= "<values>\n";

            $arrValues = $objMessage->getValues();
            foreach($arrValues as $objValue )
            {
                /** @var $objValue UmlSequenceDiagramValue */
                $strXmlMessages .= "\t\t\t\t";
                $strXmlMessages .= "<value ";
                $strXmlMessages .= 'name = "' . $objValue->getName() . '" ';
                $strXmlMessages .= 'value = "' . $objValue->getValue() . '" ';
                $strXmlMessages .= "/>\n";
            }

            $strXmlMessages .= "\t\t\t";
            $strXmlMessages .= "</values>\n";

            $strXmlMessages .= "\t\t";
            $strXmlMessages .= "</message>\n";
        }
        $strXmlMessages .= "\t</messages>\n";
        return $strXmlMessages;
    }

    /**
     * @todo Create the configuration class to the xml printer
     * @todo use the configuration class of the xml printer
     */
    public function setConfiguration( UmlSequenceDiagramPrinterConfigurationInterface $objConfiguration )
    {
        $this->objConfiguration = $objConfiguration;
    }

    /**
     * @todo Create the configuration class to the xml printer
     * @todo use the configuration class of the xml printer
     */
    public function getConfiguration()
    {
        return $this->objConfiguration;
    }
}
?>