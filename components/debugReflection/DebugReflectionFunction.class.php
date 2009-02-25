<?php
class DebugReflectionFunction extends CodeReflectionFunction
{
	protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
	{
		return new DebugReflectionParameter( $this->getDeclaringClass()->getName() , $this->getName() , $objReflectionParameter->getName() );
	}
    
}
?>