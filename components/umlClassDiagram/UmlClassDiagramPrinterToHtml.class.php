<?php
/**
 * UmlClassDiagramPrinterToXml - Convert a UmlClassDiagram into a Xml
 * @package UmlClassDiagram
 */

/**
 * Generate a Xml from the Uml Class Diagram object
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class UmlClassDiagramPrinterToXml implements UmlClassDiagramPrinterInterface
{
   /**
    * Uml Class Diagram object what will be print
    * 
    * @see UmlClassDiagramPrinterInterface->objUmlClassDiagram
    * @var UmlClassDiagram
    */
    protected $objUmlClassDiagram;

   /**
    * Uml Class Diagram Printer Configuration To Xml
    *
    * @todo Create the class configuration to the xml
    * @var UmlClassDiagramPrinterConfigurationToXml
    */
    protected $objConfiguration;

   /**
    * Singleton of the UmlClassDiagramPrinterToXml
    * 
    * @see UmlClassDiagramPrinterInterface::$objInstance
    * @var UmlClassDiagramPrinterToXml
    */
    protected static $objInstance;	

   /**
    * Return the singleton of the UmlClassDiagramPrinterToXml
    * 
    * @see UmlClassDiagramPrinterInterface::getInstance
    * @return UmlClassDiagramPrinterToXml
    */
    public static function getInstance()
    {
        if( self::$objInstance == null )
        {
                self::$objInstance = new UmlClassDiagramPrinterToXml();
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
    * @see UmlClassDiagramPrinterInterface::perform( UmlClassDiagram )
    * @param UmlClassDiagram $objUmlClassDiagram
    * @return mixer
    */
    public function perform( UmlClassDiagram $objUmlClassDiagram )
    {
            $this->objUmlClassDiagram = $objUmlClassDiagram;
            return $this->createXml();	
    }

    /**
     * Create and return the xml of the Class diagram object
     *
     * @see UmlClassDiagramPrinterToXml::createXmlHeader()
     * @see UmlClassDiagramPrinterToXml::createXmlClasses()
     * @see UmlClassDiagramPrinterToXml::createXmlFooter()
     * @return string
     */
    public function createXml()
    {
        $strXml = '';
        $strXml .= $this->createXmlHeader();
        $strXml .= $this->createXmlClasses();
        $strXml .= $this->createXmlConnectors();
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
        return "<classdiagram>\n";
    }

    /**
     * Create and return the footer slice of the xml
     *
     * @return string
     */
    public function createXmlFooter()
    {
        return "</classdiagram>\n";
    }

    /**
     * Create and return the Classes slice of the xml
     *
     * @return string
     */
    public function createXmlClasses()
    {
    	$arrClasses = $this->objUmlClassDiagram->getClasses();
    	
        $strXmlClasses = "\t<classes>\n";
        foreach( $arrClasses as $objClass )
        {
            /** @var $objClass UmlClassDiagramClass */
            $strXmlClasses .= "\t\t";
            $strXmlClasses .= "<class ";
            $strXmlClasses .= 'id="' . $objClass->getId() . '" ';
            $strXmlClasses .= 'type="' . $objClass->getType() . '" ';
            $strXmlClasses .= 'name="' . $objClass->getName() . '" ';
            $strXmlClasses .= '>';
  
            $arrAttributes = $objClass->getAttributes();
            if( sizeof( $arrAttributes ) > 0 )
            {
                $strXmlClasses .= "\n\t\t\t";
                $strXmlClasses .= "<attributes>\n";
                
                foreach($arrAttributes as $objAttribute )
                {
                    /** @var $objAttribute UmlClassDiagramAttribute */
                    $strXmlClasses .= "\t\t\t\t";
                    $strXmlClasses .= "<attribute ";
                    $strXmlClasses .= 'name="' . $objAttribute->getName() . '" ';
                    $strXmlClasses .= 'type="' . $objAttribute->getType() . '" ';
                    $strXmlClasses .= 'visibility="' . $objAttribute->getVisibility() . '" ';
                    if( $objAttribute->getValue() != "" )
                    {
                        $strXmlClasses .= 'value="' . $objAttribute->getValue() . '" ';
                    }
                    if( $objAttribute->getFinal() )
                    {
                        $strXmlClasses .= 'final="true" ';                
                    }
                    if( $objAttribute->getStatic() )
                    {
                        $strXmlClasses .= 'static="true" ';                
                    }
                    if( $objAttribute->getAbstract() )
                    {
                        $strXmlClasses .= 'abstract="true" ';                
                    }
                    $strXmlClasses .= "/>\n";
                }
                $strXmlClasses .= "\t\t\t";
                $strXmlClasses .= "</attributes>";
            }
            
            $arrMethods = $objClass->getmethods();
            if( sizeof( $arrMethods ) > 0 )
            {
                $strXmlClasses .= "\n\t\t\t";
                $strXmlClasses .= "<methods>\n";
                foreach($arrMethods as $objMethod )
                {
                    /** @var $objmethod UmlClassDiagrammethod */
                    $strXmlClasses .= "\t\t\t\t";
                    $strXmlClasses .= "<method ";
                    $strXmlClasses .= 'name="' . $objMethod->getName() . '" ';
                    $strXmlClasses .= 'type="' . $objMethod->getType() . '" ';
                    $strXmlClasses .= 'visibility="' . $objMethod->getVisibility() . '" ';
                    if( $objMethod->getValue() != "" )
                    {
                        $strXmlClasses .= 'value="' . $objMethod->getValue() . '" ';
                    }
                    if( $objMethod->getFinal() )
                    {
                        $strXmlClasses .= 'final="true" ';                
                    }
                    if( $objMethod->getStatic() )
                    {
                        $strXmlClasses .= 'static="true" ';                
                    }
                    if( $objMethod->getAbstract() )
                    {
                        $strXmlClasses .= 'abstract="true" ';                
                    }
                    $strXmlClasses .= ">";

                    $arrParameters = $objMethod->getParameters();
                    if( sizeof( $arrParameters ) > 0 )
                    {
                        $strXmlClasses .= "\n\t\t\t\t\t";
                        $strXmlClasses .= "<parameters>\n";

                        foreach($arrParameters as $objParameter )
                        {
                            /** @var $objParameter UmlClassDiagramParameter */
                            $strXmlClasses .= "\t\t\t\t\t\t";
                            $strXmlClasses .= "<parameter ";
                            $strXmlClasses .= 'name="' . $objParameter->getName() . '" ';
                            $strXmlClasses .= 'type="' . $objParameter->getType() . '" ';
                            if( $objParameter->getValue() != "" )
                            {
                                $strXmlClasses .= 'value="' . $objParameter->getValue() . '" ';
                            }
                            $strXmlClasses .= "/>\n";
                        }
                        $strXmlClasses .= "\t\t\t\t\t";
                        $strXmlClasses .= "</parameters>";
                    }
                    
                    
                    
                    $strXmlClasses .= "\n\t\t\t\t";
                    $strXmlClasses .= "</method>\n";
                }
                $strXmlClasses .= "\t\t\t";
                $strXmlClasses .= "</methods>";
                $strXmlClasses .= "\n\t\t";
            }

            
            $strXmlClasses .= "</class>\n";
        }
        $strXmlClasses .= "\t</classes>\n";
        return $strXmlClasses;
    }

    /**
     * Create and return the Connectors slice of the xml
     *
     * @return string
     */
    public function createXmlConnectors()
    {
    	$arrConnectors = $this->objUmlClassDiagram->getConnectors();
    	
    	$strXmlConnectors = "\t<connectors>\n";
        foreach( $arrConnectors as $objConnector )
        {
            /** @var $objConnector UmlClassDiagramConnector */

            $arrNotes = $objConnector->getNotesBefore();
            foreach( $arrNotes as $objNote )
            {
                /** @var $objNote UmlClassDiagramNote */
                $strXmlConnectors .= "\t\t";
                $strXmlConnectors .= "<note ";
                $strXmlConnectors .= 'position="' . $objNote->getLeft() ? 'left' : 'right' . '" ';
                $strXmlConnectors .= 'Class="' . $objNote->getClass() . '" ';
                $strXmlConnectors .= 'text="' . $objNote->getContent() . '" ';
                $strXmlConnectors .= '/>' . "\n";
            }
            
            $strXmlConnectors .= "\t\t";
            $strXmlConnectors .= "<connector ";
            $strXmlConnectors .= 'type="' . $objConnector->getType() . '" ';
            $strXmlConnectors .= 'from="' . $objConnector->getClassFrom()->getId() . '" ';
            $strXmlConnectors .= 'to="' . $objConnector->getClassTo()->getId() . '" ';
            $strXmlConnectors .= 'text="' . htmlentities( $objConnector->getText() ) . '" ';
            $strXmlConnectors .= '>' . "\n";

            $arrNotes = $objConnector->getNotesAfter();
            foreach( $arrNotes as $objNote )
            {
                /** @var $objNote UmlClassDiagramNote */
                $strXmlConnectors .= "\t\t";
                $strXmlConnectors .= "<note ";
                $strXmlConnectors .= 'position="' . $objNote->getLeft() ? 'left' : 'right' . '" ';
                $strXmlConnectors .= 'Class="' . $objNote->getClass() . '" ';
                $strXmlConnectors .= 'text="' . $objNote->getContent() . '" ';
                $strXmlConnectors .= '/>' . "\n";
            }
            
            $strXmlConnectors .= "\t\t";
            $strXmlConnectors .= "</connector>\n";
        }
    	
        $strXmlConnectors .= "\t</connectors>\n";
        return $strXmlConnectors;
    }

    /**
     * @todo Create the configuration class to the xml printer
     * @todo use the configuration class of the xml printer
     */
    public function setConfiguration( UmlClassDiagramPrinterConfigurationInterface $objConfiguration )
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