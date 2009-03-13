<?php
class ExtendedReflectionMethod extends ReflectionMethod
{
	public function getDeclaringClass()
    {
        $objReflectionClass = parent::getDeclaringClass();
        return $this->createExtendedReflectionClass( $objReflectionClass );
    }

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

	protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new ExtendedReflectionClass( $objOriginalReflectionClass->getName() );
	}

	protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
	{
		return new ExtendedReflectionParameter( Array( $this->getDeclaringClass()->getName() , $this->getName() ) , $objReflectionParameter->getName() );
	}

}
?>