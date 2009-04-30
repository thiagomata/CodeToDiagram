<?php
/**
 * ExtendedReflectionClass - to make possible extends ReflectionClass
 * @package ExtendedReflection
 */

/**
 * 
 * Class what make possible and easy extends reflection classes
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
class ExtendedReflectionClass extends ReflectionClass
{
	/**
	 * Get the reflection of the parent class if extists
	 * and return null if not has a parent class
	 * 
	 * @return ExtendedReflectionClass|null
	 */
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

	/**
	 * Get the collection of the reflection class of all the interfaces
	 * implemented by the reflected class
	 * 
	 * @return ExtendedReflectionClass[]
	 */
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

	/**
	 * Get the collection of the reflection properties of the
	 * reflected class
	 * 
	 * @param integer $filter
	 * @return ReflectionProperty[]
	 */
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

	/**
	 * Get the reflection property of some attribute of the class
	 * searched by the property name
	 * 
	 * @param string $strName
	 * @return ExtendedReflectionProperty
	 */
    public final function getProperty( $strName )
    {
        return $this->createExtendedReflectionProperty( parent::getProperty( $strName ) );
    }

    /**
     * Get the collection of the reflected methods
     * 
     * @param $filter
     * @return ReflectionMethod[]
     */
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

    /**
     * Return the reflection of some method of the class
     * 
     * @param $strMethodName
     * @return ExtendedReflectionMethod
     */
    public final function getMethod( $strMethodName )
    {
        return $this->createExtendedReflectionMethod( parent::getMethod( $strMethodName ) );
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
     * Convert a reflection property into a extended reflection property
     * 
     * This is the method what should be replaced when this class be
     * extended.
     * 
     * @param ReflectionProperty $objOriginalReflectionProperty
     * @return ExtendedReflectionProperty
     */
	protected function createExtendedReflectionProperty( ReflectionProperty $objOriginalReflectionProperty )
	{
		return new ExtendedReflectionProperty( $this->getName() , $objOriginalReflectionProperty->getName() );
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
}

?>