<?php
class ExtendedReflectionFunction extends ReflectionFunction
{
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
	
	protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
	{
		return new ExtendedReflectionParameter( $this->getDeclaringClass()->getName() , $this->getName() , $objReflectionParameter->getName() );
	}
    
}
?>