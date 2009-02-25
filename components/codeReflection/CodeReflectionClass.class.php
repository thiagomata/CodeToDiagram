<?php
class CodeReflectionClass extends ExtendedReflectionClass
{
	public function getClassName()
	{
		return array_pop( explode( "::" , parent::getName() ) );
	}
	
	public function getNamespace()
	{
		return array_shift( explode( "::" , parent::getName() ) );
	}
	
	public function createClassDefinitionCode()
	{
		$strCode = "";
		$strCode .= " class " . $this->getClassName();
		if( $this->getParentClass() != "" )
		{
			$strCode .= " extends " . $this->getParentClass()->getClassName(); 
		}
		if( sizeof( $this->getInterfaceNames() ) > 0)
		{
			$arrInterfacesClassName = array();
			$arrInterfaces = $this->getInterfaces();
			foreach(  $arrInterfaces as $objInterfaces )
			{
				$arrInterfacesClassName[] = $objInterfaces->getClassName();	
			}
			$strCode .= " implements " . implode( ", " , $arrInterfacesClassName );
		}
		$strCode .= "\n";
		return $strCode;
	}

	public function createAttributesDefinitionCode()
	{
		$strCode = "";
		$arrProperties = $this->getProperties();
		foreach( $arrProperties as $objReflectionProperty )
		{
			/*@var $objReflectionProperty CodeReflectionProperty */
			$strCode .= $objReflectionProperty->getCode();
		}
		return $strCode;
	}
	
	public function createMethodsDefinitionCode()
	{
		$strCode = "";
		$arrMethods = $this->getMethods();
		foreach( $arrMethods as $objReflectionMethod )
		{
			/*@var $objReflectionMethod CodeReflectionMethod */
			$strCode .= $objReflectionMethod->getCode();
		}
		return $strCode;
	}
	
	public function getCode()
	{
		$strCode = "";
		$strCode .= $this->createClassDefinitionCode();
		$strCode .= "{\n";
		$strCode .= $this->createAttributesDefinitionCode();
		$strCode .= $this->createMethodsDefinitionCode();
		$strCode .= "\n}\n";
		return $strCode;
	}
	
	protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new CodeReflectionClass( $objOriginalReflectionClass->getName() );
	}
	
    protected function createExtendedReflectionProperty( ReflectionProperty $objOriginalReflectionProperty )
	{
		return new CodeReflectionProperty( $this->getName() , $objOriginalReflectionProperty->getName() );
	}
	
	protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
	{
		return new CodeReflectionMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
	}
}

?>