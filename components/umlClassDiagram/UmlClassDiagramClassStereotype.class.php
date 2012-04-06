<?php
/**
 * UmlClassDiagramClassStereotype - Define the stereotypes of the uml Class
 * diagram
 */

/**
 * UmlClassDiagramClassStereotype define the stereotype of the classes into the
 * Class diagram object
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramClassStereotype
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
     * Array of the instances of the UmlClassDiagramClassStereotype
     * by the name
     * 
     * @var UmlClassDiagramClassStereotype[]
     */
    protected static $arrInstances = array();

    /**
     * array with the name of the default stereotypes
     *
     * @var string[]
     */
    protected static $arrDefaultStereotypes = array( 
        'user' , 
        'system' ,
        'entity' , 
        'controller' , 
        'boundary' , 
        'database' ,
        'abstract' , 
        'general' ,
        'interface'
    );

    
    /**
     * Load the default stereotype list
     */
    public static function loadDefaultStereotypes()
    {
        foreach( self::$arrDefaultStereotypes as $strDefaultStereotype )
        {
            $objStereotype = new UmlClassDiagramClassStereotype();
            $objStereotype->setName( $strDefaultStereotype  )->setDefault( true );
            UmlClassDiagramClassStereotype::addStereotype( $objStereotype );
        }
    }
    
    public static function addStereotype( UmlClassDiagramClassStereotype $objStereotype )
    {
        self::$arrInstances[ $objStereotype->getName()  ] = $objStereotype;
        return $objStereotype;
    }

    /**
     * Get the stereotype instance by the name
     *
     * @param string $strName
     * @return UmlClassDiagramClassStereotype
     */
    public static function getStereotypeByName( $strName )
    {
        CorujaDebug::debug( self::$arrInstances  );
        if( !isset( self::$arrInstances[ $strName ] ) )
        {
            throw new UmlClassDiagramException( 'unknow uml Class diagram stereotype "' . $strName . '".');
        }
        return self::$arrInstances[ $strName  ];
    }

    /**
     * Set if the stereotype it is default
     *
     * @see UmlClassDiagramClassStereotype->boolDefault
     * @see UmlClassDiagramClassStereotype::getDefault()
     * @param boolean $booDefault
     * @return UmlClassDiagramClassStereotype
     */
    public function setDefault( $booDefault )
    {
        $this->booDefault = $booDefault;
        return $this;
    }

    /**
     *
     * @see UmlClassDiagramClassStereotype->boolDefault
     * @see UmlClassDiagramClassStereotype::setDefault( boolean )
     * @return boolean $booDefault
     */
    public function getDefault()
    {
        return $this->booDefault;
    }

    /**
     *
     * @see UmlClassDiagramClassStereotype->strName
     * @see UmlClassDiagramClassStereotype::getName()
     * @param string $strName
     * @return UmlClassDiagramClassStereotype
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
        return $this;
    }

    /**
     * Get the name of the stereotype
     *
     * @see UmlClassDiagramClassStereotype->strName
     * @see UmlClassDiagramClassStereotype::setName( string )
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the image file name
     *
     * @see UmlClassDiagramClassStereotype->strImage
     * @see UmlClassDiagramClassStereotype->getImage()
     * @param string $strImage
     * @return UmlClassDiagramClassStereotype
     */
    public function setImage( $strImage )
    {
        $this->strImage = $strImage;
        return $this;
    }

    /**
     * Get the image file name
     *
     * @see UmlClassDiagramClassStereotype->strImage
     * @see UmlClassDiagramClassStereotype->setImage( string )
     * @return string $strImage
     */
    public function getImage()
    {
        return $this->strImage;
    }
}
?>
