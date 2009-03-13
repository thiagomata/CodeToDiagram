<?php
class ExtendedReflectionParameter extends ReflectionParameter
{
	public final function getDeclaringClass()
    {
        return $this->createExtendedReflectionClass( parent::getDeclaringClass() );
    }

    public final function getClass()
    {
    	if( parent::getClass() == null )
    	{
    		return null;
    	}
    	return $this->createExtendedReflectionClass( parent::getClass() );
    }

    public final function getDeclaringFunction()
    {
        $objReflectionFunction = $this->createExtendedReflectionFunction( parent::getDeclaringFunction() );
    }

    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new ExtendedReflectionClass( $objOriginalReflectionClass->getName() );
	}

	protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
	{
		return new ExtendedReflectionMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
	}

	protected function createExtendedReflectionFunction( ReflectionFunction $objOriginalReflectionFunction )
	{
		if( $objOriginalReflectionFunction instanceof ReflectionMethod )
		{
			return new ExtendedReflectionMethod( $objOriginalReflectionFunction->getName() );
		}
		else
		{
			return new ExtendedReflectionFunction( $objOriginalReflectionFunction->getName() );
		}
	}
}

?>