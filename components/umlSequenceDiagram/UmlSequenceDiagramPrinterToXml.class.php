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
        return "
<sequence>
        ";
    }

    /**
     * Create and return the footer slice of the xml
     *
     * @return string
     */
    public function createXmlFooter()
    {
        return "
</sequence>
        ";
    }

    /**
     * Create and return the actors slice of the xml
     *
     * @return string
     */
    public function createXmlActors()
    {
    	$arrActors = $this->objUmlSequenceDiagram->getActors();
    	
        $strXmlActors = "<actors>\n";
        foreach( $arrActors as $objActor )
        {
            /** @var $objActor UmlSequenceDiagramActor */
            $strXmlActors .= "<actor ";
            $strXmlActors .= 'id="' . $objActor->getId() . '" ';
            $strXmlActors .= 'type="' . $objActor->getType() . '" ';
            $strXmlActors .= '>';
            $strXmlActors .= $objActor->getName() . ':' . $objActor->getClassName();
            $strXmlActors .= "</actor>\n";
        }
        $strXmlActors .= "</actors>\n";
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
    	
    	$strXmlMessages = "<messages>\n";
        foreach( $arrMessages as $objMessage )
        {
            /** @var $objMessage UmlSequenceDiagramMessage */
            
            $strXmlMessages .= "<message ";
            $strXmlMessages .= 'type="' . $objMessage->getType() . '" ';
            $strXmlMessages .= 'from="' . $objMessage->getActorFrom()->getId() . '" ';
            $strXmlMessages .= 'to="' . $objMessage->getActorTo()->getId() . '" ';
            $strXmlMessages .= 'text="' . htmlentities( $objMessage->getText() ) . '" ';
            $strXmlMessages .= '>';

            $strXmlMessages .= "<values>\n";

            $arrValues = $objMessage->getValues();
            foreach($arrValues as $objValue )
            {
                /** @var $objValue UmlSequenceDiagramValue */
                $strXmlMessages .= "<value ";
                $strXmlMessages .= 'name = "' . $objValue->getName() . '" ';
                $strXmlMessages .= 'value = "' . $objValue->getValue() . '" ';
                $strXmlMessages .= "/>\n";
            }

            $strXmlMessages .= "</values>\n";

            $strXmlMessages .= "</message>";
        }
        $strXmlMessages .= "</messages>\n";
        return $strXmlMessages;
    }   
}
?>