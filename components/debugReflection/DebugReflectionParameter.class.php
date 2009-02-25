<?php
class DebugReflectionParameter extends CodeReflectionParameter
{
    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new DebugReflectionClass( $objOriginalReflectionClass->getName() );
	}
	
	protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
	{
		return new DebugReflectionMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
	}
	
	protected function createExtendedReflectionFunction( ReflectionFunction $objOriginalReflectionFunction )
	{
		if( $objOriginalReflectionFunction instanceof ReflectionMethod )
		{
			return new DebugReflectionMethod( $objOriginalReflectionFunction->getName() );	
		}
		else
		{
			return new DebugReflectionFunction( $objOriginalReflectionFunction->getName() );
		}
	}
}

?>