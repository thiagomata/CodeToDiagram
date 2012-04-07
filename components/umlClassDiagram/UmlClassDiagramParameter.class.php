<?php
/**
 * UmlClassDiagramParameter - UML Object of the Class Diagram Class Parameter
 *
 * Uml Class Diagramas have Classes what have Parameters
 * @package UmlClassDiagram
 */

/**
 * Object with the Parameters send into the Class
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramParameter
{
    /**
     * Name of the Parameter
     *
     * @var string
     */
    protected $strName;

    /**
     * Defautl value of the Parameter
     * 
     * @var string
     */
    protected $strValue;
    
    /**
     * Type of Parameter
     * 
     * string
     */
    protected $strType;
    
    protected static $strDefaultType =  'string';
    
    protected static $strDefaultValue =  null;
    
    /**
     * Visibility of the Parameter
     *
     * @var string
     */
    protected $strVisibility;

    public function __construct() 
    {
        $this->strType = self::$strDefaultType;
        $this->strValue = self::$strDefaultValue;
    }
    
    /**
     * Set the name of the Parameter
     *
     * @see UmlClassDiagramParameter::getName()
     * @see UmlClassDiagramParameter->strName
     * @param string $strName
     * @return UmlClassDiagramParameter me
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
        return $this;
    }

    /**
     * get the name of the Parameter
     *
     * @see UmlClassDiagramParameter::setName( string )
     * @see UmlClassDiagramParameter->strName
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    public function setValue( $strValue )
    {
        $this->strValue = $strValue;
    }
    
    public function getValue()
    {
        return $this->strValue;
    }
    
    public function setType( $strType )
    {
        $this->strType = $strType;
    }
    
    public function getType()
    {
        return $this->strType;
    }
}
?>