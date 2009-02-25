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

    public function createMethodsDefinitionCode()
    {
        $strCode = '';
        $boolHasConstructor = false;

        foreach( $this->getMethods() as $objMethodReflection )
        {
            if( $objMethodReflection->getName() == '__construct' )
            {
                $boolHasConstructor = true;
                break;
            }
        }
        
        $strCode = parent::createMethodsDefinitionCode();
        if( $boolHasConstructor == false )
        {
            $strCode .=	' public function __construct()                                                                 ' . "\n";
            $strCode .=	'    {                                                                                          ' . "\n";
            $strCode .=	'       $arrArguments = func_get_args();                                                        ' . "\n";
            $strCode .=	'       $mixReturn = null;                                                                      ' . "\n";
            $strCode .=	'   	DebugRefletionReceiver::getInstance()->onEnterMethod( spl_object_hash($this) , __CLASS__ , __METHOD__ , $arrArguments );' . "\n";
            $strCode .=	'       DebugRefletionReceiver::getInstance()->onLeaveMethod( spl_object_hash($this) , __CLASS__ , __METHOD__ , $mixReturn    );' . "\n";
            $strCode .=	'	}                                                                                           ' . "\n";
        }
        return $strCode;
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