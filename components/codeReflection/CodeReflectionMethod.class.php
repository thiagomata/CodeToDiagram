<?php
class CodeReflectionMethod extends ExtendedReflectionMethod
{
	public function getCode()
	{
		$strCode = "";
		$strCode .= $this->createMethodHeaderCode();
		$strCode .= "{";
		$strCode .= $this->createMethodContentCode();
		$strCode .= "}";

		return $strCode;
	}

	protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new CodeReflectionClass( $objOriginalReflectionClass->getName() );
	}

	protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
	{
		return new CodeReflectionParameter( Array( $this->getDeclaringClass()->getName() , $this->getName() ) , $objReflectionParameter->getName() );
	}

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

	public function createMethodHeaderCode()
	{
		$strCode = $this->getDocComment();
		$strCode .= $this->createModifiersCode();
		$strCode .= " function ";
		$strCode .= $this->getName();
		$strCode .= $this->createParametersCode();

		return CorujaStringManipulation::retab( $strCode , 1 );
	}

	protected function createMethodContentCode()
	{
		$strCode = "";

		$strFileName = $this->getFileName();
		if( !file_exists( $strFileName ) )
		{
			throw new WarningException( "Unabled to Create Code Method from the " . $strFileName );
		}
		$arrCodeReflectionFile = explode( "\n" , file_get_contents( $strFileName ) );
		for( $intLine = $this->getStartLine(); $intLine < $this->getEndLine(); ++$intLine )
		{
			$strCode .= $arrCodeReflectionFile[ $intLine ] . "\n";
		}

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