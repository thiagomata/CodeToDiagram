<?php
/**
 * UmlSequenceDiagramFactoryFromXml - Create a UmlSequenceDiagram based into Xml Files
 * @package UmlSequenceDiagram
 */

/**
 * Factory what creates UmlSequenceDiagram based into Xml Files
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlSequenceDiagramFactoryFromXml implements UmlSequenceDiagramFactoryInterface
{
	/**
	 * Singleton of the UmlSequenceDiagramFactoryFromXml
	 *
	 * @see UmlSequenceDiagramFactoryInterface::$objInstance
	 * @var UmlSequenceDiagramFactoryFromXml
	 */
	protected static $objInstance;

	/**
	 * Xml Sequence Object in factory
	 *
	 * @see UmlSequenceDiagramFactoryInterface->objUmlSequenceDiagram
	 * @var UmlSequenceDiagram
	 */
	protected $objUmlSequenceDiagram;

	/**
	 * Simple Xml Element used to access information from a xml
	 *
	 * @var SimpleXmlElement
	 */
    protected $objXml;

	/**
	 * Return the singleton of the UmlSequenceDiagramFactoryFromXml
	 *
	 * @return UmlSequenceDiagramFactoryFromXml
	 */
	public static function getInstance()
	{
		if( self::$objInstance == null )
		{
			self::$objInstance = new UmlSequenceDiagramFactoryFromXml();
		}
		return self::$objInstance;
	}


	/**
	 * Set the xml of the sequence object
	 *
	 * @see UmlSequenceDiagram->objXml
	 * @see UmlSequenceDiagram::getXml()
	 * @param string $strXml
	 * @return UmlSequenceDiagramFactoryFromXml me
	 */
    public function setXml( $strXml )
    {
        $this->objXml = simplexml_load_string( $strXml );
        return $this;
    }

	/**
	 * Get the xml of the sequence object
	 *
	 * @see UmlSequenceDiagram->objXml
	 * @see UmlSequenceDiagram::setXml( string )
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
	 * @see UmlSequenceDiagramFactoryInterface->setUmlSequenceDiagram( UmlSequenceDiagram )
     * @param $objUmlSequenceDiagram
     * @return UmlSequenceDiagramFactoryFromXml me
     */
    public function setUmlSequenceDiagram( UmlSequenceDiagram $objUmlSequenceDiagram )
    {
    	$this->objUmlSequenceDiagram = $objUmlSequenceDiagram;
    	return $this;
    }

    /**
     * get the xml sequence object
     *
	 * @see UmlSequenceDiagramFactoryInterface->getUmlSequenceDiagram()
     * @return UmlSequenceDiagram
     */
    public function getUmlSequenceDiagram()
    {
    	return $this->objUmlSequenceDiagram;
    }

    /**
     * create a UmlSequenceDiagram based into its configurations
     *
	 * @see UmlSequenceDiagramFactoryInterface->perform()
     * @return UmlSequenceDiagram
     */
    public function perform()
    {
    	$this->setUmlSequenceDiagram( new UmlSequenceDiagram() );
        $this->loadActors();
        $this->loadMessages();
        return $this->getUmlSequenceDiagram();
    }

    /**
     * Load the xml file and based on it insert a list of actors into the
     * UmlSequenceDiagram Object
     */
    protected function loadActors()
    {
    	$arrActors = $this->getUmlSequenceDiagram()->getActors();

      	foreach( $this->objXml->actors->actor as $xmlActor )
        {
            $intId = (integer)$xmlActor['id'];
            $strType = (string)$xmlActor['type'];
            $strName = (string)$xmlActor;

            $objActor = new UmlSequenceDiagramActor();
            $objActor->setId( $intId );
            $objActor->setType( $strType );
            $objActor->setName( $strName );

            $arrActors[ $objActor->getId() ] = $objActor;
        }
        ksort( $arrActors );
        $this->getUmlSequenceDiagram()->setActors( $arrActors );
    }

    /**
     * Load the xml file and based on it insert a list of messages into the
     * UmlSequenceDiagram Object
     */
    protected function loadMessages()
    {
    	$arrMessages = $this->getUmlSequenceDiagram()->getMessages();
    	$arrActors = $this->getUmlSequenceDiagram()->getActors();

    	foreach( $this->objXml->messages->message as $xmlMessage )
        {
            $intFrom    = (integer)$xmlMessage[ 'from' ];
            $intTo      = (integer)$xmlMessage[ 'to' ];
            $strType    = (string) $xmlMessage[ 'type' ];
            $strText = (string) $xmlMessage[ 'text' ];

            $objMessage = new UmlSequenceDiagramMessage();
            $objMessage->setType( $strType );
            $objMessage->setText( $strText );

           if( !array_key_exists( $intFrom , $arrActors ) )
            {
                throw new Exception( ' Actor From ' . $intFrom . ' not Found ' );
            }
            $objMessage->setActorFrom( $arrActors[ $intFrom ] );

           if( !array_key_exists( $intTo , $arrActors ) )
            {
                throw new Exception( ' Actor To ' . $intTo . ' not Found ' );
            }
            $objMessage->setActorTo( $arrActors[ $intTo ] );

            if( isset( $xmlMessage->values->value ) )
            foreach( $xmlMessage->values->value as $xmlValue )
            {
                $strName = (string)$xmlValue['name'];
                $strValue = (string)$xmlValue['value'];
                $objValue = new UmlSequenceDiagramValue();
                $objValue->setName( $strName );
                $objValue->setValue( $strValue );

                $objMessage->addValue( $objValue );
            }

            $arrMessages[] = $objMessage;
        }
        $this->getUmlSequenceDiagram()->setMessages( $arrMessages );
    }
}
?>