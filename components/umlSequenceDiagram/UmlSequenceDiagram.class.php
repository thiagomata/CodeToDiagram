<?php
/**
 * UmlSequenceDiagram - Uml Object of the sequence diagram diagram
 * @package UmlSequenceDiagram
 */

/**
 * Class what represent the UML sequence diagram
 * using the object oriented strutcture to do that
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlSequenceDiagram
{
    /**
     * Array of Uml Sequence Diagram Actors of the Uml Sequence Diagram object
     * 
     * @var UmlSequenceDiagramActor[]
     */
    protected $arrActors = Array();
    
	/**
	 * Array of Uml Sequence Diagram Messages of the Uml Sequence Diagram object
	 * 
	 * @var UmlSequenceDiagramMessage[]
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
     * Restart Uml Sequence Object.
     * Clean all the old actors and messages
     * 
     * @return UmlSequenceDiagram me
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
     * @see UmlSequenceDiagram::getCallerPath()
     * @see UmlSequenceDiagram->strCallerPath
     * @param string $strCallerPath
     * @return UmlSequenceDiagram me
     */
    public function setCallerPath( $strCallerPath )
    {
        $this->strCallerPath = $strCallerPath;
        return $this;
    }

    /**
     * Get the caller path
     * 
     * @see UmlSequenceDiagram::setCallerPath( string )
     * @see UmlSequenceDiagram->strCallerPath
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
     * @see UmlSequenceDiagram::getPublicrPath()
     * @see UmlSequenceDiagram->strPublicPath
     * @param string $strPublicPath
     * @return UmlSequenceDiagram me
     */
    public function setPublicPath( $strPublicPath )
    {
        $this->strPublicPath = $strPublicPath;
        return $this;
    }

    /**
     * Get the public path
     * 
     * @see UmlSequenceDiagram::setPublicPath( string )
     * @see UmlSequenceDiagram->strPublicPath
     * @param string $strPublicPath
     * @return string
     */
    public function getPublicPath()
    {
        return $this->strPublicPath;
    }

    /**
     * Set the array of Uml Sequence Diagram Messages
     * 
     * @see UmlSequenceDiagram::getMessages()
     * @see UmlSequenceDiagram->arrMessages
     * @see UmlSequenceDiagram::addMessage( UmlSequenceDiagramMessage )
     * @param array $arrMessages
     * @return UmlSequenceDiagram me
     */
    public function setMessages( array $arrMessages )
    {
        $this->arrMessages = $arrMessages;
        return $this;
    }

    /**
     * Get the array of Uml Sequence Diagram Messages
     * 
     * @see UmlSequenceDiagram::setMessages( UmlSequenceDiagramMessage[] )
     * @see UmlSequenceDiagram->arrMessages
     * @see UmlSequenceDiagram::addMessage( UmlSequenceDiagramMessage )
     * @return UmlSequenceDiagramMessage[]
     */
    public function getMessages()
    {
    	return $this->arrMessages;
    }
    
    /**
     * Add a message into the Uml Sequence Diagram Object
     * 
     * @see UmlSequenceDiagram::setMessages( UmlSequenceDiagramMessage[] )
     * @see UmlSequenceDiagram::getMessages()
     * @param UmlSequenceDiagramMessage $objMessage
     * @return UmlSequenceDiagram me
     */
    public function addMessage( UmlSequenceDiagramMessage $objMessage )
    {
        $this->arrMessages[] = $objMessage;
        return $this;
    }

    /**
     * Set the array of Uml Sequence Diagram Object
     * 
     * @see UmlSequenceDiagram::getActors()
     * @see UmlSequenceDiagram->arrActors
     * @see UmlSequenceDiagram::addActor( UmlSequenceDiagramMessage )
     * @param array $arrActors
     * @return UmlSequenceDiagram me
     */
    public function setActors( array $arrActors )
    {
        $this->arrActors = $arrActors;
        return $this;
    }

    /**
     * Get the array of Uml Sequence Diagram Object
     * 
     * @see UmlSequenceDiagram::setActors( UmlSequenceDiagramActor[] )
     * @see UmlSequenceDiagram->arrActors
     * @see UmlSequenceDiagram::addActor( UmlSequenceDiagramActor )
     * @return UmlSequenceDiagramActor[]
     */
    public function getActors()
    {
    	return $this->arrActors;
    }
    
    /**
     * Add a actor into the Uml Sequence Diagram Object
     * 
     * @see UmlSequenceDiagram::setActors( UmlSequenceDiagramActor[] )
     * @see UmlSequenceDiagram::getActors()
     * @param UmlSequenceDiagramActor $objActor
     * @return UmlSequenceDiagram me
     */    
    public function addActor( UmlSequenceDiagramActor $objActor )
    {
        $this->arrActors[] = $objActor;
        return $this;
    }
}
?>