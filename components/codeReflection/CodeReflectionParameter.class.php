<?php
class CodeReflectionParameter extends ExtendedReflectionParameter
{
	/**
	 * Get the code from the parameter
	 *
	 * @fixme http://bugs.php.net/bug.php?id=33312
	 * @return String
	 */
	public function getCode()
	{
		$strCode = "";
/*
        if( $this->getClass() != null )
		{
			$strCode .= $this->getClass()->getClassName() . " ";
		} 
*/
		$strCode .= '$' . $this->getName();

		if( $this->isOptional() )
		{
			$strCode .= " = " . var_export( $this->getDefaultValue() , 1 );
		}
		return $strCode;
	}
	
    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new CodeReflectionClass( $objOriginalReflectionClass->getName() );
	}
	
	protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
	{
		return new CodeReflectionMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
	}
	
	protected function createExtendedReflectionFunction( ReflectionFunction $objOriginalReflectionFunction )
	{
		if( $objOriginalReflectionFunction instanceof ReflectionMethod )
		{
			return new CodeReflectionMethod( $objOriginalReflectionFunction->getName() );	
		}
		else
		{
			return new CodeReflectionFunction( $objOriginalReflectionFunction->getName() );
		}
	}
}

?>