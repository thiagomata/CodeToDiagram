<?php
/**
 * Class what make possible and easy extend reflection property
 * 
 * Reflection classes can be a problem because the reflection
 * methods what return objects will return the original reflection
 * object and not the extended version of it. So it is necessary to
 * create methods what convert the original methods to return the
 * extended version of the objects.
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @package ExtendedReflection
 *
 */class ExtendedReflectionProperty extends ReflectionProperty
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
}
?>