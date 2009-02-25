<?php
class DebugReflectionProperty extends CodeReflectionProperty
{
	protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new DebugReflectionClass( $objOriginalReflectionClass->getName() );
	}

}
?>