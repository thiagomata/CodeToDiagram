<?php
/**
 * UmlClassDiagram - Uml Object of the Class diagram diagram
 * @package UmlClassDiagram
 */

/**
 * Class what represent the UML Class diagram
 * using the object oriented strutcture to do that
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagram
{
    /**
     * Array of Uml Class Diagram Classes of the Uml Class Diagram object
     * 
     *  @var UmlClassDiagramClass[]
     */
    protected $arrClasses = Array();
    
	/**
	 * Array of Uml Class Diagram Connectors of the Uml Class Diagram object
	 * 
	 * @var UmlClassDiagramConnector[]
	 */    
    protected $arrConnectors = Array();

    /**
     * Execution output
     * 
     * @var string 
     */
    protected $strOutput = "";

    public function loadDefaultStereotypes()
    {
        UmlClassDiagramClassStereotype::loadDefaultStereotypes();
        UmlClassDiagramConnectorStereotype::loadDefaultStereotypes();
    }    
    
    /**
     * Restart Uml Class Object.
     * Clean all the old Classes and Connectors
     * 
     * @return UmlClassDiagram me
     */
    public function restart()
    {
        $this->strOutput = "";
        $this->arrClasses = array();
        $this->arrConnectors = array();
        return $this;
    }

    /**
     * Set the array of Uml Class Diagram Connectors
     * 
     * @see UmlClassDiagram::getConnectors()
     * @see UmlClassDiagram->arrConnectors
     * @see UmlClassDiagram::addConnector( UmlClassDiagramConnector )
     * @param array $arrConnectors
     * @return UmlClassDiagram me
     */
    public function setConnectors( array $arrConnectors )
    {
        foreach( $arrConnectors as $objConnector )
        {
            $this->addConnector( $objConnector );
        }
        return $this;
    }

    /**
     * Get the array of Uml Class Diagram Connectors
     * 
     * @see UmlClassDiagram::setConnectors( UmlClassDiagramConnector[] )
     * @see UmlClassDiagram->arrConnectors
     * @see UmlClassDiagram::addConnector( UmlClassDiagramConnector )
     * @return UmlClassDiagramConnector[]
     */
    public function getConnectors()
    {
    	return $this->arrConnectors;
    }
    
    /**
     * Add a Connector into the Uml Class Diagram Object
     * 
     * @see UmlClassDiagram::setConnectors( UmlClassDiagramConnector[] )
     * @see UmlClassDiagram::getConnectors()
     * @param UmlClassDiagramConnector $objConnector
     * @return UmlClassDiagram me
     */
    public function addConnector( UmlClassDiagramConnector $objConnector )
    {
        $this->arrConnectors[] = $objConnector;
        $objConnector->setPosition( sizeof( $this->arrConnectors ) );
        $objConnector->setUmlClassDiagram( $this );
        return $this;
    }

    /**
     * Set the array of Uml Class Diagram Object
     * 
     * @see UmlClassDiagram::getClasses()
     * @see UmlClassDiagram->arrClasses
     * @see UmlClassDiagram::addClass( UmlClassDiagramConnector )
     * @param array $arrClasses
     * @return UmlClassDiagram me
     */
    public function setClasses( array $arrClasses )
    {
        foreach( $arrClasses as $objClass )
        {
            $this->addClass( $objClass );
        }
        return $this;
    }

    /**
     * Get the array of Uml Class Diagram Object
     * 
     * @see UmlClassDiagram::setClasses( UmlClassDiagramClass[] )
     * @see UmlClassDiagram->arrClasses
     * @see UmlClassDiagram::addClass( UmlClassDiagramClass )
     * @return UmlClassDiagramClass[]
     */
    public function getClasses()
    {
    	return $this->arrClasses;
    }
    
    /**
     * Add a Class into the Uml Class Diagram Object
     * 
     * @see UmlClassDiagram::setClasses( UmlClassDiagramClass[] )
     * @see UmlClassDiagram::getClasses()
     * @param UmlClassDiagramClass $objClass
     * @return UmlClassDiagram me
     */    
    public function addClass( UmlClassDiagramClass $objClass )
    {
        $this->arrClasses[ $objClass->getId() ] = $objClass;
        $objClass->setPosition( sizeof( $this->arrClasses ) );
        $objClass->setUmlClassDiagram( $this );
        return $this;
    }

    /**
     * set the output of the execution
     *
     * @see UmlClassDiagram->strOutput
     * @see UmlClassDiagram::getOutput()
     * @param string $strOutput
     * @return UmlClassDiagram
     */
    public function setOutput( $strOutput )
    {
        $this->strOutput = $strOutput;
        return $this;
    }

    /**
     * get the output of the execution
     *
     * @see UmlClassDiagram->strOutput
     * @see UmlClassDiagram::setOutput( string )
     * @return string
     */
    public function getOutput()
    {
        return $this->strOutput;
    }
}
?>