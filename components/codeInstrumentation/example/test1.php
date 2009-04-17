<?php
require_once( "_start.php" );

/**
 * This test will consist into show the code of the new class 
 * based no the original class what is into a eval command
 */

$strBigFile = '

class iWillExtend{}
class iWillParameter{}
interface iWillInterfaceOne{}
interface iWillInterfaceTwo{}

class ExampleNoop extends iWillExtend implements iWillInterfaceOne, iWillInterfaceTwo
{
	private $strName;
	
	static protected $arrStuffs = array();
	
	/**
	 * Will do something cool
	 */
	final public function doSomethingCool( $strName = "hi" , iWillParameter $obSecond = null , iWillParameter $objLastOne = null  )
	{
		$this->strName = $strName;
		print "i change the name to " . $this->strName;
		$this->doNothing();
	}
	
	private static function doNothing()
	{
		// empty...
	}
	
	public function hardWork()
	{
		for( $i = 0 ; $i < 20 ; $i++ )
		{
			$this->doSomethingCool( $i );
		}
	}
};
';

eval( $strBigFile );

// call the debug reflection send into the second parameter the eval content //
$oReflectionCode = new CodeInstrumentationClass( "ExampleNoop" , $strBigFile );
$strNewCode = $oReflectionCode->getCode();
print( $strNewCode );
?>