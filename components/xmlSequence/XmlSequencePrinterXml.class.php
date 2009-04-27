<?php
/**
 * Generate a html diagram of the xml sequence object
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @package XmlSequence
 *
 */
class XmlSequencePrinterXml implements XmlSequencePrinterInterface
{
	/**
	 * xml sequence object what will be print
	 * 
	 * @see XmlSequencePrinterInterface->objXmlSequence
	 * @var XmlSequence
	 */
	protected $objXmlSequence;
	
	/**
	 * Singleton of the XmlSequencePrinterXml
	 * 
	 * @see XmlSequencePrinterInterface::$objInstance
	 * @var XmlSequencePrinterXml
	 */
	protected static $objInstance;	

	/**
	 * Return the singleton of the XmlSequencePrinterXml
	 * 
	 * @see XmlSequencePrinterInterface::getInstance
	 * @return XmlSequencePrinterXml
	 */
	public static function getInstance()
	{
		if( self::$objInstance == null )
		{
			self::$objInstance = new XmlSequencePrinterXml();
		}
		return self::$objInstance;
	}
		
	/**
	 * Perfom the print process
	 *  
	 * @see XmlSequencePrinterInterface::perform( XmlSequence )
	 * @param XmlSequence $objXmlSequence
	 * @return mixer
	 */
	public function perform( XmlSequence $objXmlSequence )
	{
		$this->objXmlSequence = $objXmlSequence;
		return $this->createXml();	
	}

    /**
     * Create and return the xml of the sequence diagram object
     *
     * @see XmlSequencePrinterXml::createXmlHeader()
     * @see XmlSequencePrinterXml::createXmlActors()
     * @see XmlSequencePrinterXml::createXmlFooter()
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
    	$arrActors = $this->objXmlSequence->getActors();
    	
        $strXmlActors = "<actors>\n";
        foreach( $arrActors as $objActor )
        {
            /** @var $objActor XmlSequenceActor */
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
    	$arrMessages = $this->objXmlSequence->getMessages();
    	
    	$strXmlMessages = "<messages>\n";
        foreach( $arrMessages as $objMessage )
        {
            /** @var $objMessage XmlSequenceMessage */
            
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
                /** @var $objValue XmlSequenceValue */
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