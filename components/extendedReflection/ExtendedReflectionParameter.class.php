<?php
/**
 * ExtendedReflectionParameter - to make possible to extends ReflectionParameter
 * @package ExtendedReflection
 */

/**
 * Class what make possible and easy extend reflection parameter
 * 
 * Reflection classes can be a problem because the reflection
 * methods what return objects will return the original reflection
 * object and not the extended version of it. So it is necessary to
 * create methods what convert the original methods to return the
 * extended version of the objects.
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class ExtendedReflectionParameter extends ReflectionParameter
{
	/**
	 * Get the class owner of the reflected parameter
	 * 
	 * @return ExtendedReflectionClass
	 */
	public final function getDeclaringClass()
    {
        return $this->createExtendedReflectionClass( parent::getDeclaringClass() );
    }

	/**
	 * Get the class type of the reflected parameter
	 * 
	 * @return ExtendedReflectionClass
	 */
    public final function getClass()
    {
    	if( parent::getClass() == null )
    	{
    		return null;
    	}
    	return $this->createExtendedReflectionClass( parent::getClass() );
    }

    /**
     * Get the declarion function of the reflected function
     * 
     * @return ExtendedReflectionFunction
     */
    public final function getDeclaringFunction()
    {
        $objReflectionFunction = $this->createExtendedReflectionFunction( parent::getDeclaringFunction() );
    }

    /**
     * Convert a reflection class into a extended reflection class
     * 
     * This is the method what should be replaced when this class be
     * extended.
     * 
     * @param ReflectionClass $objOriginalReflectionClass
     * @return ExtendedReflectionClass
     */
    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new ExtendedReflectionClass( $objOriginalReflectionClass->getName() );
	}

    /**
     * Convert a reflection method into a extended reflection method
     * 
     * This is the method what should be replaced when this class be
     * extended.
     * 
     * @param ReflectionMethod $objOriginalReflectionMethod
     * @return ExtendedReflectionMethod
     */
	protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
	{
		return new ExtendedReflectionMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
	}

    /**
     * Convert a reflection function into a extended reflection function
     * 
     * This is the method what should be replaced when this class be
     * extended.
     * 
     * @param ReflectionFunction $objOriginalReflectionFunction
     * @return ExtendedReflectionFunction
     */
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