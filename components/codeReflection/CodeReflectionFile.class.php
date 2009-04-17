<?php
/**
 * Code Reflection File it is a class with the prupose to make possible
 * abstract the diference between code run into real files and code run into
 * eval commands.
 *
 * In this mode this class keep the alias fake name of the alias content and
 * the file content, this information can be access by others classes what
 * will be able to interaction with the fake file.
 *
 * You can get a streck of code of the memory file or the real file using the
 * same method send the first line and last line of the bit of code what you
 * want to receive.
 */
class CodeReflectionFile
{
    /**
     * array of all instances of CodeReflectionFile using the name as key
     * 
     * @var CodeReflectionFile[]
     */
    protected static $arrInstances = array();

    /**
     * File Name
     *
     * @var string
     */
    protected $strFileName;

    /**
     * File Content
     *
     * @var string
     */
    protected $arrFileContent;

    /**
     * Flag if the file it is a real file
     * <code>true</code> if is a real file
     * <code>false</code> if is a not real file
     *
     * @var boolean
     */
    protected $boolRealFile;

    /**
     * Get The File by Name
     *
     * Search into all object files saved and return that one have the searched
     * name
     * 
     * @see CodeReflectionFile->arrInstances
     * @param string $strFileName
     * @return CodeReflectionFile
     */
    public static function getCodeInstrFileName( $strFileName )
    {
        if( array_key_exists( $strFileName , self::$arrInstances ) )
        {
            return 	self::$arrInstances[ $strFileName ];
        }
        else
        {
            return new CodeReflectionFile( $strFileName );
        }
    }

    /**
     * Create the Code Reflection File
     *
     * @see CodeReflectionFile::$arrInstances
     * @see CodeReflectionFile::setFileName( string )
     * @see CodeReflectionFile::setFileContent( string )
     * @param string $strFileName file name
     * @param string $strFileContent file content
     * @param boolean $boolRealFile if is a real file or not
     */
    public function __construct( $strFileName , $strFileContent = ""  , $boolRealFile = true )
    {
        $this->setFileName( $strFileName);
        $this->setFileContent( $strFileContent );
        $this->boolRealFile = (bool)$boolRealFile;
        self::$arrInstances[ $strFileName ] = $this;
    }

    /**
     * Set the file name
     *
     * @see CodeReflectionFile::getFileName()
     * @see CodeReflectionFile->strFileName
     * @param string $strFileName file name
     * @return CodeReflectionFile me
     */
    public function setFileName( $strFileName )
    {
        $this->strFileName = (string)$strFileName;
        return $this;
    }

    /**
     * Get the file name
     *
     * @see CodeReflectionFile::setFileName( string )
     * @see CodeReflectionFile->strFileName
     * @return string file name
     */
    public function getFileName()
    {
        return $this->strFileName;
    }

    /**
     * Set the code Reflection file content
     *
     * Set the code Reflection file content and
     * return itselft.
     *
     * @see CodeReflectionFile->arrFileContent
     * @param string $strFileContent file content
     * @return CodeReflectionFile me
     */
    public function setFileContent( $strFileContent )
    {
        $this->arrFileContent = explode( "\n" , (string)$strFileContent );
        return $this;
    }

    /**
     * Get the file content
     *
     * @see CodeReflectionFile->arrFileContent
     * @see CodeReflectionFile::setFileContent( string )
     * @return string file content
     */
    public function getFileContent()
    {
        return implode( "\n" , $this->arrFileContent );
    }

    /**
     * Get the array of lines with the code file content
     *
     * Set the code file content and
     * return itselft.
     *
     * @see CodeReflectionFile->arrFileContent
     * @see CodeReflectionFile::setFileContent( string )
     * @see CodeReflectionFile::getFileContent()
     * @return string[] array of file content
     */
    public function getArrFileContent()
    {
        return $this->arrFileContent;
    }

    /**
     * Get a slice, a streck, a bit of the content of the file
     * receiving the first and last line of the slice wish.
     *
     * @see CodeReflectionFile::setFileContent( string )
     * @see CodeReflectionFile->arrFileContent
     * @see CodeReflectionFile->arrFileContent
     * @param integer $intLineStart first line of the content
     * @param integer $intLineEnds last line of the content
     * @return string code content
     */
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

    /**
     * Returns if the file it is a real file
     *
     * @see CodeReflectionFile->boolRealFile
     * @return boolean <code>true</code> if is a real file <code>false</code> if not
     */
    public function isRealFile()
    {
        return $this->boolRealFile;
    }
}
?>
