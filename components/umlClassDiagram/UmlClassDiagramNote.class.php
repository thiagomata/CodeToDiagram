<?php
/**
 * UmlClassDiagramNote - Class with the UML description of the Class diagram note
 * @package UmlClassDiagram
 */

/**
 *
 * UmlClassDiagramNote append a note what helps to describe the
 * UmlClassDiagram
 *
 *
 * Notes help to describe some information about a slice of the diagram.
 * As with all UML Diagram, the Notes are shown in a rectangle with a
 * folder-olver corner.
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramNote
{
    /**
     * String with the content of the diagram note
     *
     * @var string
     */
    protected $strContent = "";

    /**
     * Flag to control if the line between the
     * Class and the note should be visible or
     * not
     *
     * @var boolean
     */
    protected $booShowLine = false;

    /**
     * Flag to control the position of the note
     * in relative to the Class. true is on the
     * left and false is on the right
     *
     * @var boolean
     */
    protected $booLeft = false;

    /**
     * 
     * Class what the note it is relative to
     *
     * @var UmlClassDiagramClass
     */
    protected $objClass;

    /**
     * Set the note content
     *
     * @param string $strContent
     * @return UmlClassDiagramNote
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
     * @return UmlClassDiagramNote
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
     * Set the Class what the note it is relative to
     *
     * @param UmlClassDiagramClass $objClass
     * @return UmlClassDiagramNote
     */
    public function setClass( UmlClassDiagramClass $objClass )
    {
        $this->objClass = $objClass;
        return $this;
    }

    /**
     * Get the Class what the note it is relative to
     *
     * @return UmlClassDiagramClass
     */
    public function getClass()
    {
        return $this->objClass;
    }

    /**
     * Put the note into the received Class
     *
     * @param UmlClassDiagramClass $objClass
     * @return UmlClassDiagramNote
     */
    public function putInOnClass( UmlClassDiagramClass $objClass )
    {
        $this->setClass( $objClass );
        $this->setRight( true );
        return $this;
    }

}
?>