<?php
/**
 * UmlClassDiagramFactoryFromXml - Create a UmlClassDiagram based into Xml Files
 * @package UmlClassDiagram
 */

/**
 * Factory what creates UmlClassDiagram based into Xml Files
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramFactoryFromXml implements UmlClassDiagramFactoryInterface
{
    /**
     * Singleton of the UmlClassDiagramFactoryFromXml
     *
     * @see UmlClassDiagramFactoryInterface::$objInstance
     * @var UmlClassDiagramFactoryFromXml
     */
    protected static $objInstance;

    /**
     * Xml Class Object in Factory
     *
     * @see UmlClassDiagramFactoryInterface->objUmlClassDiagram
     * @var UmlClassDiagram
     */
    protected $objUmlClassDiagram;

    /**
     * Simple Xml Element used to access information from a xml
     *
     * @var SimpleXmlElement
     */
    protected $objXml;

    /**
     * Return the singleton of the UmlClassDiagramFactoryFromXml
     *
     * @return UmlClassDiagramFactoryFromXml
     */
    public static function getInstance()
    {
        if( self::$objInstance == null )
        {
                self::$objInstance = new UmlClassDiagramFactoryFromXml();
        }
        return self::$objInstance;
    }


    /**
     * Set the xml of the Class object
     *
     * @see UmlClassDiagram->objXml
     * @see UmlClassDiagram::getXml()
     * @param string $strXml
     * @return UmlClassDiagramFactoryFromXml me
     */
    public function setXml( $strXml )
    {
        $this->objXml = simplexml_load_string( $strXml );
        return $this;
    }

    /**
     * Get the xml of the Class object
     *
     * @see UmlClassDiagram->objXml
     * @see UmlClassDiagram::setXml( string )
     * @param string $strXml
     * @return SimpleXmlElement
     */
    public function getXml()
    {
        return $this->objXml;
    }

    /**
     * set the xml Class object
     *
     * @see UmlClassDiagramFactoryInterface->setUmlClassDiagram( UmlClassDiagram )
     * @param $objUmlClassDiagram
     * @return UmlClassDiagramFactoryFromXml me
     */
    public function setUmlClassDiagram( UmlClassDiagram $objUmlClassDiagram )
    {
    	$this->objUmlClassDiagram = $objUmlClassDiagram;
    	return $this;
    }

    /**
     * get the xml Class object
     *
	 * @see UmlClassDiagramFactoryInterface->getUmlClassDiagram()
     * @return UmlClassDiagram
     */
    public function getUmlClassDiagram()
    {
    	return $this->objUmlClassDiagram;
    }

    /**
     * create a UmlClassDiagram based into its configurations
     *
	 * @see UmlClassDiagramFactoryInterface->perform()
     * @return UmlClassDiagram
     */
    public function perform()
    {
    	$this->setUmlClassDiagram( new UmlClassDiagram() );
        $this->loadClasses();
        $this->loadConnectors();
        return $this->getUmlClassDiagram();
    }

    /**
     * Load the xml file and based on it insert a list of Classes into the
     * UmlClassDiagram Object
     */
    protected function loadClasses()
    {
    	$arrClasses = $this->getUmlClassDiagram()->getClasses();

      	foreach( $this->objXml->classes->class as $xmlClass )
        {
            $strId      = (string)  $xmlClass['id'];
            $strName    = (string)  $xmlClass[ 'name' ];
            $strType    = (string)  $xmlClass['type'];
            $intWidth   = (integer) $xmlClass['width'];
            $intHeight  = (integer) $xmlClass['height'];
            $intX       = (integer) $xmlClass['x'];
            $intY       = (integer) $xmlClass['y'];

            if( $strName == "" )
            {
                throw new UmlClassDiagramException( "Class Name cannot be null" );
            }
            if( $strType != "" )
            {
                $objClass->setType( $strType );
            }
            $objClass = new UmlClassDiagramClass();
            $objClass->setId( $strId );
            $objClass->setName( $strName );
            $objClass->setX( $intX );
            $objClass->setY( $intY );
            $objClass->setWidth( $intWidth );
            $objClass->setHeight( $intHeight );
            
            if( isset( $xmlClass->attributes ) && isset( $xmlClass->attributes->attribute ) )
            foreach( $xmlClass->attributes->attribute as $xmlAttribute )
            {
                $objAttribute = new UmlClassDiagramAttribute();
                
                foreach($xmlAttribute->attributes() as $strKey => $mixValue ) 
                {
                    switch( $strKey )
                    {
                        case  "name":
                        {
                            $objAttribute->setName( (string)$mixValue );
                            break;   
                        }
                        case  "value":
                        {
                            $objAttribute->setValue( (string)$mixValue );
                            break;   
                        }
                        case  "type":
                        {
                            $objAttribute->setType( (string)$mixValue );
                            break;   
                        }
                        case  "visibility":
                        {
                            $objAttribute->setVisibility( (string)$mixValue );
                            break;   
                        }
                        case  "final":
                        {
                            $booFinal = CorujaStringManipulation::strToBool( (string)$mixValue );
                            $objAttribute->setFinal( $booFinal );
                            break;   
                        }
                        case  "static":
                        {
                            $booStatic = CorujaStringManipulation::strToBool( (string)$mixValue );
                            $objAttribute->setStatic( $booStatic );
                            break;   
                        }
                        case  "abstract":
                        {
                            $booAbstract = CorujaStringManipulation::strToBool( (string)$mixValue );
                            $objAttribute->setAbstract( $booAbstract );
                            break;   
                        }
                        default:
                        {
                            throw new UmlClassDiagramException( 'unknow parameter description "'. $strKey . '".' );
                        }
                    }
                }
                    
                if( $objAttribute->getName() == "" )
                {
                    throw new UmlClassDiagramException( 'Paramenter must have a name' );
                }
                $objClass->addAttribute( $objAttribute );

            }
              
            if( isset( $xmlClass->methods) && isset( $xmlClass->methods->method ) )
            foreach( $xmlClass->methods->method as $xmlMethod )
            {
                $objMethod = new UmlClassDiagramMethod();

                foreach($xmlMethod->attributes() as $strKey => $mixValue ) 
                {
                    switch( $strKey )
                    {
                        case  "name":
                        {
                            $objMethod->setName( (string)$mixValue );
                            break;   
                        }
                        case  "value":
                        {
                            $objMethod->setValue( (string)$mixValue );
                            break;   
                        }
                        case  "type":
                        {
                            $objMethod->setType( (string)$mixValue );
                            break;   
                        }
                        case  "visibility":
                        {
                            $objMethod->setVisibility( (string)$mixValue );
                            break;   
                        }
                        case  "final":
                        {
                            $booFinal = CorujaStringManipulation::strToBool( (string)$mixValue );
                            $objMethod->setFinal( $booFinal );
                            break;   
                        }
                        case  "static":
                        {
                            $booStatic = CorujaStringManipulation::strToBool( (string)$mixValue );
                            $objMethod->setStatic( $booStatic );
                            break;   
                        }
                        case  "abstract":
                        {
                            $booAbstract = CorujaStringManipulation::strToBool( (string)$mixValue );
                            $objMethod->setAbstract( $booAbstract );
                            break;   
                        }
                        default:
                        {
                            throw new UmlClassDiagramException( 'unknow parameter description "'. $strKey . '".' );
                        }
                    }
                }

                if( $objMethod->getName() == "" )
                {
                    throw new UmlClassDiagramException( 'Paramenter must have a name' );
                }
                
                if( isset( $xmlMethod->parameters ) && isset( $xmlMethod->parameters->parameter ) )
                foreach( $xmlMethod->parameters->parameter as $xmlParameter )
                {
                    $objParameter = new UmlClassDiagramParameter();
                
                    foreach($xmlParameter->attributes() as $strKey => $mixValue ) 
                    {
                        switch( $strKey )
                        {
                            case  "name":
                            {
                                $objParameter->setName( (string)$mixValue );
                                break;   
                            }
                            case  "value":
                            {
                                $objParameter->setValue( (string)$mixValue );
                                break;   
                            }
                            case  "type":
                            {
                                $objParameter->setType( (string)$mixValue );
                                break;   
                            }
                        }
                    }
                    
                    $objMethod->addParameter( $objParameter );
                }
                
                $objClass->addMethod( $objMethod );
            }
            $arrClasses[ $objClass->getId() ] = $objClass;
        }
        $this->getUmlClassDiagram()->setClasses( $arrClasses );
    }

    /**
     * Load the xml file and based on it insert a list of Connectors into the
     * UmlClassDiagram Object
     */
    protected function loadConnectors()
    {
    	$arrConnectors = $this->getUmlClassDiagram()->getConnectors();
    	$arrClasses = $this->getUmlClassDiagram()->getClasses();
        $objConnector = null;
        $objNote = null;
        
        $objDomConnectors = dom_import_simplexml( $this->objXml->connectors );
    	foreach( $objDomConnectors->childNodes as $objDomConnector )
        {
            if( ! $objDomConnector instanceof domElement )
            {
                continue;
            }
            $xmlConnector = simplexml_import_dom( $objDomConnector );
            switch( $xmlConnector->getName() )
            {
                case "connector":
                {
                    $strFrom    = (string)$xmlConnector[ 'from' ];
                    $strTo      = (string)$xmlConnector[ 'to' ];
                    $strType    = (string) $xmlConnector[ 'type' ];
                    $strText = (string) $xmlConnector[ 'text' ];

                    $objConnector = new UmlClassDiagramConnector();
                    $objConnector->setType( $strType );
                    $objConnector->setText( $strText );

                    if( !array_key_exists( $strFrom , $arrClasses ) )
                    {
                        throw new Exception( ' Class From ' . $strFrom . ' not Found ' );
                    }
                    $objConnector->setClassFrom( $arrClasses[ $strFrom ] );

                    if( !array_key_exists( $strTo , $arrClasses ) )
                    {
                        throw new Exception( ' Class To ' . $strTo . ' not Found ' );
                    }
                    $objConnector->setClassTo( $arrClasses[ $strTo ] );

                    if( isset( $xmlConnector->values->value ) )
                    foreach( $xmlConnector->values->value as $xmlValue )
                    {
                        $strName = (string)$xmlValue['name'];
                        $strValue = (string)$xmlValue['value'];
                        $objValue = new UmlClassDiagramValue();
                        $objValue->setName( $strName );
                        $objValue->setValue( $strValue );

                        $objConnector->addValue( $objValue );
                    }

                    if( $objNote !== null )
                    {
                        $objConnector->addNoteBefore( $objNote );
                        $objNote = null;
                    }
                    
                    $arrConnectors[] = $objConnector;
                    break;
                }
                case "note":
                {            
                    $strPosition    = strtolower( (string) $xmlConnector[ 'position' ] );
                    $strClass       = (string) $xmlConnector[ 'class' ];
                    $strText        = (string) $xmlConnector[ 'text' ];
                    
                    $objNote = new UmlClassDiagramNote();
                    $objNote->setContent( $strText );
                    
                    if( $strClass !== "" )
                    {
                        if( !array_key_exists( $strClass , $arrClasses ) )
                        {
                            throw new Exception( ' Class To ' . $strTo . ' not Found ' );
                        }
                        $objClass = $arrClasses[ $strClass ];
                        $objNote->setClass( $objClass );
                    }

                    $objNote->setContent( $strText );
                    
                    if( $strPosition == "left" )
                    {
                        $objNote->setLeft( true );
                    }
                    else
                    {
                        $objNote->setRight( true );
                    }
                    
                    
                    if( $objConnector !== null )
                    {
                        $objConnector->addNoteAfter( $objNote );
                        $objNote = null;
                    }
                    break;
                }
                default:
                {
                    throw new Exception( 'invalid tag "' . $xmlConnector->getName()  . '" into tag Connectors' );
                    break;
                }
            }
        }
        $this->getUmlClassDiagram()->setConnectors( $arrConnectors );
    }
}
?>