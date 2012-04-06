<?php
/**
 * UmlSequenceDiagramMessageStereotype - Define the stereotypes of the uml sequence
 * diagram
 */

/**
 * UmlSequenceDiagramMessageStereotype define the stereotype of the actors into the
 * sequence diagram object
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlSequenceDiagramMessageStereotype
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
     * Array of the instances of the UmlSequenceDiagramMessageStereotype
     * by the name
     * 
     * @var UmlSequenceDiagramMessageStereotype[]
     */
    protected static $arrInstances = array();

    /**
     * array with the name of the default stereotypes
     *
     * @var string[]
     */
    protected static $arrDefaultStereotypes = array( 
        'call' , 
        'returnx'
    );
            
    /**
     * Load the default stereotype list
     */
    public static function loadDefaultStereotypes()
    {
        foreach( self::$arrDefaultStereotypes as $strDefaultStereotype )
        {
            $objStereotype = new UmlSequenceDiagramMessageStereotype();
            $objStereotype->setName( $strDefaultStereotype  )->setDefault( true );
            UmlSequenceDiagramMessageStereotype::addStereotype( $objStereotype );
        }
    }
    
    public static function addStereotype( UmlSequenceDiagramMessageStereotype $objStereotype )
    {
        self::$arrInstances[ $objStereotype->getName()  ] = $objStereotype;
        return $objStereotype;
    }

    /**
     * Get the stereotype instance by the name
     *
     * @param string $strName
     * @return UmlSequenceDiagramMessageStereotype
     */
    public static function getStereotypeByName( $strName )
    {
        if( !isset( self::$arrInstances[ $strName ] ) )
        {
            throw new UmlSequenceDiagramException( 'unknow uml sequence diagram stereotype "' . $strName . '".');
        }
        return self::$arrInstances[ $strName  ];
    }

    /**
     * Set if the stereotype it is default
     *
     * @see UmlSequenceDiagramMessageStereotype->boolDefault
     * @see UmlSequenceDiagramMessageStereotype::getDefault()
     * @param boolean $booDefault
     * @return UmlSequenceDiagramMessageStereotype
     */
    public function setDefault( $booDefault )
    {
        $this->booDefault = $booDefault;
        return $this;
    }

    /**
     *
     * @see UmlSequenceDiagramMessageStereotype->boolDefault
     * @see UmlSequenceDiagramMessageStereotype::setDefault( boolean )
     * @return boolean $booDefault
     */
    public function getDefault()
    {
        return $this->booDefault;
    }

    /**
     *
     * @see UmlSequenceDiagramMessageStereotype->strName
     * @see UmlSequenceDiagramMessageStereotype::getName()
     * @param string $strName
     * @return UmlSequenceDiagramMessageStereotype
     * @throws UmlSequenceDiagramException
     */
    public function setName( $strName )
    {
        foreach( self::$arrInstances as $objInstance )
        {
            if( $objInstance->getName() == $strName )
            {
                throw new UmlSequenceDiagramException( "Unique name " . $strName . " is in use, already." );
            }
        }
        $this->strName = $strName;
        return $this;
    }

    /**
     * Get the name of the stereotype
     *
     * @see UmlSequenceDiagramMessageStereotype->strName
     * @see UmlSequenceDiagramMessageStereotype::setName( string )
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the image file name
     *
     * @see UmlSequenceDiagramMessageStereotype->strImage
     * @see UmlSequenceDiagramMessageStereotype->getImage()
     * @param string $strImage
     * @return UmlSequenceDiagramMessageStereotype
     */
    public function setImage( $strImage )
    {
        $this->strImage = $strImage;
        return $this;
    }

    /**
     * Get the image file name
     *
     * @see UmlSequenceDiagramMessageStereotype->strImage
     * @see UmlSequenceDiagramMessageStereotype->setImage( string )
     * @return string $strImage
     */
    public function getImage()
    {
        return $this->strImage;
    }
}
?>
