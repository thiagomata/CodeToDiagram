<?php
/**
 * ExtendedReflectionFunction - to make possible extend ReflectionFunction
 * @package ExtendedReflection
 */

/**
 * Class what make possible and easy extend reflection function
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
class ExtendedReflectionFunction extends ReflectionFunction
{
	/**
	 * Return a list of the parameters of the reflected function
	 * 
	 * @return ExtendedReflectionParameter[]
	 */
    public final function getParameters()
    {
        $arrReflectionParameters = parent::getParameters();
        $arrExtendedParameters = array();
		foreach( $arrReflectionParameters as $objReflectionParameter )
		{
			/*@var $objReflectionParameter ReflectionParameter */
			$arrExtendedParameteres[] = $this->createExtendedReflectionParameter( $objReflectionParameter );
		}
		return $arrExtendedParameters;
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
		return new ExtendedReflectionParameter( $this->getDeclaringClass()->getName() , $this->getName() , $objReflectionParameter->getName() );
	}

}
?>