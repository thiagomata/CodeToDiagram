<?php 
/**
 * Factory what creates XmlSequence based into Xml Files
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @package XmlSequence
 */
class XmlSequenceFactoryXml implements XmlSequenceFactoryInterface
{
	/**
	 * Singleton of the XmlSequenceFactoryXml
	 * 
	 * @see XmlSequenceFactoryInterface::$objInstance
	 * @var XmlSequenceFactoryXml
	 */
	protected static $objInstance;	
		
	/**
	 * Xml Sequence Object in factory
	 * 
	 * @see XmlSequenceFactoryInterface->objXmlSequence
	 * @var XmlSequence
	 */
	protected $objXmlSequence;
	
	/**
	 * Simple Xml element used to access information from a xml
	 * 
	 * @var SimpleXmlElement
	 */
    protected $objXml;

	/**
	 * Set the xml of the sequence object
	 * 
	 * @see XmlSequence->objXml
	 * @see XmlSequence::getXml()
	 * @param string $strXml
	 * @return XmlSequence me
	 */
    public function setXml( $strXml )
    {
        $this->objXml = simplexml_load_string( $strXml );
        $this->load();
        return $this;
    }
     
	/**
	 * Get the xml of the sequence object
	 * 
	 * @see XmlSequence->objXml
	 * @see XmlSequence::setXml( string )
	 * @param string $strXml
	 * @return SimpleXmlElement
	 */
    public function getXml()
    {
        return $this->objXml;
    }

    /**
     * set the xml sequence object
     * 
	 * @see XmlSequenceFactoryInterface->setXmlSequence( XmlSequence )
     * @param $objXmlSequence
     * @return XmlSequenceFactoryXml me
     */
    public function setXmlSequence( XmlSequence $objXmlSequence )
    {
    	$this->objXmlSequence = $objXmlSequence;	
    	return $this;
    }
    
    /**
     * get the xml sequence object
     * 
	 * @see XmlSequenceFactoryInterface->getXmlSequence()
     * @return XmlSequence
     */
    public function getXmlSequence()
    {
    	return $this->objXmlSequence;	
    }
    
    /**
     * create a xml sequence based into its configurations
     * 
	 * @see XmlSequenceFactoryInterface->perform()
     * @return XmlSequence
     */
    public function perform()
    {
    	$this->setXmlSequence( new XmlSequence() );
        $this->loadActors();
        $this->loadMessages();
        return $this->getXmlSequence();
    }

    /**
     * Load the xml file and based on it insert a list of actors into the
     * XmlSequence Object
     */
    protected function loadActors()
    {
    	$arrActors = $this->getXmlSequence()->getActors();
    	
      	foreach( $this->objXml->actors->actor as $xmlActor )
        {
            $intId = (integer)$xmlActor['id'];
            $strType = (string)$xmlActor['type'];
            $strName = (string)$xmlActor;

            $objActor = new XmlSequenceActor();
            $objActor->setId( $intId );
            $objActor->setType( $strType );
            $objActor->setName( $strName );

            $arrActors[ $objActor->getId() ] = $objActor;
        }
        ksort( $arrActors );
        $this->getXmlSequence()->setActors( $arrActors );
    }

    /**
     * Load the xml file and based on it insert a list of messages into the
     * XmlSequence Object
     */
    protected function loadMessages()
    {
    	$arrMessages = $this->getXmlSequence()->getMessages();
    	
    	foreach( $this->objXml->messages->message as $xmlMessage )
        {
            $intFrom    = (integer)$xmlMessage[ 'from' ];
            $intTo      = (integer)$xmlMessage[ 'to' ];
            $strType    = (string) $xmlMessage[ 'type' ];
            $strText = (string) $xmlMessage[ 'text' ];

            $objMessage = new XmlSequenceMessage();
            $objMessage->setType( $strType );
            $objMessage->setText( $strText );

           if( !array_key_exists( $intFrom , $this->arrActors ) )
            {
                throw new Exception( ' Actor From ' . $intFrom . ' not Found ' );
            }
            $objMessage->setActorFrom( $this->arrActors[ $intFrom ] );

           if( !array_key_exists( $intTo , $this->arrActors ) )
            {
                throw new Exception( ' Actor To ' . $intTo . ' not Found ' );
            }
            $objMessage->setActorTo( $this->arrActors[ $intTo ] );

            if( isset( $xmlMessage->values->value ) )
            foreach( $xmlMessage->values->value as $xmlValue )
            {
                $strName = (string)$xmlValue['name'];
                $strValue = (string)$xmlValue['value'];
                $objValue = new XmlSequenceValue();
                $objValue->setName( $strName );
                $objValue->setValue( $strValue );

                $objMessage->addValue( $objValue );
            }

            $arrMessages[] = $objMessage;
        }
        $this->getXmlSequence()->setMessages( $arrMessages );
    }
}

?>