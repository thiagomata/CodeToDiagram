<?php
/**
 * CodeReflectionClass - to get the code reflection of the class
 * @package CodeReflection
 */

/**
 * Code reflection class it is a class what is a extension of the php reflection
 * with improvments to show the php code of the reflected class
 *
 * With this class you can see the code of some class, method, attribute just as
 * it is and extending this class you can create a similary class of the original
 * one.
 *
 * This class can be used to debug, detail of some execution or stack and to code
 * instrumentation.
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class CodeReflectionClass extends ExtendedReflectionClass
{
    /**
     * Construct the Code Reflection of the class.
     *
     * It must receive the eval content if the class it was created into a eval
     * command.
     *
     * @param string $strClassName
     * @param string $strEvalContent
     */
    public function __construct( $strClassName,  $strEvalContent = "" )
    {
        parent::__construct( $strClassName );
        if( $strEvalContent != "" )
        {
            new CodeReflectionFile( $this->getFileName() , $strEvalContent , false );
        }
    }

    /**
     * Get the class name
     *
     * @return string
     */
    public function getClassName()
	{
        $strName = parent::getName();
        $arrName = explode( "::" ,$strName) ;
		return array_pop( $arrName );
	}

    /**
     * Get the namespace name
     *
     * @return string
     */
	public function getNamespace()
	{
        $strName = parent::getName();
        $arrName = explode( "::" ,$strName) ;
		return array_shift( $arrName );
	}

    /**
     * A version of the get class name what cannot
     * be replaced.
     *
     * Should be used when the execution need
     * the real original class name
     *
     * @return string
     */
    public final function getRealClassName()
    {
        $strName = ExtendedReflectionClass::getName();
        $arrName = explode( "::" ,$strName) ;
		return array_pop( $arrName );
    }

    /**
     * Create a php class definition code
     *
     * @return string code of class creation
     */
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

    /**
     * Create a php attribute definition code
     *
     * @return string code of attribute
     */
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

    /**
     * Create a php method definiton code 
     *
     * @return string code of method
     */
	public function createMethodsDefinitionCode()
	{
		$strCode = "";
		$arrMethods = $this->getMethods();
		foreach( $arrMethods as $objReflectionMethod )
		{
			/*@var $objReflectionMethod CodeReflectionMethod */
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

    /**
     * Create the code of the reflected object
     *
     * @see CodeReflectionClass::createClassDefinitionCode
     * @see CodeReflectionClass::createInterfaceDefinitionCode
     * @see CodeReflectionClass::createAttributesDefinitionCode
     * @see CodeReflectionClass::createMethodsDefinitionCode
     * @return string code of the reflected object
     */
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

    /**
     * Make the recursive calls and indirectly call return the extended reflection object and not
     * a native reflection class.
     *
     * @see ExtendedReflectionClass::createExtendedReflectionClass( ReflectionClass )
     * @param ReflectionClass $objOriginalReflectionClass
     * @return CodeReflectionClass
     */
	protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new CodeReflectionClass( $objOriginalReflectionClass->getName() );
	}

    /**
     * Make the recursive calls and indirectly call return the extended reflection object and not
     * a native reflection property.
     *
     * @see ExtendedReflectionClass::createExtendedReflectionProperty( ReflectionProperty )
     * @param ReflectionProperty $objOriginalReflectionClass
     * @return CodeReflectionProperty
     */
    protected function createExtendedReflectionProperty( ReflectionProperty $objOriginalReflectionProperty )
	{
		return new CodeReflectionProperty( $this->getName() , $objOriginalReflectionProperty->getName() );
	}

    /**
     * Make the recursive calls and indirectly call return the extended reflection object and not
     * a native reflection method.
     *
     * @see ExtendedReflectionClass::createExtendedReflectionMethod( ReflectionMethod )
     * @param ReflectionMethod $objOriginalReflectionClass
     * @return CodeReflectionMethod
     */
	protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
	{
		return new CodeReflectionMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
	}
}

?>