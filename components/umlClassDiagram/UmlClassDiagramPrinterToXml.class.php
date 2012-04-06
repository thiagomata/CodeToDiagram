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
            $strXmlClasses .= "\n\t\t\t";
            $strXmlClasses .= "<attributes>\n";

            $arrAttributes = $objClass->getAttributes();
            foreach($arrAttributes as $objAttribute )
            {
                /** @var $objAttribute UmlClassDiagramAttribute */
                $strXmlClasses .= "\t\t\t\t";
                $strXmlClasses .= "<attribute ";
                $strXmlClasses .= 'name = "' . $objAttribute->getName() . '" ';
                $strXmlClasses .= 'Attribute = "' . $objAttribute->getAttribute() . '" ';
                $strXmlClasses .= "/>\n";
            }

            $strXmlClasses .= "\t\t\t";
            $strXmlClasses .= "</attributes>\n";

            $strXmlClasses .= "\t\t\t";
            $strXmlClasses .= "<methods>\n";

            $arrmethods = $objClass->getmethods();
            foreach($arrmethods as $objmethod )
            {
                /** @var $objmethod UmlClassDiagrammethod */
                $strXmlClasses .= "\t\t\t\t";
                $strXmlClasses .= "<method ";
                $strXmlClasses .= 'name = "' . $objmethod->getName() . '" ';
                $strXmlClasses .= 'method = "' . $objmethod->getmethod() . '" ';
                $strXmlClasses .= "/>\n";
            }

            $strXmlClasses .= "\t\t\t";
            $strXmlClasses .= "</methods>\n";
            
            $strXmlClasses .= "\t\t</class>\n";
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