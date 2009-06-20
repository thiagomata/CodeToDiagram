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
     * Execution output
     * 
     * @var string 
     */
    protected $strOutput = "";

    /**
     * Restart Uml Sequence Object.
     * Clean all the old actors and messages
     * 
     * @return UmlSequenceDiagram me
     */
    public function restart()
    {
        $this->strOutput = "";
        $this->arrActors = array();
        $this->arrMessages = array();
        return $this;
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
        foreach( $arrMessages as $objMessage )
        {
            $this->addMessage( $objMessage );
        }
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
        foreach( $arrActors as $objActor )
        {
            $this->addActor( $objActor );
        }
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
        $this->arrActors[ $objActor->getId() ] = $objActor;
        $objActor->setPosition( sizeof( $this->arrActors ) );
        return $this;
    }

    /**
     * set the output of the execution
     *
     * @see UmlSequenceDiagram->strOutput
     * @see UmlSequenceDiagram::getOutput()
     * @param string $strOutput
     * @return UmlSequenceDiagram
     */
    public function setOutput( $strOutput )
    {
        $this->strOutput = $strOutput;
        return $this;
    }

    /**
     * get the output of the execution
     *
     * @see UmlSequenceDiagram->strOutput
     * @see UmlSequenceDiagram::setOutput( string )
     * @return string
     */
    public function getOutput()
    {
        return $this->strOutput;
    }
}
?>