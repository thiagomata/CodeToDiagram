<?php
/**
 * UmlSequenceDiagramMessage - Class with the UML description of the sequence diagram message
 * @package UmlSequenceDiagram
 */

/**
 * Message send between actors into the UmlSequenceDiagram object as the Sequence
 * Diagram UML guidelines append of more attributes as the code context make
 * usefull
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlSequenceDiagramMessage
{
    /**
     * Text of the message
     *
     * @var string
     */
    protected $strText = null;

    /**
     * Method of the message
     *
     * @var string
     */
    protected $strMethod = null;

    /**
     * Type of the actor
     *
     * @var UmlSequenceDiagramMessageStereotype
     */
    protected $objStereotype = null;

    /**
     * Actor what send the message
     *
     * @var UmlSequenceDiagramActor
     */
    protected $objActorFrom = null;

    /**
     * Actor what received the message
     *
     * @var UmlSequenceDiagramActor
     */
    protected $objActorTo = null;

    /**
     * Values of the message
     *
     * @var UmlSequenceDiagramValue[]
     */
    protected $arrValues = Array();

    /**
     * Timestamp when the message was received
     *
     * @var integer
     */
    protected $intTimeStart;

    /**
     * Timestamp when the message was finished
     *
     * @var integer
     */
    protected $intTimeEnd;

    /**
     * Unique Position of each message of the sequence
     * diagram
     *
     * @var integer
     */
    protected $intPosition;

    /**
     * Uml Sequence Diagram parent of this message
     *
     * @var UmlSequenceDiagram 
     */
    protected $objUmlSequenceDiagram;

    /**
     * UmlSequenceDiagramNote Collection
     * with the notes what should be before
     * the message
     *
     * @var UmlSequenceDiagramNote[]
     */
    protected $arrNotesBefore = array();

    /**
     * UmlSequenceDiagramNote Collection
     * with the notes what should be after
     * the message
     *
     * @var UmlSequenceDiagramNote[]
     */
    protected $arrNotesAfter = array();

    /**
     * Set the text of the message
     *
     * @see UmlSequenceDiagramMessage::getText()
     * @see UmlSequenceDiagramMessage->strText
     * @param string $strText
     * @return UmlSequenceDiagramMessage me
     */
    public function setText( $strText )
    {
        $this->strText = $strText;
        return $this;
    }

    /**
     * Get the text of the message
     *
     * @see UmlSequenceDiagramMessage::setText( string )
     * @see UmlSequenceDiagramMessage->strText
     * @return string
     */
    public function getText()
    {
        return $this->strText;
    }

    /**
     * Set the Method of the message
     *
     * @see UmlSequenceDiagramMessage::getMethod()
     * @see UmlSequenceDiagramMessage->strMethod
     * @param string $strMethod
     * @return UmlSequenceDiagramMessage me
     */
    public function setMethod( $strMethod )
    {
        $this->strMethod = $strMethod;
        return $this;
    }

    /**
     * Get the Method of the message
     *
     * @see UmlSequenceDiagramMessage::setMethod( string )
     * @see UmlSequenceDiagramMessage->strMethod
     * @return string
     */
    public function getMethod()
    {
        return $this->strMethod;
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
        $this->objType = UmlSequenceDiagramMessageStereotype::getStereotypeByName( $strType );
    }

    /**
     * Set the stereotype of the actor
     *
     * @return UmlSequenceDiagramMessageStereotype
     */
    public function setStereotype( UmlSequenceDiagramMessageStereotype $objStereotype )
    {
        return $this->objType = $objStereotype;
    }

    /**
     * Get the stereotype of the actor
     *
     * @return UmlSequenceDiagramMessageStereotype
     */
    public function getStereotype()
    {
        return $this->objType;
    }

    /**
     * Get the position of the message
     *
     * @see UmlSequenceDiagramMessage::setPosition( integer )
     * @see UmlSequenceDiagramMessage->intPosition
     * @return integer
     */
    public function getPosition()
    {
        return $this->intPosition;
    }

    /**
     * Set the position of the message
     *
     * @see UmlSequenceDiagramMessage::getPosition()
     * @see UmlSequenceDiagramMessage->intPosition
     * @return UmlSequenceDiagramMessage
     */
    public function setPosition( $intPosition )
    {
        $this->intPosition = $intPosition;
        return $this;
    }
    
    /**
     * Inform the actor who is the recipient of the message
     *
     * @see UmlSequenceDiagramMessage::getActorFrom()
     * @see UmlSequenceDiagramMessage->objActorFrom
     * @see UmlSequenceDiagramActor
     * @param UmlSequenceDiagramActor $objActor
     * @return UmlSequenceDiagramMessage me
     */
    public function setActorFrom( UmlSequenceDiagramActor $objActor )
    {
        $this->objActorFrom = $objActor;
        return $this;
    }

    /**
     * Returns the actor who is the recipient of the message
     *
     * @see UmlSequenceDiagramMessage::setActorFrom( UmlSequenceDiagramActor )
     * @see UmlSequenceDiagramMessage->objActorFrom
     * @see UmlSequenceDiagramActor
     * @return UmlSequenceDiagramActor
     */
     public function getActorFrom()
    {
        return $this->objActorFrom;
    }

    /**
     * Inform the actor who is the author of the message
     *
     * @see UmlSequenceDiagramMessage::getActorTo()
     * @see UmlSequenceDiagramMessage->objActorTo
     * @see UmlSequenceDiagramActor
     * @param UmlSequenceDiagramActor $objActor
     * @return UmlSequenceDiagramMessage me
     */
    public function setActorTo( UmlSequenceDiagramActor $objActor )
    {
        $this->objActorTo = $objActor;
        return $this;
    }

   /**
     * Returns the actor who is the author of the message
     *
     * @see UmlSequenceDiagramMessage::setActorTo( UmlSequenceDiagramActor )
     * @see UmlSequenceDiagramMessage->objActorTo
     * @see UmlSequenceDiagramActor
     * @return UmlSequenceDiagramActor
     */
     public function getActorTo()
    {
        return $this->objActorTo;
    }


    /**
     * Inform the uml sequence diagram parent of the message
     *
     * @see UmlSequenceDiagramMessage::getUmlSequenceDiagram()
     * @see UmlSequenceDiagramMessage->objUmlSequenceDiagram
     * @see UmlSequenceDiagram
     * @param UmlSequenceDiagram $objUmlSequenceDiagram
     * @return UmlSequenceDiagramMessage me
     */
    public function setUmlSequenceDiagram( UmlSequenceDiagram $objUmlSequenceDiagram )
    {
        $this->objUmlSequenceDiagram = $objUmlSequenceDiagram;
        return $this;
    }

   /**
     * Returns the uml sequence diagram parent of the message
     *
     * @see UmlSequenceDiagramMessage::setUmlSequenceDiagram( UmlSequenceDiagram )
     * @see UmlSequenceDiagramMessage->objUmlSequenceDiagram
     * @see UmlSequenceDiagram
     * @return UmlSequenceDiagram
     */
     public function getUmlSequenceDiagram()
    {
        return $this->objUmlSequenceDiagram;
    }

    /**
     * Set the array of values of the message
     *
     * @see UmlSequenceDiagramMessage::getValues()
     * @see UmlSequenceDiagramMessage->arrValues
     * @see UmlSequenceDiagramValue
     * @param UmlSequenceDiagramValue[] $arrValues
     * @return UmlSequenceDiagramMessage me
     */
    public function setValues( Array $arrValues )
    {
        $this->arrValues = $arrValues;
        return $this;
    }

    /**
     * Get the array of values of the message
     *
     * @see UmlSequenceDiagramMessage::setValues( UmlSequenceDiagramValue[] )
     * @see UmlSequenceDiagramMessage->arrValues
     * @see UmlSequenceDiagramValue
     * @return UmlSequenceDiagramValue[]
     */
    public function getValues()
    {
        return $this->arrValues;
    }

    /**
     * Append one UmlSequenceDiagramValue into the collection of Values of the
     * message
     *
     * @see UmlSequenceDiagramMessage::setValues( UmlSequenceDiagramValue[] )
     * @see UmlSequenceDiagramMessage->arrValues
     * @see UmlSequenceDiagramMessage::getValues()
     * @see UmlSequenceDiagramValue
     * @param UmlSequenceDiagramValue $objValue
     * @return UmlSequenceDiagramMessage me
     */
    public function addValue( UmlSequenceDiagramValue $objValue )
    {
        $this->arrValues[] = $objValue;
        return $this;
    }

    /**
     * Add a note before the message
     *
     * @param UmlSequenceDiagramNote $objNote
     * @return UmlSequenceDiagramMessage me
     */
    public function addNoteBefore( UmlSequenceDiagramNote $objNote )
    {
        $this->arrNotesBefore[] = $objNote;
        return $this;
    }

    /**
     * Set the notes what should be placed before the message
     *
     * @param array $arrNotesBefore
     * @return UmlSequenceDiagramMessage me
     */
    public function setNotesBefore( array $arrNotesBefore )
    {
        foreach( $arrNotesBefore as $objNote )
        {
            $this->addNoteBefore( $objNote );
        }
        return $this;
    }

    /**
     * Get the notes what should be placed before the message
     *
     * @return UmlSequenceDiagramNote[]
     */
    public function getNotesBefore()
    {
        return $this->arrNotesBefore;
    }


    /**
     * Add a note after the message
     *
     * @param UmlSequenceDiagramNote $objNote
     * @return UmlSequenceDiagramMessage me
     */
    public function addNoteAfter( UmlSequenceDiagramNote $objNote )
    {
        $this->arrNotesAfter[] = $objNote;
        return $this;
    }

    /**
     * Set the notes what should be placed after the message
     *
     * @param array $arrNotesAfter
     * @return UmlSequenceDiagramMessage me
     */
    public function setNotesAfter( array $arrNotesAfter )
    {
        foreach( $arrNotesAfter as $objNote )
        {
            $this->addNoteAfter( $objNote );
        }
        return $this;
    }

    /**
     * Get the notes what should be placed after the message
     *
     * @return UmlSequenceDiagramNote[]
     */
    public function getNotesAfter()
    {
        return $this->arrNotesAfter;
    }

    /**
     * Set the timestamp when the message started
     *
     * @see UmlSequenceDiagramMessage->intTimeStart
     * @see UmlSequenceDiagramMessage::getTimeStart()
     * @param integer $intTime
     * @return UmlSequenceDiagramMessage
     */
   public function setTimeStart( $intTime )
    {
        $this->intTimeStart = $intTime;
        return $this;
    }

    /**
     * Get the timestamp when the message started
     *
     * @see UmlSequenceDiagramMessage->intTimeStart
     * @see UmlSequenceDiagramMessage::setTimeStart( integer )
     * @return integer
     */
    public function getTimeStart()
    {
        return $this->intTimeStart;
    }

    /**
     * Set the timestamp when the message ends
     *
     * @see UmlSequenceDiagramMessage->intTimeEnds
     * @see UmlSequenceDiagramMessage::getTimeEnds()
     * @param integer $intTime
     * @return UmlSequenceDiagramMessage
     */
    public function setTimeEnd( $intTime )
    {
        $this->intTimeEnd = $intTime;
        return $this;
    }

    /**
     * Get the timestamp when the message ends
     *
     * @see UmlSequenceDiagramMessage->intTimeEnd
     * @see UmlSequenceDiagramMessage::setTimeEnd( integer )
     * @return integer
     */
    public function getTimeEnd()
    {
        return $this->intTimeEnd;
    }

    /**
     * Return the duration in timestamp betwenn the
     * start end end of the message
     *
     * @return integer
     */
    public function getTimeDuration()
    {
        return $this->intTimeEnd - $this->intTimeStart;
    }


    /**
     * Returns <code>true</code> if the position of the actor from is bigger then the
     * position of the actor to, <code>false</code> otherwise
     *
     * @return boolean
     */
    public function isReverse()
    {
        return ( $this->objActorFrom->getPosition() > $this->objActorTo->getPosition() );
    }


    /**
     * Returns <code>true</code> if the distance between the actor from and the
     * actor to be bigger then 1, <code>false</code> otherwise
     *
     * @return boolean
     */
    public function isLarge()
    {
        return ( abs( $this->objActorFrom->getPosition() - $this->objActorTo->getPosition() ) > 1 );
    }

    /**
     * Returns <code>true</code> if the actor from it is the actor to,
     * <code>false</code> otherwise
     *
     * @return boolean
     */
    public function isRecursive()
    {
        return( $this->objActorFrom->getPosition() == $this->objActorTo->getPosition() );
    }
}
?>