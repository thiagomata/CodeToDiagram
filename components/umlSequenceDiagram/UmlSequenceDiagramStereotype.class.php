<?php
/**
 * UmlSequenceDiagramStereotype - Define the stereotypes of the uml sequence
 * diagram
 */

/**
 * UmlSequenceDiagramStereotype define the stereotype of the actors into the
 * sequence diagram object
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlSequenceDiagramStereotype
{
    /**
     * Flag to control if the element it is a default
     * stereotype <code> true </code> in this case
     * or a personalized one <code> false </code>
     * in this last case.
     *
     * @var boolean
     */
    protected $booDefault;

    /**
     * name of the stereotype
     *
     * @var string
     */
    protected $strName;

    /**
     * filename of the image of the
     * stereotype.
     *
     * @var string
     */
    protected $strImage;

    /**
     * Array of the instances of the UmlSequenceDiagramStereotype
     * by the name
     * 
     * @var UmlSequenceDiagramStereotype[]
     */
    protected static $arrInstances = array();

    public static function addStereotype( UmlSequenceDiagramStereotype $objStereotype )
    {
        self::$arrInstances[ $objStereotype->getName()  ] = $objStereotype;
        return $objStereotype;
    }

    /**
     * Get the stereotype instance by the name
     *
     * @param string $strName
     * @return UmlSequenceDiagramStereotype
     */
    public static function getStereotypeByName( $strName )
    {
        if( !isset( self::$arrInstances[ $strName ] ) )
        {
            throw new UmlSequenceDiagramException( 'unknow uml sequence diagram stereotype ' . $strName );
        }
        return self::$arrInstances[ $strName  ];
    }

    /**
     * Set if the stereotype it is default
     *
     * @see UmlSequenceDiagramStereotype->boolDefault
     * @see UmlSequenceDiagramStereotype::getDefault()
     * @param boolean $booDefault
     * @return UmlSequenceDiagramStereotype
     */
    public function setDefault( $booDefault )
    {
        $this->booDefault = $booDefault;
        return $this;
    }

    /**
     *
     * @see UmlSequenceDiagramStereotype->boolDefault
     * @see UmlSequenceDiagramStereotype::setDefault( boolean )
     * @return boolean $booDefault
     */
    public function getDefault()
    {
        return $this->booDefault;
    }

    /**
     *
     * @see UmlSequenceDiagramStereotype->strName
     * @see UmlSequenceDiagramStereotype::getName()
     * @param string $strName
     * @return UmlSequenceDiagramStereotype
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
        return $this;
    }

    /**
     * Get the name of the stereotype
     *
     * @see UmlSequenceDiagramStereotype->strName
     * @see UmlSequenceDiagramStereotype::setName( string )
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the image file name
     *
     * @see UmlSequenceDiagramStereotype->strImage
     * @see UmlSequenceDiagramStereotype->getImage()
     * @param string $strImage
     * @return UmlSequenceDiagramStereotype
     */
    public function setImage( $strImage )
    {
        $this->strImage = $strImage;
        return $this;
    }

    /**
     * Get the image file name
     *
     * @see UmlSequenceDiagramStereotype->strImage
     * @see UmlSequenceDiagramStereotype->setImage( string )
     * @return string $strImage
     */
    public function getImage()
    {
        return $this->strImage;
    }
}
?>
