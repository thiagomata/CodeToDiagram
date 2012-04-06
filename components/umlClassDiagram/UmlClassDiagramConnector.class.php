<?php
/**
 * UmlClassDiagramConnector - Class with the UML description of the Class diagram Connector
 * @package UmlClassDiagram
 */

/**
 * Connector send between Classes into the UmlClassDiagram object as the Class
 * Diagram UML guidelines append of more attributes as the code context make
 * usefull
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramConnector
{
    /**
     * Text of the Connector
     *
     * @var string
     */
    protected $strText = null;

    /**
     * Method of the Connector
     *
     * @var string
     */
    protected $strMethod = null;

    /**
     * Type of the Connector ( call or return )
     *
     * @var string
     */
    protected $strType = null;

    /**
     * Class what send the Connector
     *
     * @var UmlClassDiagramClass
     */
    protected $objClassFrom = null;

    /**
     * Class what received the Connector
     *
     * @var UmlClassDiagramClass
     */
    protected $objClassTo = null;

    /**
     * Timestamp when the Connector was received
     *
     * @var integer
     */
    protected $intTimeStart;

    /**
     * Timestamp when the Connector was finished
     *
     * @var integer
     */
    protected $intTimeEnd;

    /**
     * Unique Position of each Connector of the Class
     * diagram
     *
     * @var integer
     */
    protected $intPosition;

    /**
     * Uml Class Diagram parent of this Connector
     *
     * @var UmlClassDiagram 
     */
    protected $objUmlClassDiagram;

    /**
     * Type of the Class
     *
     * @var UmlClassDiagramConnectorStereotype
     */
    protected $objStereotype = null;
    
    /**
     * UmlClassDiagramNote Collection
     * with the notes what should be before
     * the Connector
     *
     * @var UmlClassDiagramNote[]
     */
    protected $arrNotesBefore = array();

    /**
     * UmlClassDiagramNote Collection
     * with the notes what should be after
     * the Connector
     *
     * @var UmlClassDiagramNote[]
     */
    protected $arrNotesAfter = array();

    /**
     * Name of Default Stereotype 
     * 
     * @var string
     */
    protected static $strDefaultStereotype = "association";
    
    /**
     * Set the default type of the Class
     */
    public function __construct()
    {
        $this->setType( self::$strDefaultStereotype );
    }
    
    /**
     * Set the text of the Connector
     *
     * @see UmlClassDiagramConnector::getText()
     * @see UmlClassDiagramConnector->strText
     * @param string $strText
     * @return UmlClassDiagramConnector me
     */
    public function setText( $strText )
    {
        $this->strText = $strText;
        return $this;
    }

    /**
     * Get the text of the Connector
     *
     * @see UmlClassDiagramConnector::setText( string )
     * @see UmlClassDiagramConnector->strText
     * @return string
     */
    public function getText()
    {
        return $this->strText;
    }

    /**
     * Set the Method of the Connector
     *
     * @see UmlClassDiagramConnector::getMethod()
     * @see UmlClassDiagramConnector->strMethod
     * @param string $strMethod
     * @return UmlClassDiagramConnector me
     */
    public function setMethod( $strMethod )
    {
        $this->strMethod = $strMethod;
        return $this;
    }

    /**
     * Get the Method of the Connector
     *
     * @see UmlClassDiagramConnector::setMethod( string )
     * @see UmlClassDiagramConnector->strMethod
     * @return string
     */
    public function getMethod()
    {
        return $this->strMethod;
    }

    /**
     * Get the position of the Connector
     *
     * @see UmlClassDiagramConnector::setPosition( integer )
     * @see UmlClassDiagramConnector->intPosition
     * @return integer
     */
    public function getPosition()
    {
        return $this->intPosition;
    }

    /**
     * Set the position of the Connector
     *
     * @see UmlClassDiagramConnector::getPosition()
     * @see UmlClassDiagramConnector->intPosition
     * @return UmlClassDiagramConnector
     */
    public function setPosition( $intPosition )
    {
        $this->intPosition = $intPosition;
        return $this;
    }
    
    /**
     * Inform the Class who is the recipient of the Connector
     *
     * @see UmlClassDiagramConnector::getClassFrom()
     * @see UmlClassDiagramConnector->objClassFrom
     * @see UmlClassDiagramClass
     * @param UmlClassDiagramClass $objClass
     * @return UmlClassDiagramConnector me
     */
    public function setClassFrom( UmlClassDiagramClass $objClass )
    {
        $this->objClassFrom = $objClass;
        return $this;
    }

    /**
     * Returns the Class who is the recipient of the Connector
     *
     * @see UmlClassDiagramConnector::setClassFrom( UmlClassDiagramClass )
     * @see UmlClassDiagramConnector->objClassFrom
     * @see UmlClassDiagramClass
     * @return UmlClassDiagramClass
     */
     public function getClassFrom()
    {
        return $this->objClassFrom;
    }

    /**
     * Inform the Class who is the author of the Connector
     *
     * @see UmlClassDiagramConnector::getClassTo()
     * @see UmlClassDiagramConnector->objClassTo
     * @see UmlClassDiagramClass
     * @param UmlClassDiagramClass $objClass
     * @return UmlClassDiagramConnector me
     */
    public function setClassTo( UmlClassDiagramClass $objClass )
    {
        $this->objClassTo = $objClass;
        return $this;
    }

   /**
     * Returns the Class who is the author of the Connector
     *
     * @see UmlClassDiagramConnector::setClassTo( UmlClassDiagramClass )
     * @see UmlClassDiagramConnector->objClassTo
     * @see UmlClassDiagramClass
     * @return UmlClassDiagramClass
     */
     public function getClassTo()
    {
        return $this->objClassTo;
    }


    /**
     * Inform the uml Class diagram parent of the Connector
     *
     * @see UmlClassDiagramConnector::getUmlClassDiagram()
     * @see UmlClassDiagramConnector->objUmlClassDiagram
     * @see UmlClassDiagram
     * @param UmlClassDiagram $objUmlClassDiagram
     * @return UmlClassDiagramConnector me
     */
    public function setUmlClassDiagram( UmlClassDiagram $objUmlClassDiagram )
    {
        $this->objUmlClassDiagram = $objUmlClassDiagram;
        return $this;
    }

   /**
     * Returns the uml Class diagram parent of the Connector
     *
     * @see UmlClassDiagramConnector::setUmlClassDiagram( UmlClassDiagram )
     * @see UmlClassDiagramConnector->objUmlClassDiagram
     * @see UmlClassDiagram
     * @return UmlClassDiagram
     */
     public function getUmlClassDiagram()
    {
        return $this->objUmlClassDiagram;
    }

    /**
     * Get the type of the Class
     *
     * @see UmlClassDiagramClass::setType( string )
     * @see UmlClassDiagramClass->objStereotype
     * @throws UmlClassDiagramException
     * @return string
     */
    public function getType()
    {
        if( $this->objStereotype == null )
        {
            throw new UmlClassDiagramException( "Type of Diagram Connector is not defined" );
        }
        return $this->objStereotype->getName();
    }

    /**
     * Set the type of the Class
     *
     * @see UmlClassDiagramClass::getType()
     * @see UmlClassDiagramClass->objStereotype
     * @return UmlClassDiagramClass
     * @throws UmlClassDiagramException
     */
    public function setType( $strType )
    {
        $this->objStereotype = UmlClassDiagramConnectorStereotype::getStereotypeByName( $strType );
    }

    /**
     * Set the stereotype of the Class
     *
     * @see UmlClassDiagramClass::getStereotype()
     * @see UmlClassDiagramClass->objStereotype
     * @return UmlClassDiagramConnectorStereotype
     */
    public function setStereotype( UmlClassDiagramConnectorStereotype $objStereotype )
    {
        return $this->objStereotype = $objStereotype;
    }

    /**
     * Get the stereotype of the Class
     *
     * @see UmlClassDiagramClass::setStereotype( UmlClassDiagramConnectorStereotype )
     * @see UmlClassDiagramClass->objStereotype
     * @return UmlClassDiagramConnectorStereotype
     */
    public function getStereotype()
    {
        return $this->objStereotype;
    }
    
    /**
     * Add a note before the Connector
     *
     * @see UmlClassDiagramConnector::setNotesBefore( UmlClassDiagramNote[] )
     * @see UmlClassDiagramConnector::getNotesBefore()
     * @see UmlClassDiagramConnector->arrNotesBefores
     * @see UmlClassDiagramNote
     * @param UmlClassDiagramNote $objNote
     * @return UmlClassDiagramConnector me
     */
    public function addNoteBefore( UmlClassDiagramNote $objNote )
    {
        $this->arrNotesBefore[] = $objNote;
        return $this;
    }

    /**
     * Set the notes what should be placed before the Connector
     *
     * @see UmlClassDiagramConnector::getNotesBefore()
     * @see UmlClassDiagramConnector->arrNotesBefores
     * @see UmlClassDiagramConnector::addNoteBefore( UmlClassDiagramNote )
     * @see UmlClassDiagramNote
     * @param array $arrNotesBefore
     * @return UmlClassDiagramConnector me
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
     * Get the notes what should be placed before the Connector
     *
     * @see UmlClassDiagramConnector::setNotesBefore( UmlClassDiagramNote[] )
     * @see UmlClassDiagramConnector::addNoteBefore( UmlClassDiagramNote )
     * @see UmlClassDiagramConnector->arrNotesBefores
     * @see UmlClassDiagramNote
     * @return UmlClassDiagramNote[]
     */
    public function getNotesBefore()
    {
        return $this->arrNotesBefore;
    }


    /**
     * Add a note after the Connector
     *
     * @param UmlClassDiagramNote $objNote
     * @return UmlClassDiagramConnector me
     */
    public function addNoteAfter( UmlClassDiagramNote $objNote )
    {
        $this->arrNotesAfter[] = $objNote;
        return $this;
    }

    /**
     * Set the notes what should be placed after the Connector
     *
     * @param array $arrNotesAfter
     * @return UmlClassDiagramConnector me
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
     * Get the notes what should be placed after the Connector
     *
     * @return UmlClassDiagramNote[]
     */
    public function getNotesAfter()
    {
        return $this->arrNotesAfter;
    }

    /**
     * Set the timestamp when the Connector started
     *
     * @see UmlClassDiagramConnector->intTimeStart
     * @see UmlClassDiagramConnector::getTimeStart()
     * @param integer $intTime
     * @return UmlClassDiagramConnector
     */
   public function setTimeStart( $intTime )
    {
        $this->intTimeStart = $intTime;
        return $this;
    }

    /**
     * Get the timestamp when the Connector started
     *
     * @see UmlClassDiagramConnector->intTimeStart
     * @see UmlClassDiagramConnector::setTimeStart( integer )
     * @return integer
     */
    public function getTimeStart()
    {
        return $this->intTimeStart;
    }

    /**
     * Set the timestamp when the Connector ends
     *
     * @see UmlClassDiagramConnector->intTimeEnds
     * @see UmlClassDiagramConnector::getTimeEnds()
     * @param integer $intTime
     * @return UmlClassDiagramConnector
     */
    public function setTimeEnd( $intTime )
    {
        $this->intTimeEnd = $intTime;
        return $this;
    }

    /**
     * Get the timestamp when the Connector ends
     *
     * @see UmlClassDiagramConnector->intTimeEnd
     * @see UmlClassDiagramConnector::setTimeEnd( integer )
     * @return integer
     */
    public function getTimeEnd()
    {
        return $this->intTimeEnd;
    }

    /**
     * Return the duration in timestamp betwenn the
     * start end end of the Connector
     *
     * @return integer
     */
    public function getTimeDuration()
    {
        return $this->intTimeEnd - $this->intTimeStart;
    }

    /**
     * Returns <code>true</code> if the distance between the Class from and the
     * Class to be bigger then 1, <code>false</code> otherwise
     *
     * @return boolean
     */
    public function isLarge()
    {
        return ( abs( $this->objClassFrom->getPosition() - $this->objClassTo->getPosition() ) > 1 );
    }

    /**
     * Returns <code>true</code> if the Class from it is the Class to,
     * <code>false</code> otherwise
     *
     * @return boolean
     */
    public function isRecursive()
    {
        return( $this->objClassFrom->getPosition() == $this->objClassTo->getPosition() );
    }
}
?>