<?php
/**
 * UmlClassDiagramStereotype - Define the stereotypes of the uml Class
 * diagram
 */

/**
 * UmlClassDiagramStereotype define the stereotype of the actors into the
 * Class diagram object
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramStereotype
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
     * Array of the instances of the UmlClassDiagramStereotype
     * by the name
     * 
     * @var UmlClassDiagramStereotype[]
     */
    protected static $arrInstances = array();

    public static function addStereotype( UmlClassDiagramStereotype $objStereotype )
    {
        self::$arrInstances[ $objStereotype->getName()  ] = $objStereotype;
        return $objStereotype;
    }

    /**
     * Get the stereotype instance by the name
     *
     * @param string $strName
     * @return UmlClassDiagramStereotype
     */
    public static function getStereotypeByName( $strName )
    {
        if( !isset( self::$arrInstances[ $strName ] ) )
        {
            throw new UmlClassDiagramException( 'unknow uml Class diagram stereotype ' . $strName );
        }
        return self::$arrInstances[ $strName  ];
    }

    /**
     * Set if the stereotype it is default
     *
     * @see UmlClassDiagramStereotype->boolDefault
     * @see UmlClassDiagramStereotype::getDefault()
     * @param boolean $booDefault
     * @return UmlClassDiagramStereotype
     */
    public function setDefault( $booDefault )
    {
        $this->booDefault = $booDefault;
        return $this;
    }

    /**
     *
     * @see UmlClassDiagramStereotype->boolDefault
     * @see UmlClassDiagramStereotype::setDefault( boolean )
     * @return boolean $booDefault
     */
    public function getDefault()
    {
        return $this->booDefault;
    }

    /**
     *
     * @see UmlClassDiagramStereotype->strName
     * @see UmlClassDiagramStereotype::getName()
     * @param string $strName
     * @return UmlClassDiagramStereotype
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
        return $this;
    }

    /**
     * Get the name of the stereotype
     *
     * @see UmlClassDiagramStereotype->strName
     * @see UmlClassDiagramStereotype::setName( string )
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the image file name
     *
     * @see UmlClassDiagramStereotype->strImage
     * @see UmlClassDiagramStereotype->getImage()
     * @param string $strImage
     * @return UmlClassDiagramStereotype
     */
    public function setImage( $strImage )
    {
        $this->strImage = $strImage;
        return $this;
    }

    /**
     * Get the image file name
     *
     * @see UmlClassDiagramStereotype->strImage
     * @see UmlClassDiagramStereotype->setImage( string )
     * @return string $strImage
     */
    public function getImage()
    {
        return $this->strImage;
    }
}
?>
