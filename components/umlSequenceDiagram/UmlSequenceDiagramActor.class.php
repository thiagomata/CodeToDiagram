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
     * Unique Id of each actor of the sequence
     *
     * @var integer
     */
    protected $intId;

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

    public function __construct()
    {
        $this->setType( "system" );
    }
    /**
     * Get the id of the actor
     *
     * @see UmlSequenceDiagramActor::setId( integer )
     * @see UmlSequenceDiagramActor->intId
     * @return integer
     */
    public function getId()
    {
        return $this->intId;
    }

    /**
     * Set the id of the actor
     *
     * @see UmlSequenceDiagramActor::getId()
     * @see UmlSequenceDiagramActor->intId
     * @return UmlSequenceDiagramActor
     */
    public function setId( $intId )
    {
        $this->intId = $intId;
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