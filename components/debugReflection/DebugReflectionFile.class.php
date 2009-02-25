<?php
class DebugReflectionFile
{
	protected static $arrInstances = array();
	
	protected $strFileName;
	protected $arrFileContent;
	protected $boolRealFile;
	
	/**
	 * Get The Debug File by Name
	 *
	 * @param string $strFileName
	 * @return DebugReflectionFile
	 */
	public static function getDebugFileName( $strFileName )
	{
		if( array_key_exists( $strFileName , self::$arrInstances ) )
		{
			return 	self::$arrInstances[ $strFileName ];
		}
		else
		{
			return new DebugFile( $strFileName );
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
	}
	
	public function getFileName()
	{
		return $this->strFileName;
	}
	
	public function setFileContent( $strFileContent )
	{
		$this->arrFileContent = explode( "\n" , $strFileContent );	
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