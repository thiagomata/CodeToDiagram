<?php
/**
 * UmlClassDiagramConnectorStereotype - Define the stereotypes of the uml Class
 * diagram
 */

/**
 * UmlClassDiagramConnectorStereotype define the stereotype of the connectors into the
 * Class diagram object
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramConnectorStereotype
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
     * Array of the instances of the UmlClassDiagramConnectorStereotype
     * by the name
     * 
     * @var UmlClassDiagramConnectorStereotype[]
     */
    protected static $arrInstances = array();

    /**
     * array with the name of the default stereotypes
     *
     * @var string[]
     */
    protected static $arrDefaultStereotypes = array( 
        'association' ,
        'generalization' , 
        'composition' , 
        'realization' , 
        'dependency' , 
        'aggregation'
    );
    
    /**
     * Load the default stereotype list
     */
    public static function loadDefaultStereotypes()
    {
        foreach( self::$arrDefaultStereotypes as $strDefaultStereotype )
        {
            $objStereotype = new UmlClassDiagramConnectorStereotype();
            $objStereotype->setName( $strDefaultStereotype  )->setDefault( true );
            UmlClassDiagramConnectorStereotype::addStereotype( $objStereotype );
        }
    }
    
    public static function addStereotype( UmlClassDiagramConnectorStereotype $objStereotype )
    {
        self::$arrInstances[ $objStereotype->getName()  ] = $objStereotype;
        return $objStereotype;
    }

    /**
     * Get the stereotype instance by the name
     *
     * @param string $strName
     * @return UmlClassDiagramConnectorStereotype
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
     * @see UmlClassDiagramConnectorStereotype->boolDefault
     * @see UmlClassDiagramConnectorStereotype::getDefault()
     * @param boolean $booDefault
     * @return UmlClassDiagramConnectorStereotype
     */
    public function setDefault( $booDefault )
    {
        $this->booDefault = $booDefault;
        return $this;
    }

    /**
     *
     * @see UmlClassDiagramConnectorStereotype->boolDefault
     * @see UmlClassDiagramConnectorStereotype::setDefault( boolean )
     * @return boolean $booDefault
     */
    public function getDefault()
    {
        return $this->booDefault;
    }

    /**
     *
     * @see UmlClassDiagramConnectorStereotype->strName
     * @see UmlClassDiagramConnectorStereotype::getName()
     * @param string $strName
     * @return UmlClassDiagramConnectorStereotype
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
        return $this;
    }

    /**
     * Get the name of the stereotype
     *
     * @see UmlClassDiagramConnectorStereotype->strName
     * @see UmlClassDiagramConnectorStereotype::setName( string )
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the image file name
     *
     * @see UmlClassDiagramConnectorStereotype->strImage
     * @see UmlClassDiagramConnectorStereotype->getImage()
     * @param string $strImage
     * @return UmlClassDiagramConnectorStereotype
     */
    public function setImage( $strImage )
    {
        $this->strImage = $strImage;
        return $this;
    }

    /**
     * Get the image file name
     *
     * @see UmlClassDiagramConnectorStereotype->strImage
     * @see UmlClassDiagramConnectorStereotype->setImage( string )
     * @return string $strImage
     */
    public function getImage()
    {
        return $this->strImage;
    }
}
?>
