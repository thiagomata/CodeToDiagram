<?php
class ExtendedReflectionClass extends ReflectionClass
{
	public final function getParentClass()
	{
        $objParent = parent::getParentClass();
        if( $objParent != null )
        {
            return $this->createExtendedReflectionClass(  $objParent );
        }
        else
        {
            return null;
        }
	}

	public final function getInterfaces()
	{
		$arrOriginalInterfaces = parent::getInterfaces();
		$arrExtendedInterfaces = array();
		foreach( $arrOriginalInterfaces as $objInterface )
		{
			/*@var $objInterface ReflectionClass */
			$arrExtendedInterfaces[] = $this->createExtendedReflectionClass( $objInterface );
		}
		return $arrExtendedInterfaces;
	}
	
	public final function getProperties( $filter = -1 )
	{
		$arrReflectionProperties = parent::getProperties( $filter );
		$arrExtendedProperties = array();
		foreach( $arrReflectionProperties as $objReflectionProperty )
		{
			/*@var $objReflectionProperty ReflectionProperty */
			$arrExtendedProperties[] = $this->createExtendedReflectionProperty( $objReflectionProperty );
		}
		return $arrExtendedProperties;
	}
	
    public final function getProperty( $strName )
    {
        return $this->createExtendedReflectionProperty( parent::getProperty( $strName ) );
    }
    
    public final function getMethods( $filter = -1 )
    {
    	$arrReflectionMethods = parent::getMethods( $filter );
    	$arrExtendedMethods = array();
    	foreach( $arrReflectionMethods as $objReflectionMethod )
    	{
    		/*@var $objReflectionMethod ReflectionMethod */
    		$arrExtendedMethods[] = $this->createExtendedReflectionMethod( $objReflectionMethod ); 
    	}
    	return $arrExtendedMethods;
    }
    
	protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new ExtendedReflectionClass( $objOriginalReflectionClass->getName() );
	}
	
    protected function createExtendedReflectionProperty( ReflectionProperty $objOriginalReflectionProperty )
	{
		return new ExtendedReflectionProperty( $this->getName() , $objOriginalReflectionProperty->getName() );
	}
	
	protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
	{
		return new ExtendedReflectionMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
	}
}

?>