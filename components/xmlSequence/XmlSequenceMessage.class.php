<?php
/**
 * Message send between actors into the XmlSequence object as the Sequence
 * Diagram UML guidelines append of more attributes as the code context make
 * usefull
 */
class XmlSequenceMessage
{
    /**
     * Text of the message
     *
     * @var string
     */
    protected $strText = null;

    /**
     * Type of the message ( call or return )
     *
     * @var string
     */
    protected $strType = null;

    /**
     * Actor what send the message
     *
     * @var XmlSequenceActor
     */
    protected $objActorFrom = null;

    /**
     * Actor what received the message
     *
     * @var XmlSequenceActor
     */
    protected $objActorTo = null;

    /**
     * Values of the message
     *
     * @var XmlSequenceValue[]
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
     * Set the text of the message
     *
     * @see XmlSequenceMessage::getText()
     * @see XmlSequenceMessage->strText
     * @param string $strText
     * @return XmlSequenceMessage me
     */
    public function setText( $strText )
    {
        $this->strText = $strText;
        return $this;
    }

    /**
     * Get the text of the message
     * 
     * @see XmlSequenceMessage::setText( string )
     * @see XmlSequenceMessage->strText
     * @return string
     */
    public function getText()
    {
        return $this->strText;
    }

    /**
     * Set the type of the message
     *
     * @see XmlSequenceMessage::getType()
     * @see XmlSequenceMessage->strType
     * @param string $strType
     * @return XmlSequenceMessage me
     */
    public function setType( $strType )
    {
        if( !in_array( $strType, Array( 'call' , 'return' ) ) )
        {
            throw new Exception( "Invalid type of message " . $strType );
        }
        $this->strType = $strType;
        return $this;
    }

    /**
     * Get the type of the message
     *
     * @see XmlSequenceMessage::setType( string )
     * @see XmlSequenceMessage->strType
     * @return string
     */
    public function getType()
    {
        return $this->strType;
    }

    /**
     * Inform the actor who is the recipient of the message
     *
     * @see XmlSequenceMessage::getActorFrom()
     * @see XmlSequenceMessage->objActorFrom
     * @see XmlSequenceActor
     * @param XmlSequenceActor $objActor
     * @return XmlSequenceMessage me
     */
    public function setActorFrom( XmlSequenceActor $objActor )
    {
        $this->objActorFrom = $objActor;
        return $this;
    }

    /**
     * Returns the actor who is the recipient of the message
     *
     * @see XmlSequenceMessage::setActorFrom( XmlSequenceActor )
     * @see XmlSequenceMessage->objActorFrom
     * @see XmlSequenceActor
     * @return XmlSequenceActor
     */
     public function getActorFrom()
    {
        return $this->objActorFrom;
    }

    /**
     * Inform the actor who is the author of the message
     *
     * @see XmlSequenceMessage::getActorTo()
     * @see XmlSequenceMessage->objActorTo
     * @see XmlSequenceActor
     * @param XmlSequenceActor $objActor
     * @return XmlSequenceMessage me
     */
    public function setActorTo( XmlSequenceActor $objActor )
    {
        $this->objActorTo = $objActor;
        return $this;
    }

   /**
     * Returns the actor who is the author of the message
     *
     * @see XmlSequenceMessage::setActorTo( XmlSequenceActor )
     * @see XmlSequenceMessage->objActorTo
     * @see XmlSequenceActor
     * @return XmlSequenceActor
     */
     public function getActorTo()
    {
        return $this->objActorTo;
    }

    /**
     * Set the array of values of the message
     *
     * @see XmlSequenceMessage::getValues()
     * @see XmlSequenceMessage->arrValues
     * @see XmlSequenceValue
     * @param XmlSequenceValue[] $arrValues
     * @return XmlSequenceMessage me
     */
    public function setValues( Array $arrValues )
    {
        $this->arrValues = $arrValues;
        return $this;
    }

    /**
     * Get the array of values of the message
     *
     * @see XmlSequenceMessage::setValues( XmlSequenceValue[] )
     * @see XmlSequenceMessage->arrValues
     * @see XmlSequenceValue
     * @return XmlSequenceValue[]
     */
    public function getValues()
    {
        return $this->arrValues;
    }

    /**
     * Append one XmlSequenceValue into the collection of Values of the
     * message
     *
     * @see XmlSequenceMessage::setValues( XmlSequenceValue[] )
     * @see XmlSequenceMessage->arrValues
     * @see XmlSequenceMessage::getValues()
     * @see XmlSequenceValue
     * @param XmlSequenceValue $objValue
     */
    public function addValue( XmlSequenceValue $objValue )
    {
        $this->arrValues[] = $objValue;
    }

    /**
     * Set the timestamp when the message started
     *
     * @see XmlSequenceMessage->intTimeStart
     * @see XmlSequenceMessage::getTimeStart()
     * @param integer $intTime
     * @return XmlSequenceMessage
     */
   public function setTimeStart( $intTime )
    {
        $this->intTimeStart = $intTime;
        return $this;
    }

    /**
     * Get the timestamp when the message started
     *
     * @see XmlSequenceMessage->intTimeStart
     * @see XmlSequenceMessage::setTimeStart( integer )
     * @return integer
     */
    public function getTimeStart()
    {
        return $this->intTimeStart;
    }

    /**
     * Set the timestamp when the message ends
     *
     * @see XmlSequenceMessage->intTimeEnds
     * @see XmlSequenceMessage::getTimeEnds()
     * @param integer $intTime
     * @return XmlSequenceMessage
     */
    public function setTimeEnd( $intTime )
    {
        $this->intTimeEnd = $intTime;
        return $this;
    }

    /**
     * Get the timestamp when the message ends
     *
     * @see XmlSequenceMessage->intTimeEnd
     * @see XmlSequenceMessage::setTimeEnd( integer )
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
     * Returns <code>true</code> if the id of the actor from is bigger then the
     * id of the actor to, <code>false</code> otherwise
     *
     * @return boolean
     */
    public function isReverse()
    {
        return ( $this->objActorFrom->getId() > $this->objActorTo->getId() );
    }


    /**
     * Returns <code>true</code> if the distance between the actor from and the
     * actor to be bigger then 1, <code>false</code> otherwise
     *
     * @return boolean
     */
    public function isLarge()
    {
        return ( abs( $this->objActorFrom->getId() - $this->objActorTo->getId() ) > 1 );
    }

    /**
     * Returns <code>true</code> if the actor from it is the actor to,
     * <code>false</code> otherwise
     *
     * @return boolean
     */
    public function isRecursive()
    {
        return( $this->objActorFrom->getId() == $this->objActorTo->getId() );
    }
}
?>
