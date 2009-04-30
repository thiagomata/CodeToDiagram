<?php
/**
 * ExtendedReflectionMethod - to make possible to extends ReflectionMethod
 * @package ExtendedReflection
 */

/**
 *
 * Class what make possible and easy extend reflection method
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
class ExtendedReflectionMethod extends ReflectionMethod
{
	/**
	 * Get the class owner of the reflected method
	 * 
	 * @return ExtendedReflectionClass
	 */
	public function getDeclaringClass()
    {
        $objReflectionClass = parent::getDeclaringClass();
        return $this->createExtendedReflectionClass( $objReflectionClass );
    }

    /**
     * Get the collection of the parameters of the reflected method
     * 
     * @return ExtendedReflectionParameter[]
     */
    public function getParameters()
    {
        $arrReflectionParameters = parent::getParameters();
        $arrExtendedParameters = array();
		foreach( $arrReflectionParameters as $objReflectionParameter )
		{
			/*@var $objReflectionParameter ReflectionParameter */
			$arrExtendedParameters[] = $this->createExtendedReflectionParameter( $objReflectionParameter );
		}
 		return $arrExtendedParameters;
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
     * Convert a reflection parameter into a extended reflection parameter
     * 
     * This is the method what should be replaced when this class be
     * extended.
     * 
     * @param ReflectionParameter $objReflectionParameter
     * @return ExtendedReflectionParameter
     */
	protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
	{
		return new ExtendedReflectionParameter( Array( $this->getDeclaringClass()->getName() , $this->getName() ) , $objReflectionParameter->getName() );
	}

}
?>