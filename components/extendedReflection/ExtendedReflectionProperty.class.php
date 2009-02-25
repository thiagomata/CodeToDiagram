<?php
class ExtendedReflectionProperty extends ReflectionProperty
{
	public final function getDeclaringClass()
    {
        return $this->createExtendedReflectionClass( parent::getDeclaringClass() );
    }
	
	protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new ExtendedReflectionClass( $objOriginalReflectionClass->getName() );
	}	
}
?>