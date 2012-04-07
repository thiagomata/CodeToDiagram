<?php
/**
 * UmlClassDiagramAttribute - UML Object of the Class Diagram Class Attribute
 *
 * Uml Class Diagramas have Classes what have Attributes
 * @package UmlClassDiagram
 */

/**
 * Object with the Attributes send into the Class
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramAttribute
{
    /**
     * Name of the attribute
     *
     * @var string
     */
    protected $strName;

    protected $booFinal = false;
    
    protected $booStatic = false;
    
    protected $booAbstract = false;
    
    /**
     * Defautl value of the attribute
     * 
     * @var string
     */
    protected $strValue;
    
    /**
     * Type of Attribute
     * 
     * string
     */
    protected $strType;
    
    protected static $arrVisiblity = array(
        'private' ,
        'protected' ,
        'public' ,
        'package'
    );
    
    protected static $strDefaultVisibility =  'public';
    
    protected static $strDefaultType =  'string';
    
    protected static $strDefaultValue =  null;
    
    /**
     * Visibility of the attribute
     *
     * @var string
     */
    protected $strVisibility;

    public function __construct() 
    {
        $this->strVisibility = self::$strDefaultVisibility;
        $this->strType = self::$strDefaultType;
        $this->strValue = self::$strDefaultValue;
    }
    
    /**
     * Set the name of the Attribute
     *
     * @see UmlClassDiagramAttribute::getName()
     * @see UmlClassDiagramAttribute->strName
     * @param string $strName
     * @return UmlClassDiagramAttribute me
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
        return $this;
    }

    /**
     * get the name of the Attribute
     *
     * @see UmlClassDiagramAttribute::setName( string )
     * @see UmlClassDiagramAttribute->strName
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the Visibility
     *
     * @see UmlClassDiagramAttribute::getVisibility()
     * @see UmlClassDiagramAttribute->strVisibility
     * @param string $strVisibility
     * @return UmlClassDiagramAttribute me
     */
    public function setVisibility( $strVisibility )
    {
        if( !in_array( $strVisibility , self::$arrVisiblity ) )
        {
            throw new UmlClassDiagramException( 'Visibility "' . $strVisibility . '" is not valid.');
        }
        $this->strVisibility = $strVisibility;
        return $this;
    }

    /**
     * get the Visibility 
     *
     * @see UmlClassDiagramAttribute::setVisibility( string )
     * @see UmlClassDiagramAttribute->strVisibility
     * @return string
     */
    public function getVisibility()
    {
        return $this->strVisibility;
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
    
    public function setFinal( $booFinal = true )
    {
        $this->booFinal = $booFinal;
    }
    
    public function getFinal()
    {
        return $this->booFinal;
    }
    
    public function setStatic( $booStatic = true )
    {
        $this->booStatic = $booStatic;
    }
    
    public function getStatic()
    {
        return $this->booStatic;
    }
    
    public function setAbstract( $booAbstract = true )
    {
        $this->booAbstract = $booAbstract;
    }
    
    public function getAbstract()
    {
        return $this->booAbstract;
    }
}
?>