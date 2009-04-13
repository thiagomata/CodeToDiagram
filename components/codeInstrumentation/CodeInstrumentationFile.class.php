<?php
class CodeInstrumentationFile
{
    protected static $arrInstances = array();

    protected $strFileName;
    protected $arrFileContent;
    protected $boolRealFile;

    /**
     * Get The Debug File by Name
     *
     * @param string $strFileName
     * @return CodeInstrumentationFile
     */
    public static function getCodeInstrFileName( $strFileName )
    {
        if( array_key_exists( $strFileName , self::$arrInstances ) )
        {
            return 	self::$arrInstances[ $strFileName ];
        }
        else
        {
            return new CodeInstrumentationFile( $strFileName );
        }
    }

    public function __construct( $strFileName , $strFileContent = ""  , $boolRealFile = true )
    {
        $this->setFileName( $strFileName);
        $this->setFileContent( $strFileContent );
        $this->boolRealFile = $boolRealFile;
        self::$arrInstances[ $strFileName ] = $this;
    }

    public function setFileName( $strFileName )
    {
        $this->strFileName = $strFileName;
        return $this;
    }

    public function getFileName()
    {
        return $this->strFileName;
    }

    public function setFileContent( $strFileContent )
    {
        $this->arrFileContent = explode( "\n" , $strFileContent );
        return $this;
    }

    public function getFileBit( $intLineStart, $intLineEnds )
    {
        $strFileBit = "";

        if( $this->isRealFile() )
        {
            $this->setFileContent( $this->getFileName() );
        }

        for( $intLine = $intLineStart ; $intLine < $intLineEnds ; ++$intLine )
        {
            $strFileBit .= CorujaArrayManipulation::getArrayField( $this->arrFileContent ,$intLine , "") . "\n";
        }
        return $strFileBit;
    }

    public function isRealFile()
    {
        return $this->boolRealFile;
    }
}
?>
