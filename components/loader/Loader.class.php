<?php
/*
 * Loader it is the class resposanble to controls the load of the files
 * @package loader
 */

/**
 * Class responsable to controls the load of the files.
 *
 * This class is responsable to make the classical load
 * of the files and to make the visible code load, what
 * is essencial to the external load of the component.
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class Loader
{
    /**
     * instance of the loader element
     * @var Loader
     */
    protected static $objInstance;

    /**
     * Flag if the loader it is to external access
     * @var boolean
     */
    protected $booExternal = false;

    /**
     * Array of files already load by the lodader class
     *
     * @var string[]
     */
    protected $arrFiles = array();

    /**
     * Class content of the classes loaded
     *
     * @var string
     */
    protected $strClassContent = '';
    
    /**
     * Return the singleton instance of the Loader class
     *
     * @return Loader
     */
    public static function getInstance()
    {
        if( self::$objInstance == null )
        {
            self::$objInstance = new Loader();
        }
        return self::$objInstance;
    }

    /**
     * Set if the loader it is to extenal access
     *
     * @see Loader::getExternal()
     * @see Loader->boolExternal
     * @param boolean $booExternal
     */
    public function setExternal( $booExternal )
    {
        $this->booExternal = $booExternal;
    }

    /**
     * Get if the loader it is to external access
     *
     * @see Loader::setExternal( boolean )
     * @see Loader->boolExternal
     * @return boolean
     */
    public function getExternal()
    {
        return $this->booExternal;
    }

    /**
     * Require Once the file of the Code To Diagram
     *
     * @param string $strFile
     * @param boolean $booIsClass
     */
    public static function requireOnce( $strFile , $booIsClass = false )
    {
//        print $strFile . '<br/>' . "\n";
        $arrBackTrace = debug_backtrace();
        $arrCaller = $arrBackTrace[0];
        $strFileCaller = $arrCaller[ 'file' ];
        $strPathCaller = CorujaFileManipulation::getPathOfFile( $strFileCaller  );

        if( CorujaFileManipulation::isRelativePath( $strFile ) )
        {
            $strFullPathFile = $strPathCaller . $strFile;
        }
        else
        {
            $strFullPathFile = $strFile;
        }

        if( $booIsClass && self::getInstance()->getExternal() )
        {
             self::getInstance()->show( $strFullPathFile );
        }
        
        require_once( $strFullPathFile );
    }

    public function show( $strFullPathFile )
    {
        if( !in_array( $strFullPathFile , $this->arrFiles ) )
        {
            $this->arrFiles[] = $strFullPathFile;
            $this->strClassContent .= file_get_contents( $strFullPathFile );
        }
    }

    public function getClassContent()
    {
        return $this->strClassContent;
    }
}
?>