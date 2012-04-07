<?php
/**
 * UmlClassDiagramClass - UML object of the Class diagram Class
 * @package UmlClassDiagram
 */

/**
 * Class of the object of the uml Class diagram object
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramClass
{
    /**
     * Uml Class Diagram parent of this Connector
     *
     * @var UmlClassDiagram
     */
    protected $objUmlClassDiagram;

    /**
     * Unique Id of each Class of the Class
     *
     * @var string
     */
    protected $strId;

    /**
     * Unique Position of each Class of the Class
     *
     * @var integer
     */
    protected $intPosition;

    /**
     * Type of the Class
     *
     * @var UmlClassDiagramClassStereotype
     */
    protected $objStereotype = null;

    /**
     * Position X of the class element
     * 
     * @var integer
     */
    protected $intX;
    
    /**
     * Position Y of the class element
     * 
     * @var integer
     */
    protected $intY;
    
    /**
     * Width of the class element
     * 
     * @var integer
     */
    protected $intWidth;
    
    /**
     * Height of the class element
     * 
     * @var integer
     */
    protected $intHeight;
    
    /**
     * Name of the Class
     *
     * @var string
     */
    protected $strName;

    /**
     * Class Methods
     * 
     * @var UmlClassDiagramMethod[]
     */
    protected $arrMethods = array();

    /**
     * Class Attributes
     * 
     * @var UmlClassDiagramAttribute[]
     */
    protected $arrAttribues = array();
    
    /**
     * Name of Default Stereotype 
     * 
     * @var string
     */
    protected static $strDefaultStereotype = "system";
    
    /**
     * Set the default type of the Class
     */
    public function __construct()
    {
        $this->setType( self::$strDefaultStereotype );
    }

    /**
     * Inform the uml Class diagram parent of the Class
     *
     * @see UmlClassDiagramClass::getUmlClassDiagram()
     * @see UmlClassDiagramClass->objUmlClassDiagram
     * @see UmlClassDiagram
     * @param UmlClassDiagram $objUmlClassDiagram
     * @return UmlClassDiagramClass me
     */
    public function setUmlClassDiagram( UmlClassDiagram $objUmlClassDiagram )
    {
        $this->objUmlClassDiagram = $objUmlClassDiagram;
        return $this;
    }

   /**
     * Returns the uml Class diagram parent of the Class
     *
     * @see UmlClassDiagramClass::setUmlClassDiagram( UmlClassDiagram )
     * @see UmlClassDiagramClass->objUmlClassDiagram
     * @see UmlClassDiagram
     * @return UmlClassDiagram
     */
     public function getUmlClassDiagram()
    {
        return $this->objUmlClassDiagram;
    }

    /**
     * Get the id of the Class
     *
     * @see UmlClassDiagramClass::setId( string )
     * @see UmlClassDiagramClass->strId
     * @return string
     */
    public function getId()
    {
        return $this->strId;
    }

    /**
     * Set the id of the Class
     *
     * @see UmlClassDiagramClass::getId()
     * @see UmlClassDiagramClass->strId
     * @return UmlClassDiagramClass
     */
    public function setId( $strId )
    {
        $this->strId = $strId;
        return $this;
    }

    /**
     * Get the position of the Class
     *
     * @see UmlClassDiagramClass::setPosition( integer )
     * @see UmlClassDiagramClass->intPosition
     * @return integer
     */
    public function getPosition()
    {
        return $this->intPosition;
    }

    /**
     * Set the position of the Class
     *
     * @see UmlClassDiagramClass::getPosition()
     * @see UmlClassDiagramClass->intPosition
     * @return UmlClassDiagramClass
     */
    public function setPosition( $intPosition )
    {
        $this->intPosition = $intPosition;
        return $this;
    }

    /**
     * Get the type of the Class
     *
     * @see UmlClassDiagramClass::setType( string )
     * @see UmlClassDiagramClass->objStereotype
     * @throws UmlClassDiagramException
     * @return string
     */
    public function getType()
    {
        if( $this->objStereotype == null )
        {
            throw new UmlClassDiagramException( "Type of Diagram Connector is not defined" );
        }
        
        return $this->objStereotype->getName();
    }

    /**
     * Set the type of the Class
     *
     * @see UmlClassDiagramClass::getType()
     * @see UmlClassDiagramClass->objStereotype
     * @return UmlClassDiagramClass
     * @throws UmlClassDiagramException
     */
    public function setType( $strType )
    {
        $this->objStereotype = UmlClassDiagramClassStereotype::getStereotypeByName( $strType );
    }

    /**
     * Set the stereotype of the Class
     *
     * @see UmlClassDiagramClass::getStereotype()
     * @see UmlClassDiagramClass->objStereotype
     * @return UmlClassDiagramClassStereotype
     */
    public function setStereotype( UmlClassDiagramClassStereotype $objStereotype )
    {
        return $this->objStereotype = $objStereotype;
    }

    /**
     * Get the stereotype of the Class
     *
     * @see UmlClassDiagramClass::setStereotype( UmlClassDiagramClassStereotype )
     * @see UmlClassDiagramClass->objStereotype
     * @return UmlClassDiagramClassStereotype
     */
    public function getStereotype()
    {
        return $this->objStereotype;
    }

    /**
     * Get the name of the Class
     *
     * @see UmlClassDiagramClass::setName( string )
     * @see UmlClassDiagramClass->strName
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the name of the Class
     *
     * @see UmlClassDiagramClass::getName()
     * @see UmlClassDiagramClass->strName
     * @return UmlClassDiagramClass
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
    }

    /**
     * Return the position X of the class element
     * 
     * @see UmlClassDiagramClass::setX( integer )
     * @see UmlClassDiagramClass->intX
     * @return integer
     */
    public function getX() {
        return $this->intX;
    }

    /**
     * Set the position X of the class element
     * 
     * @see UmlClassDiagramClass::getX()
     * @see UmlClassDiagramClass->intX
     * @param integer $intX 
     */
    public function setX($intX) {
        $this->intX = $intX;
    }

    /**
     * Return the position Y of the class element
     * 
     * @see UmlClassDiagramClass::setY( integer )
     * @see UmlClassDiagramClass->intY
     * @return integer
     */
    public function getY() {
        return $this->intY;
    }

    /**
     * Set the position Y of the class element
     * 
     * @see UmlClassDiagramClass::getY()
     * @see UmlClassDiagramClass->intY
     * @param integer $intY 
     */
    public function setY($intY) {
        $this->intY = $intY;
    }

    /**
     * Return the width of the class element
     * 
     * @see UmlClassDiagramClass::setWidth( integer )
     * @see UmlClassDiagramClass->intWidth
     * @return integer
     */
    public function getWidth() {
        return $this->intWidth;
    }

    /**
     * Inform the width of the class element
     * 
     * @see UmlClassDiagramClass::getWidth()
     * @see UmlClassDiagramClass->intWidth
     * @param integer $intWidth 
     */
    public function setWidth($intWidth) {
        $this->intWidth = $intWidth;
    }

    /**
     * Get the height of the class element
     * 
     * @see UmlClassDiagramClass::setHeight( integer )
     * @see UmlClassDiagramClass->intHeight
     * @return integer
     */
    public function getHeight() {
        return $this->intHeight;
    }

    /**
     * Inform the height of the class element
     * 
     * @see UmlClassDiagramClass::getHeight()
     * @see UmlClassDiagramClass->intHeight
     * @param integer $intHeight 
     */
    public function setHeight($intHeight) {
        $this->intHeight = $intHeight;
    }
    
    /**
     * Get the Class Methods
     * 
     * @return UmlClassDiagramAttribute[]
     */
    public function getMethods()
    {
        return $this->arrMethods;
    }
    
    /**
     * Add one method to the class
     * 
     * @param UmlClassDiagramMethod $objMethod 
     */
    public function addMethod( UmlClassDiagramMethod $objMethod )
    {
        $this->arrMethods[] = $objMethod;
    }
    
    /**
     * Get the Class Attributes
     * 
     * @return UmlClassDiagramAttribute[]
     */
    public function getAttributes()
    {
        return $this->arrAttribues;
    }
    
    /**
     * Add one attribute to the class
     * 
     * @param UmlClassDiagramAttribute $objAttribute 
     */
    public function addAttribute( UmlClassDiagramAttribute $objAttribute )
    {
        $this->arrAttribues[] = $objAttribute;
    }
}
?>