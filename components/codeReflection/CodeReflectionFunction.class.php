<?php
class CodeReflectionFunction extends ExtendedReflectionFunction
{
	protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
	{
		return new CodeReflectionParameter( $this->getDeclaringClass()->getName() , $this->getName() , $objReflectionParameter->getName() );
	}

}
?>