<?php
/**
 * UmlSequenceDiagramActor - UML object of the sequence diagram actor
 * @package UmlSequenceDiagram
 */

/**
 * Actor of the object of the uml sequence diagram object
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlSequenceDiagramActor
{

    /**
     * Uml Sequence Diagram parent of this message
     *
     * @var UmlSequenceDiagram
     */
    protected $objUmlSequenceDiagram;

    /**
     * Unique Id of each actor of the sequence
     *
     * @var string
     */
    protected $strId;

    /**
     * Unique Position of each actor of the sequence
     *
     * @var integer
     */
    protected $intPosition;

    /**
     * Type of the actor
     *
     * @var UmlSequenceDiagramStereotype
     */
    protected $objStereotype = null;

    /**
     * Name of the actor
     *
     * @var string
     */
    protected $strName;

    /**
     * Class of the object actor
     *
     * @var string
     */
    protected $strClassName;

    /**
     * Set the default type of the actor
     */
    public function __construct()
    {
        $this->setType( "system" );
    }

    /**
     * Inform the uml sequence diagram parent of the actor
     *
     * @see UmlSequenceDiagramActor::getUmlSequenceDiagram()
     * @see UmlSequenceDiagramActor->objUmlSequenceDiagram
     * @see UmlSequenceDiagram
     * @param UmlSequenceDiagram $objUmlSequenceDiagram
     * @return UmlSequenceDiagramActor me
     */
    public function setUmlSequenceDiagram( UmlSequenceDiagram $objUmlSequenceDiagram )
    {
        $this->objUmlSequenceDiagram = $objUmlSequenceDiagram;
        return $this;
    }

   /**
     * Returns the uml sequence diagram parent of the actor
     *
     * @see UmlSequenceDiagramActor::setUmlSequenceDiagram( UmlSequenceDiagram )
     * @see UmlSequenceDiagramActor->objUmlSequenceDiagram
     * @see UmlSequenceDiagram
     * @return UmlSequenceDiagram
     */
     public function getUmlSequenceDiagram()
    {
        return $this->objUmlSequenceDiagram;
    }

    /**
     * Get the id of the actor
     *
     * @see UmlSequenceDiagramActor::setId( string )
     * @see UmlSequenceDiagramActor->strId
     * @return string
     */
    public function getId()
    {
        return $this->strId;
    }

    /**
     * Set the id of the actor
     *
     * @see UmlSequenceDiagramActor::getId()
     * @see UmlSequenceDiagramActor->strId
     * @return UmlSequenceDiagramActor
     */
    public function setId( $strId )
    {
        $this->strId = $strId;
        return $this;
    }

    /**
     * Get the position of the actor
     *
     * @see UmlSequenceDiagramActor::setPosition( integer )
     * @see UmlSequenceDiagramActor->intPosition
     * @return integer
     */
    public function getPosition()
    {
        return $this->intPosition;
    }

    /**
     * Set the position of the actor
     *
     * @see UmlSequenceDiagramActor::getPosition()
     * @see UmlSequenceDiagramActor->intPosition
     * @return UmlSequenceDiagramActor
     */
    public function setPosition( $intPosition )
    {
        $this->intPosition = $intPosition;
        return $this;
    }

    /**
     * Get the type of the actor
     *
     * @see UmlSequenceDiagramActor::setType( string )
     * @see UmlSequenceDiagramActor->objStereotype
     * @return string
     */
    public function getType()
    {
        return $this->objType->getName();
    }

    /**
     * Set the type of the actor
     *
     * @see UmlSequenceDiagramActor::getType()
     * @see UmlSequenceDiagramActor->objType
     * @return UmlSequenceDiagramActor
     * @throws UmlSequenceDiagramException
     */
    public function setType( $strType )
    {
        $this->objType = UmlSequenceDiagramStereotype::getStereotypeByName( $strType );
    }

    /**
     * Set the stereotype of the actor
     *
     * @return UmlSequenceDiagramStereotype
     */
    public function setStereotype( UmlSequenceDiagramStereotype $objStereotype )
    {
        return $this->objType = $objStereotype;
    }

    /**
     * Get the stereotype of the actor
     *
     * @return UmlSequenceDiagramStereotype
     */
    public function getStereotype()
    {
        return $this->objType;
    }

    /**
     * Get the name of the actor
     *
     * @see UmlSequenceDiagramActor::setName( string )
     * @see UmlSequenceDiagramActor->strName
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the name of the actor
     *
     * @see UmlSequenceDiagramActor::getName()
     * @see UmlSequenceDiagramActor->strName
     * @return UmlSequenceDiagramActor
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
    }

    /**
     * Get the class name of the actor
     *
     * @see UmlSequenceDiagramActor::setClassName( string )
     * @see UmlSequenceDiagramActor->strClassName
     * @return string
     */
    public function getClassName() {
        return $this->strClassName;
    }

    /**
     * Set the class name of the actor
     *
     * @see UmlSequenceDiagramActor::getClassName()
     * @see UmlSequenceDiagramActor->strClassName
     * @return UmlSequenceDiagramActor
     */
    public function setClassName($strClassName) {
        $this->strClassName = $strClassName;
    }
}
?>