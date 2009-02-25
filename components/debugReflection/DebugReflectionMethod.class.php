<?php
class DebugReflectionMethod extends CodeReflectionMethod
{
	public function getNewName()
	{
		return "___" . $this->getName();
	}
	
	public function getCallDebugFunctionName()
	{
		return $this->getName();
	}

	protected function getCallDebugFunctionCode()
	{
		$strCode = "";
		$strCode .= $this->getCallDebugFunctionHeaderCode();
		$strCode .= "{" . "\n";
		$strCode .= $this->getCallDebugFunctionContentCode();
		$strCode .= "}" . "\n";
		return $strCode;
	}
	
	protected function getCallDebugFunctionHeaderCode()
	{
		$strCode = CorujaStringManipulation::retab( $this->getDocComment() , 1 );
		$strCode .= $this->createModifiersCode();
		$strCode .= " function " . $this->getCallDebugFunctionName() . "()";
		return $strCode;
	}
	
	protected function getCallDebugFunctionContentCode()
	{
		$strCode = "";
		$strCode .=	'	$strMethod = "' . $this->getNewName() . '";										' . "\n";
		$strCode .=	'	$arrArguments = func_get_args();												' . "\n";	
		$strCode .=	'	// prepare caller //															' . "\n";
		if( $this->isStatic() )
		{
			$strCode .=	'	$arrCaller = Array( __CLASS__ , $strMethod ) ; 								' . "\n";
            $strCode .=	'	// log the enter into the real method //										' . "\n";
            $strCode .=	'	DebugRefletionReceiver::getInstance()->onEnterMethod( "static" , __CLASS__ , __METHOD__ , $arrArguments );' . "\n";
            $strCode .=	'	// execute the real method														' . "\n";
            $strCode .=	'	$mixReturn = call_user_func_array( $arrCaller, $arrArguments );					' . "\n";
            $strCode .=	'	// log the exit of the real method // 											' . "\n";
            $strCode .=	'	DebugRefletionReceiver::getInstance()->onLeaveMethod( "static" , __CLASS__ , __METHOD__ , $mixReturn    );' . "\n";
            $strCode .=	'	// return the result of the method into the object  //							' . "\n";
            $strCode .=	'	return $mixReturn;																' . "\n";
		}
		else
		{
			$strCode .=	'	$arrCaller = Array( $this , $strMethod ) ; 									' . "\n";
            $strCode .=	'	// log the enter into the real method //										' . "\n";
            $strCode .=	'	DebugRefletionReceiver::getInstance()->onEnterMethod( spl_object_hash($this) , __CLASS__ , __METHOD__ , $arrArguments );' . "\n";
            $strCode .=	'	// execute the real method														' . "\n";
            $strCode .=	'	$mixReturn = call_user_func_array( $arrCaller, $arrArguments );					' . "\n";
            $strCode .=	'	// log the exit of the real method // 											' . "\n";
            $strCode .=	'	DebugRefletionReceiver::getInstance()->onLeaveMethod( spl_object_hash($this) , __CLASS__ , __METHOD__ , $mixReturn    );' . "\n";
            $strCode .=	'	// return the result of the method into the object  //							' . "\n";
            $strCode .=	'	return $mixReturn;																' . "\n";
		}

		return $strCode;
	}
	
	public function getCode()
	{
		$strCode = "";
		$strCode .= $this->getCallDebugFunctionCode();
		$strCode .= parent::getCode();
		return $strCode;
		
	}
	
	protected function createMethodHeaderCode()
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
		return new DebugReflectionClass( $objOriginalReflectionClass->getName() );
	}
	
	protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
	{
		return new DebugReflectionParameter( Array( $this->getDeclaringClass()->getName() , $this->getName() ) , $objReflectionParameter->getName() );
	}
	
	protected function createMethodContentCode()
	{
		$strCode = "";
		
		$objDebugFile = DebugReflectionFile::getDebugFileName( $this->getFileName() );
		$strCode .= $objDebugFile->getFileBit( $this->getStartLine() , $this->getEndLine() );
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