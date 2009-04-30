<?php
/**
 * XmlSequence - Uml Object of the sequence diagram
 * @package XmlSequence
 */

/**
 * Class what represent the UML sequence diagram
 * using the object oriented strutcture to do that
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class XmlSequence
{
    /**
     * Array of Xml Sequence Actors of the Xml Sequence object
     * 
     * @var XmlSequenceActor[]
     */
    protected $arrActors = Array();
    
	/**
	 * Array of Xml Sequence Messages of the Xml Sequence object
	 * 
	 * @var XmlSequenceMessage[]
	 */    
    protected $arrMessages = Array();

    /**
     * Path of the caller file
     * @var string
     */
    protected $strCallerPath;
    
    /**
     * Path of the public folder
     * @var string
     */
    protected $strPublicPath;

    /**
     * Restart xml sequence clean all the old actors and messages
     * 
     * @return XmlSequence me
     */
    public function restart()
    {
        $this->arrActors = array();
        $this->arrMessages = array();
        return $this;
    }

    /**
     * Set the caller path
     * 
     * @see XmlSequence::getCallerPath()
     * @see XmlSequence->strCallerPath
     * @param string $strCallerPath
     * @return XmlSequence me
     */
    public function setCallerPath( $strCallerPath )
    {
        $this->strCallerPath = $strCallerPath;
        return $this;
    }

    /**
     * Get the caller path
     * 
     * @see XmlSequence::setCallerPath( string )
     * @see XmlSequence->strCallerPath
     * @param string $strCallerPath
     * @return string
     */
    public function getCallerPath()
    {
        return $this->strCallerPath;
    }

    /**
     * Set the public path
     * 
     * @see XmlSequence::getPublicrPath()
     * @see XmlSequence->strPublicPath
     * @param string $strPublicPath
     * @return XmlSequence me
     */
    public function setPublicPath( $strPublicPath )
    {
        $this->strPublicPath = $strPublicPath;
        return $this;
    }

    /**
     * Get the public path
     * 
     * @see XmlSequence::setPublicPath( string )
     * @see XmlSequence->strPublicPath
     * @param string $strPublicPath
     * @return string
     */
    public function getPublicPath()
    {
        return $this->strPublicPath;
    }

    /**
     * Set the array of xml sequence messages
     * 
     * @see XmlSequence::getMessages()
     * @see XmlSequence->arrMessages
     * @see XmlSequence::addMessage( XmlSequenceMessage )
     * @param array $arrMessages
     * @return XmlSequence me
     */
    public function setMessages( array $arrMessages )
    {
        $this->arrMessages = $arrMessages;
        return $this;
    }

    /**
     * Get the array of xml sequence messages
     * 
     * @see XmlSequence::setMessages( XmlSequenceMessage[] )
     * @see XmlSequence->arrMessages
     * @see XmlSequence::addMessage( XmlSequenceMessage )
     * @return XmlSequenceMessage[]
     */
    public function getMessages()
    {
    	return $this->arrMessages;
    }
    
    /**
     * Add a message into the xml sequence object
     * 
     * @see XmlSequence::setMessages( XmlSequenceMessage[] )
     * @see XmlSequence::getMessages()
     * @param XmlSequenceMessage $objMessage
     * @return XmlSequence me
     */
    public function addMessage( XmlSequenceMessage $objMessage )
    {
        $this->arrMessages[] = $objMessage;
        return $this;
    }

    /**
     * Set the array of xml sequence actors
     * 
     * @see XmlSequence::getActors()
     * @see XmlSequence->arrActors
     * @see XmlSequence::addActor( XmlSequenceMessage )
     * @param array $arrActors
     * @return XmlSequence me
     */
    public function setActors( array $arrActors )
    {
        $this->arrActors = $arrActors;
        return $this;
    }

    /**
     * Get the array of xml sequence actors
     * 
     * @see XmlSequence::setActors( XmlSequenceActor[] )
     * @see XmlSequence->arrActors
     * @see XmlSequence::addActor( XmlSequenceActor )
     * @return XmlSequenceActor[]
     */
    public function getActors()
    {
    	return $this->arrActors;
    }
    
    /**
     * Add a actor into the xml sequence object
     * 
     * @see XmlSequence::setActors( XmlSequenceActor[] )
     * @see XmlSequence::getActors()
     * @param XmlSequenceActor $objActor
     * @return XmlSequence me
     */    
    public function addActor( XmlSequenceActor $objActor )
    {
        $this->arrActors[] = $objActor;
        return $this;
    }

}

?>
