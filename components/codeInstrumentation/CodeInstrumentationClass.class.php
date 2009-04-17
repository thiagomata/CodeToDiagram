<?php
/**
 * Code Instrumentation Class extends a Code Reflection Class
 * to create not a exactly code of the original class but a
 * changed version with some code instrumentation messages what
 * will be send to the Code Instrumentation Receiver
 */
class CodeInstrumentationClass extends CodeReflectionClass
{
    /**
     * The editable class name
     *
     * @var string
     */
    protected $strName = null;

    /**
     * Construct the Code Instrumentation of the class.
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
            new CodeInstrumentationFile( $this->getFileName() , $strEvalContent , false );
        }
    }

    /**
     * Returns the editable class name
     *
     * @example
     * <code>
     *      $this->setClassName( "something" );
     *      $this->getClassName() == "something"
     * </code>
     * @return string
     */
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

    /**
     * Set the editable class name
     * 
     * @example
     * <code>
     *      $this->setClassName( "something" )->getClassName() == "something"
     * </code>
     * @assert( "something" )
     *
     * @param string $strName
     * @return CodeInstrumentationClass
     */
    public function setClassName( $strName )
    {
        $this->strName = $strName;
        return $this;
    }

    /**
     * Create the methods definition code with code instrumentation.
     *
     * Create the methods of the class changed to can send the messages
     * to the code instrumentation receive before and after each call.
     *
     * - Interfaces will not change
     * - If the class dont have a constructor and a destructor force existence.
     * - call the parent createMethodsDefinitionCode what will call the CodeInstrumentationMethod
     *
     * @see CodeInstrumentationMethod
     * @return string
     */
    public function createMethodsDefinitionCode()
    {
        if( $this->isInterface() )
        {
            return parent::createMethodsDefinitionCode();
        }
        
        $strCode = '';
        $boolHasConstructor = false;
        $boolHasDestructor = false;

        foreach( $this->getMethods() as $objMethodReflection )
        {
            if( $objMethodReflection->getName() == '__construct' )
            {
                $boolHasConstructor = true;
            }
            if( $objMethodReflection->getName() == '__destruct' )
            {
                $boolHasDestructor = true;
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
        if( $boolHasDestructor == false )
        {
            $strCode .=	' public function __destruct()                                                                 ' . "\n";
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
