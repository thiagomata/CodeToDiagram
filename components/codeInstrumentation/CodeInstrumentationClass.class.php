<?php
class CodeInstrumentationClass extends CodeReflectionClass
{
    protected $arrFileContent;

    protected $strName = null;

    public function __construct( $strClassName,  $strEvalContent = "" )
    {
        parent::__construct( $strClassName );
        if( $strEvalContent != "" )
        {
            new CodeInstrumentationFile( $this->getFileName() , $strEvalContent , false );
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
        return $this;
    }

    public function createMethodsDefinitionCode()
    {
        if( $this->isInterface() )
        {
            return parent::createMethodsDefinitionCode();
        }
        
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
            $strCode .=	'   	CodeInstrumentationReceiver::getInstance()->onEnterMethod( spl_object_hash($this) , __CLASS__ , __METHOD__ , $arrArguments );' . "\n";
            $strCode .=	'       CodeInstrumentationReceiver::getInstance()->onLeaveMethod( spl_object_hash($this) , __CLASS__ , __METHOD__ , $mixReturn    );' . "\n";
            $strCode .=	'	}                                                                                           ' . "\n";
        }
        return $strCode;
    }

    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
    {
        return new CodeInstrumentationClass( $objOriginalReflectionClass->getName() );
    }

    protected function createExtendedReflectionProperty( ReflectionProperty $objOriginalReflectionProperty )
    {
        return new CodeInstrumentationProperty( $this->getName() , $objOriginalReflectionProperty->getName() );
    }

    protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
    {
        return new CodeInstrumentationMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
    }
}

?>
