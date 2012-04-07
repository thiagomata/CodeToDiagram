<?php
/**
 * UmlClassDiagramMethod - UML Object of the Class Diagram Class Method
 *
 * Uml Class Diagramas have Classes what have Methods
 * @package UmlClassDiagram
 */

/**
 * Object with the Methods send into the Class
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramMethod extends UmlClassDiagramAttribute
{
    /**
     * Method Parameters
     * @var UmlClassDiagramParameter[]
     */
    protected $arrParameters = array();
    
    public function addParameter( UmlClassDiagramParameter $objParam )
    {
        $this->arrParameters[] = $objParam;
    }
    
    public function setParameters( $arrParameters )
    {
        $this->arrParameters = $arrParameters;
    }
    
    public function getParameters()
    {
        return $this->arrParameters;
    }
}
?>