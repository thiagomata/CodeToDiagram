<?php
class DebugReflectionClass extends CodeReflectionClass
{
	protected $arrFileContent;

    protected $strName = null;
    
	public function __construct( $strClassName,  $strEvalContent = "" )
	{
		parent::__construct( $strClassName );
		if( $strEvalContent != "" )
		{
			new DebugReflectionFile( $this->getFileName() , $strEvalContent , false );
		}
	}

    public function getClassName()
    {
        if( $this->strName == null )
        {
            return parent::getClassName();
        }
        else
        {
            return $this->strName;
        }
    }

    public function setClassName( $strName )
    {
            $this->strName = $strName;
    }

	protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new DebugReflectionClass( $objOriginalReflectionClass->getName() );
	}
	
    protected function createExtendedReflectionProperty( ReflectionProperty $objOriginalReflectionProperty )
	{
		return new DebugReflectionProperty( $this->getName() , $objOriginalReflectionProperty->getName() );
	}
	
	protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
	{
		return new DebugReflectionMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
	}
}

?>