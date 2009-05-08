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
     * @var string
     */
    protected $strType = 'system';

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
     * @see UmlSequenceDiagramActor->strType
     * @return string
     */
    public function getType()
    {
        return $this->strType;
    }

    /**
     * Set the type of the actor
     *
     * @see UmlSequenceDiagramActor::getType()
     * @see UmlSequenceDiagramActor->strType
     * @return UmlSequenceDiagramActor
     */
    public function setType($strType)
    {
        if( !in_array( $strType, Array( 'user' , 'system' ) ) )
        {
            throw new Exception( "Invalid type of user " . $strType );
        }

        $this->strType = $strType;
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