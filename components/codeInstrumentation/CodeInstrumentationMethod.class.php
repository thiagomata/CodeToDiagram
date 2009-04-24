<?php
/**
 * Class what in place of create the exactly code of some method,
 * create a version of it what send a message to the code instrumentation
 * receiver before and after each call.
 *
 * @author Thiago Mata
 */
class CodeInstrumentationMethod extends CodeReflectionMethod
{
    /**
     * The original method should be renamed. This is the new prefix what will be
     * append into it's name.
     */
    const PREFIX_METHOD = "___";

    /**
     * Returns the new name of the original method.
     * '
     * @return string
     */
    public function getNewName()
    {
        return self::PREFIX_METHOD . $this->getName();
    }

    /**
     * Returns de name of the code instrumentation method name what will be append into the class
     *
     * @return string
     */
    public function getCallCodeInstrFunctionName()
    {
        return $this->getName();
    }

    /**
     * Returns the code instrumentation method content what will be append into the class
     *
     * @return string
     */
    protected function getCallCodeInstrFunctionCode()
    {
        $strCode = "";
        $strCode .= $this->getCallCodeInstrFunctionHeaderCode();
        $strCode .= "{" . "\n";
        $strCode .= $this->getCallCodeInstrFunctionContentCode();
        $strCode .= "}" . "\n";
        return $strCode;
    }

    /**
     * Get the code instrumentation header of the method what will be append into
     * the class
     *
     * @return string
     */
    protected function getCallCodeInstrFunctionHeaderCode()
    {
        $strCode = CorujaStringManipulation::retab( $this->getDocComment() , 1 );
        $strCode .= $this->createModifiersCode();
        $strCode .= " function " . $this->getCallCodeInstrFunctionName();
        $strCode .= $this->createParametersCode();
        return $strCode;
    }

    /**
     * Get the code instrumentation content of the method what will be append into
     * the class
     *
     * 1. create the method header
     * 2. if the method is a static one
     * 2.1 log the enter method into the code instrumentation receiver as a static call
     * 2.2 run method
     * 2.3 log the leave method into the code instrumentation receiver as a static call
     * 3. else - if the method is not a static one
     * 3.1 log the enter method into the code instrumentation receiver sending the object id
     * 3.2 if the method is the magic method __call
     * 3.2.1 when some undefined method be called log the call and call the original __call
     * 3.3 else - if the method is not the magic method __call
     * 3.3.1 save the call into the code instrumentation receiver and call the original method
     * 3.4 log the leave method into the code instrumentation receiver sending the object id
     * 
     * @return string
     */
    protected function getCallCodeInstrFunctionContentCode()
    {
		// 1. create the method header //
        $strCode = "";
        $strCode .=	'	$strMethod = "' . $this->getNewName() . '";										' . "\n";
        $strCode .=	'	$arrArguments = func_get_args();												' . "\n";
        $strCode .=	'	// prepare caller //															' . "\n";
        
        // 2. if the method is a static one //
        if( $this->isStatic() )
        {
		     // 2.1 log the enter method into the code instrumentation receiver as a static call
            $strCode .=	'	$arrCaller = Array( __CLASS__ , $strMethod ) ; 								' . "\n";
            $strCode .=	'	// log the enter into the real method //										' . "\n";
            $strCode .=	'	CodeInstrumentationReceiver::getInstance()->onEnterMethod( "static" , __CLASS__ , __METHOD__ , $arrArguments );' . "\n";

            // 2.2 run method
            $strCode .=	'	// execute the real method														' . "\n";
            $strCode .=	'	$mixReturn = call_user_func_array( $arrCaller, $arrArguments );					' . "\n";

		    // 2.3 log the leave method into the code instrumentation receiver as a static call
            $strCode .=	'	// log the exit of the real method // 											' . "\n";
            $strCode .=	'	CodeInstrumentationReceiver::getInstance()->onLeaveMethod( "static" , __CLASS__ , __METHOD__ , $mixReturn    );' . "\n";
            $strCode .=	'	// return the result of the method into the object  //							' . "\n";
            $strCode .=	'	return $mixReturn;																' . "\n";
        }
        // 3. else - if the method is not a static one //
        else
        {
        	// 3.1 log the enter method into the code instrumentation receiver sending the object id //
            $strCode .=	'	$arrCaller = Array( $this , $strMethod ) ;                                      ' . "\n";
            $strCode .=	'	// log the enter into the real method //                                        ' . "\n";
            $strCode .=	'	CodeInstrumentationReceiver::getInstance()->onEnterMethod( spl_object_hash($this) , __CLASS__ , __METHOD__ , $arrArguments );' . "\n";
            $strCode .=	'	// execute the real method                                                      ' . "\n";
            
            // 3.2 if the method is the magic method __call //
            if( $this->getName() == "__call" )
            {
            	// 3.2.1 when some undefined method be called log the call and call the original __call //
                $strCode .=	'	// if the method exists     													' . "\n";
                $strCode .=	'	if( method_exists( $this , $strMethod ) )										' . "\n";
                $strCode .=	'	{                                                                               ' . "\n";
                $strCode .=	'	    // call the real method                                                     ' . "\n";
                $strCode .=	'       $mixReturn = call_user_func_array( $arrCaller, $arrArguments );				' . "\n";
                $strCode .=	'	}                                                                              	' . "\n";
                $strCode .=	'	else                                                                            ' . "\n";
                $strCode .=	'	{                                                                               ' . "\n";
                $strCode .=	'	    // exists in the original class a __call method //                          ' . "\n";
                $strCode .=	'	    if( method_exists( $this , "' . self::PREFIX_METHOD . '__call" ) )                                   ' . "\n";
                $strCode .=	'	    {                                                                           ' . "\n";
                $strCode .=	'	        // call it //                                                           ' . "\n";
                $strCode .=	'	        $mixReturn = $this->' . self::PREFIX_METHOD . '__call( $strMethod , $arrArguments );                          ' . "\n";
                $strCode .=	'	    }                                                                           ' . "\n";
                $strCode .=	'	    else                                                                           ' . "\n";
                $strCode .=	'	    {                                                                           ' . "\n";
                $strCode .=	'           throw new CodeToDiagramException( "Unable to find the method $strMethod "); ' . "\n";
                $strCode .=	'	    }                                                                           ' . "\n";
                $strCode .=	'	}                                                                               ' . "\n";
            }
            // 3.3 else - if the method is not the magic method __call //
            else
            {
            	//  3.3.1 save the call into the code instrumentation receiver and call the original method //
                $strCode .=	'	// if the method exists     													' . "\n";
                $strCode .=	'	if( method_exists( $this , $strMethod ) )										' . "\n";
                $strCode .=	'	{                                                                               ' . "\n";
                $strCode .=	'	    // call the real method                                                     ' . "\n";
                $strCode .=	'       $mixReturn = call_user_func_array( $arrCaller, $arrArguments );				' . "\n";
                $strCode .=	'	}                                                                              	' . "\n";
                $strCode .=	'	else                                                                            ' . "\n";
                $strCode .=	'	{                                                                               ' . "\n";
                $strCode .=	'       throw new CodeToDiagramException( "Unable to find the method $strMethod "); ' . "\n";
                $strCode .=	'	}                                                                               ' . "\n";
            }
            // 3.4 log the leave method into the code instrumentation receiver sending the object id
            $strCode .=	'	// log the exit of the real method // 											' . "\n";
            $strCode .=	'	CodeInstrumentationReceiver::getInstance()->onLeaveMethod( spl_object_hash($this) , __CLASS__ , __METHOD__ , $mixReturn    );' . "\n";
            $strCode .=	'	// return the result of the method into the object  //							' . "\n";
            $strCode .=	'	return $mixReturn;																' . "\n";
        }

        return $strCode;
    }

    /**
     * Get the code of the code instrumentation method
     *
     * @return string
     */
    public function getCode()
    {
        $strCode = "";
        $strCode .= $this->getCallCodeInstrFunctionCode();
        $strCode .= parent::getCode();
        return $strCode;

    }

    /**
     * Get the method header of the code instrumentation method 
     *
     * @return string
     */
    public function createMethodHeaderCode()
    {
        $strCode = $this->getDocComment();
        $strCode .= $this->createModifiersCode();
        $strCode .= " function ";
        $strCode .= $this->getNewName();
        $strCode .= $this->createParametersCode();
        return CorujaStringManipulation::retab( $strCode , 1 );
    }

    /**
     * make the class calls return a code instrumentation class
     *
     * @see ExtendedReflectionMethod
     * @param ReflectionClass $objOriginalReflectionClass
     * @return CodeInstrumentationClass
     */
    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
    {
        return new CodeInstrumentationClass( $objOriginalReflectionClass->getName() );
    }

    /**
     * make the parameters calls return a Code Instrumentation Parameter
     *
     * @see ExtendedReflectionMethod::createExtendedReflectionParameter
     * @param ReflectionParameter $objReflectionParameter
     * @return CodeInstrumentationParameter
     */
    protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
    {
        return new CodeInstrumentationParameter( Array( $this->getDeclaringClass()->getName() , $this->getName() ) , $objReflectionParameter->getName() );
    }

    /**
     * Create the code instrumentation method content code 
     *
     * @return string
     */
    protected function createMethodContentCode()
    {
        $strCode = "";

        $objCodeInstrFile = CodeReflectionFile::getCodeInstrFileName( $this->getFileName() );
        $strCode .= $objCodeInstrFile->getFileBit( $this->getStartLine() , $this->getEndLine() );
        $strCode = trim( $strCode );

        if( strlen( $strCode ) == 0 )
        {
            return $strCode;
        }
        
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
