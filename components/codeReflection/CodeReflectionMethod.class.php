<?php
/**
 * Generated the code definition of some method based into
 * its reflection information
 * 
 * @author Thiago Mata
 *
 */
class CodeReflectionMethod extends ExtendedReflectionMethod
{

	/**
	 * Create the code definition of the reflected method
	 * 
	 * @return string code method definition
	 */
	public function getCode()
	{
		$strCode = "";
		$strCode .= $this->createMethodHeaderCode();
		$strCode .= "{";
		$strCode .= $this->createMethodContentCode();
		$strCode .= "}\n";

		return $strCode;
	}

	/**
	 * Get the code content of the method
	 * 
	 * @return string
	 */
    public function getCodeContent()
    {
        return $this->createMethodContentCode();
    }
    
    /**
     * Create the link between the code reflection method and its
     * code reflection class
     * 
     * @see ExtendedReflectionMethod::createExtendedReflectionClass( ReflectionClass )
     * @param ReflectionClass $objOriginalReflectionClass
     * @return CodeReflectionClass
     */
	protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new CodeReflectionClass( $objOriginalReflectionClass->getName() );
	}

	/**
	 * Create the link between the code reflection method and its
	 * code reflection parameter
	 * 
	 * @see ExtendedReflectionMethod::createExtendedReflectionParameter( ReflectionParameter )
	 * @param ReflectionParameter $objReflectionParameter 
	 * @return CodeReflectionParameter
	 */
	protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
	{
		return new CodeReflectionParameter( Array( $this->getDeclaringClass()->getName() , $this->getName() ) , $objReflectionParameter->getName() );
	}

	/**
	 * Create the modifiers code definition of the method
	 * 
	 * @return string
	 */
	protected function createModifiersCode()
	{
		$strCode = "";
		if( $this->isFinal() )
		{
			$strCode .= " final ";
		}
		if( $this->isPrivate() )
		{
			$strCode .= " private ";
		}
		if( $this->isProtected())
		{
			$strCode .= " protected ";
		}
		if( $this->isPublic())
		{
			$strCode .= " public ";
		}
		if( $this->isStatic() )
		{
			$strCode .= " static ";
		}
		return $strCode;
	}

	/**
	 * Create the parameters code definition
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
	 * Create the method code definition header 
	 * 
	 * @return string
	 */
	public function createMethodHeaderCode()
	{
		$strCode = $this->getDocComment();
		$strCode .= $this->createModifiersCode();
		$strCode .= " function ";
		$strCode .= $this->getName();
		$strCode .= $this->createParametersCode();

		return CorujaStringManipulation::retab( $strCode , 1 );
	}

	/**
	 * Create the method code definition content
	 * 
	 * @return string
	 */
	protected function createMethodContentCode()
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