<?php
/**
 * Actor of the object of the uml sequence diagram object
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @package XmlSequence
 */
class XmlSequenceActor
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
     * @see XmlSequenceActor::setId( integer )
     * @see XmlSequenceActor->intId
     * @return integer
     */
    public function getId()
    {
        return $this->intId;
    }

    /**
     * Set the id of the actor
     *
     * @see XmlSequenceActor::getId()
     * @see XmlSequenceActor->intId
     * @return XmlSequenceActor
     */
    public function setId( $intId )
    {
        $this->intId = $intId;
        return $this;
    }

    /**
     * Get the type of the actor
     *
     * @see XmlSequenceActor::setType( string )
     * @see XmlSequenceActor->strType
     * @return string
     */
    public function getType()
    {
        return $this->strType;
    }

    /**
     * Set the type of the actor
     *
     * @see XmlSequenceActor::getType()
     * @see XmlSequenceActor->strType
     * @return XmlSequenceActor
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
     * @see XmlSequenceActor::setName( string )
     * @see XmlSequenceActor->strName
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the name of the actor
     *
     * @see XmlSequenceActor::getName()
     * @see XmlSequenceActor->strName
     * @return XmlSequenceActor
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
    }

    /**
     * Get the class name of the actor
     *
     * @see XmlSequenceActor::setClassName( string )
     * @see XmlSequenceActor->strClassName
     * @return string
     */
    public function getClassName() {
        return $this->strClassName;
    }

    /**
     * Set the class name of the actor
     *
     * @see XmlSequenceActor::getClassName()
     * @see XmlSequenceActor->strClassName
     * @return XmlSequenceActor
     */
    public function setClassName($strClassName) {
        $this->strClassName = $strClassName;
    }
}

?>