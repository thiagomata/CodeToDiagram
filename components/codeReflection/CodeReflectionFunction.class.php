<?php
/**
 * CodeReflectionFunction - code reflection of the functions
 * @package CodeReflection
 */

/**
 *
 * Generate the code definition of some function based into its
 * reflection information
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class CodeReflectionFunction extends ExtendedReflectionFunction
{
	/**
	 * Create the code of the function based into reflection's information
	 * 
	 * @return string
	 */
	public function getCode()
	{
		$strCode = "";
		$strCode .= $this->createFunctionHeaderCode();
		$strCode .= "{";
		$strCode .= $this->createFunctionContentCode();
		$strCode .= "}\n";

		return $strCode;
	}

	/**
	 * Get the code content
	 * 
	 * @return string
	 */
    public function getCodeContent()
    {
        return $this->createMethodContentCode();
    }
    
	/**
	 * Make the reflection parameter link return a code reflection parameter
	 * 
	 * @see ExtendedReflectionFunction::createExtendedReflectionParameter()
	 * @param ReflectionParameter $objReflectionParameter
	 * @return CodeReflectionParameter
	 */
	protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
	{
		return new CodeReflectionParameter( null , $this->getName() , $objReflectionParameter->getName() );
	}

	/**
	 * Get the code of the parameters definition
	 * 
	 * @return string
	 */
	protected function createParametersCode()
	{
		$strCode = "";
		$arrParameters = $this->getParameters();
		$arrParametersName = array();

		foreach(  $arrParameters as $objParameter )
		{
			/*@var $objParameter CodeReflectionParameter */
			$arrParametersName[] = $objParameter->getCode();
		}

		$strCode .= "(";
		$strCode .= implode( ", " , $arrParametersName);
		$strCode .= ")";
		return $strCode;
	}

	/**
	 * Create the function header code
	 * 
	 */
	public function createFunctionHeaderCode()
	{
		$strCode = $this->getDocComment();
		$strCode .= " function ";
		$strCode .= $this->getName();
		$strCode .= $this->createParametersCode();

		return CorujaStringManipulation::retab( $strCode , 1 );
	}

	/**
	 * Creater the function content
	 * 
	 * @return string
	 */
	protected function createFunctionContentCode()
	{
		$strCode = "";

		$strFileName = $this->getFileName();

        $objFile = CodeReflectionFile::getCodeInstrFileName( $strFileName );

        $strCode = $objFile->getFileBit( $this->getStartLine() ,  $this->getEndLine() );

		$strCode = trim( $strCode );

		// remove the { }
		if( $strCode[0] == "{" )
		{
			$strCode = substr( $strCode , 1 , -1);
		}
		return $strCode;
	}
}
?>