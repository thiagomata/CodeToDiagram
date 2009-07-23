<?php
/**
 * UmlSequenceDiagramNote - Class with the UML description of the sequence diagram note
 * @package UmlSequenceDiagram
 */

/**
 *
 * UmlSequenceDiagramNote append a note what helps to describe the
 * UmlSequenceDiagram
 *
 *
 * Notes help to describe some information about a slice of the diagram.
 * As with all UML Diagram, the Notes are shown in a rectangle with a
 * folder-olver corner.
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlSequenceDiagramNote
{
    /**
     * String with the content of the diagram note
     *
     * @var string
     */
    protected $strContent = "";

    /**
     * Flag to control if the line between the
     * actor and the note should be visible or
     * not
     *
     * @var boolean
     */
    protected $booShowLine = false;

    /**
     * Flag to control the position of the note
     * in relative to the actor. true is on the
     * left and false is on the right
     *
     * @var boolean
     */
    protected $booLeft = true;

    /**
     * 
     * Actor what the note it is relative to
     *
     * @var UmlSequenceDiagramActor
     */
    protected $objActor;

    /**
     * Set the note content
     *
     * @param string $strContent
     * @return UmlSequenceDiagramNote
     */
    public function setContent( $strContent )
    {
        $this->strContent = (string)$strContent;
        return $this;
    }

    /**
     * Get the note content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->strContent;
    }

    /**
     * Set the show line option
     *
     * @param boolean $booShowLine
     * @return UmlSequenceDiagramNote
     */
    public function setShowLine( $booShowLine )
    {
        $this->booShowLine = (boolean) $booShowLine;
        return $this;
    }

    /**
     * Get the show line option
     *
     * @return boolean
     */
    public function getShowLine()
    {
        return $this->booShowLine;
    }

    /**
     * Set the actor what the note it is relative to
     *
     * @param UmlSequenceDiagramActor $objActor
     * @return UmlSequenceDiagramNote
     */
    public function setActor( UmlSequenceDiagramActor $objActor )
    {
        $this->objActor = $objActor;
        return $this;
    }

    /**
     * Get the actor what the note it is relative to
     *
     * @return UmlSequenceDiagramActor
     */
    public function getActor()
    {
        return $this->objActor;
    }

    /**
     * Set if the note should be in the left of the actor
     *
     * @param boolean $booLeft
     * @return UmlSequenceDiagramNote
     */
    public function setLeft( $booLeft )
    {
        $this->booLeft = (boolean)$booLeft;
        return $this;
    }

    /**
     * Get if the note should be in the left of the actor
     *
     * @return boolean
     */
    public function getLeft()
    {
        return $this->booLeft;
    }

    /**
     * Set if the note should be in the right of the actor
     *
     * @param boolean $booRight
     * @return UmlSequenceDiagramNote
     */
    public function setRight( $booRight )
    {
        $booRight = (boolean)$booRight;
        $booLeft = !$booRight;
        return $this->setLeft( $booLeft );
    }

    /**
     * Get if the note should be in the right of the actor
     *
     * @return boolean
     */
    public function getRight()
    {
        $booLeft = $this->getLeft();
        $booRight = !$booLeft;
        return $booRight;
    }

    /**
     * Put the note on the left of the received actor
     *
     * @param UmlSequenceDiagramActor $objActor
     * @return UmlSequenceDiagramNote
     */
    public function putInLeftOfActor( UmlSequenceDiagramActor $objActor )
    {
        $this->setActor( $objActor );
        $this->setLeft( true );
        return $this;
    }

    /**
     * Put the note on the right of the received actor
     *
     * @param UmlSequenceDiagramActor $objActor
     * @return UmlSequenceDiagramNote
     */
    public function putInRightOfActor( UmlSequenceDiagramActor $objActor )
    {
        $this->setActor( $objActor );
        $this->setRight( true );
        return $this;
    }

}
?>