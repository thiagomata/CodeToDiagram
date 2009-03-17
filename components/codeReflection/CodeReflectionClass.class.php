<?php
class CodeReflectionClass extends ExtendedReflectionClass
{
	public function getClassName()
	{
        $strName = parent::getName();
        $arrName = explode( "::" ,$strName) ;
		return array_pop( $arrName );
	}

	public function getNamespace()
	{
        $strName = parent::getName();
        $arrName = explode( "::" ,$strName) ;
		return array_shift( $arrName );
	}

    public final function getRealClassName()
    {
        $strName = ExtendedReflectionClass::getName();
        $arrName = explode( "::" ,$strName) ;
		return array_pop( $arrName );
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
        $arrConstants = $this->getConstants();
		foreach( $arrConstants as $strKey => $mixValue )
		{
			/*@var $objReflectionProperty CodeReflectionProperty */
			$strCode .= "const " . $strKey . ' = ' . var_export( $mixValue , true ) . ";\n";
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
//            print __LINE__ . $this->getRealClassName() . "<br/>\n";
//            print __LINE__ . $objReflectionMethod->getDeclaringClass()->getRealClassName() . "<br/>\n";
            if( $objReflectionMethod->getDeclaringClass()->getRealClassName() == $this->getRealClassName())
			{
                if( !$this->isInterface() )
                {
                    $strCode .= $objReflectionMethod->getCode();
                }
                else
                {
                    $strCode .= $objReflectionMethod->createMethodHeaderCode();
                }
            }
		}
		return $strCode;
	}

	public function getCode()
	{
        $strCode = "";
        if( !$this->isInterface() )
        {
            $strCode .= $this->createClassDefinitionCode();
            $strCode .= "{\n";
            $strCode .= $this->createAttributesDefinitionCode();
            $strCode .= $this->createMethodsDefinitionCode();
            $strCode .= "\n}\n";
        }
        else
        {
            $strCode .= $this->createInterfaceDefinitionCode();
            $strCode .= "{\n";
            $strCode .= $this->createAttributesDefinitionCode();
            $strCode .= $this->createMethodsDefinitionCode();
            $strCode .= "\n}\n";
        }
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