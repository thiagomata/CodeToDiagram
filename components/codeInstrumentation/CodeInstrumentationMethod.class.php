<?php
class CodeInstrumentationMethod extends CodeReflectionMethod
{
    public function getNewName()
    {
        return "___" . $this->getName();
    }

    public function getCallCodeInstrFunctionName()
    {
        return $this->getName();
    }

    protected function getCallCodeInstrFunctionCode()
    {
        $strCode = "";
        $strCode .= $this->getCallCodeInstrFunctionHeaderCode();
        $strCode .= "{" . "\n";
        $strCode .= $this->getCallCodeInstrFunctionContentCode();
        $strCode .= "}" . "\n";
        return $strCode;
    }

    protected function getCallCodeInstrFunctionHeaderCode()
    {
        $strCode = CorujaStringManipulation::retab( $this->getDocComment() , 1 );
        $strCode .= $this->createModifiersCode();
        $strCode .= " function " . $this->getCallCodeInstrFunctionName();
        $strCode .= $this->createParametersCode();
        return $strCode;
    }

    protected function getCallCodeInstrFunctionContentCode()
    {
        $strCode = "";
        $strCode .=	'	$strMethod = "' . $this->getNewName() . '";										' . "\n";
        $strCode .=	'	$arrArguments = func_get_args();												' . "\n";
        $strCode .=	'	// prepare caller //															' . "\n";
        if( $this->isStatic() )
        {
            $strCode .=	'	$arrCaller = Array( __CLASS__ , $strMethod ) ; 								' . "\n";
            $strCode .=	'	// log the enter into the real method //										' . "\n";
            $strCode .=	'	CodeInstrumentationReceiver::getInstance()->onEnterMethod( "static" , __CLASS__ , __METHOD__ , $arrArguments );' . "\n";
            $strCode .=	'	// execute the real method														' . "\n";
            $strCode .=	'	$mixReturn = call_user_func_array( $arrCaller, $arrArguments );					' . "\n";
            $strCode .=	'	// log the exit of the real method // 											' . "\n";
            $strCode .=	'	CodeInstrumentationReceiver::getInstance()->onLeaveMethod( "static" , __CLASS__ , __METHOD__ , $mixReturn    );' . "\n";
            $strCode .=	'	// return the result of the method into the object  //							' . "\n";
            $strCode .=	'	return $mixReturn;																' . "\n";
        }
        else
        {
            $strCode .=	'	$arrCaller = Array( $this , $strMethod ) ; 									' . "\n";
            $strCode .=	'	// log the enter into the real method //										' . "\n";
            $strCode .=	'	CodeInstrumentationReceiver::getInstance()->onEnterMethod( spl_object_hash($this) , __CLASS__ , __METHOD__ , $arrArguments );' . "\n";
            $strCode .=	'	// execute the real method														' . "\n";
            $strCode .=	'	$mixReturn = call_user_func_array( $arrCaller, $arrArguments );					' . "\n";
            $strCode .=	'	// log the exit of the real method // 											' . "\n";
            $strCode .=	'	CodeInstrumentationReceiver::getInstance()->onLeaveMethod( spl_object_hash($this) , __CLASS__ , __METHOD__ , $mixReturn    );' . "\n";
            $strCode .=	'	// return the result of the method into the object  //							' . "\n";
            $strCode .=	'	return $mixReturn;																' . "\n";
        }

        return $strCode;
    }

    public function getCode()
    {
        $strCode = "";
        $strCode .= $this->getCallCodeInstrFunctionCode();
        $strCode .= parent::getCode();
        return $strCode;

    }

    public function createMethodHeaderCode()
    {
        $strCode = $this->getDocComment();
        $strCode .= $this->createModifiersCode();
        $strCode .= " function ";
        $strCode .= $this->getNewName();
        $strCode .= $this->createParametersCode();
        return CorujaStringManipulation::retab( $strCode , 1 );
    }

    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
    {
        return new CodeInstrumentationClass( $objOriginalReflectionClass->getName() );
    }

    protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
    {
        return new CodeInstrumentationParameter( Array( $this->getDeclaringClass()->getName() , $this->getName() ) , $objReflectionParameter->getName() );
    }

    protected function createMethodContentCode()
    {
        $strCode = "";

        $objCodeInstrFile = CodeInstrumentationFile::getCodeInstrFileName( $this->getFileName() );
        $strCode .= $objCodeInstrFile->getFileBit( $this->getStartLine() , $this->getEndLine() );
        $strCode = trim( $strCode );

        // remove the { }
        if( $strCode[0] == "{" )
        {
            $strCode = substr( $strCode , 1 );
        }

        $intLast = strlen( $strCode ) - 1;

        if( $strCode[$intLast] == "}" )
        {
            $strCode = substr( $strCode , 0     , -1);
        }
        return $strCode;
    }

}
?>
