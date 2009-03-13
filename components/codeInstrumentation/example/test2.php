<?php
require_once( "_start.php" );

/**
 * This test will consist into change the content of some methods using the debug reflection
 * and namespaces. The change will send informations to log about what method is called when
 * and how. This informations are condesed into a xml log result.
 *
 * This test will work only into PHP 5.3 or older.
 */

// class required to the test class can work fine //
$strRequired = '
class exampleFirst{}
class exampleSecond{}
interface exampleInterfaceOne{}
interface exampleInterfaceTwo{}
';

// dinamyc class what will be changed //
$strDynamicContent = '
class ExampleCodeReflecion extends exampleFirst implements exampleInterfaceOne, exampleInterfaceTwo
{
	/**
	 * @something else
	 *
	 * @var string
	 */
	private $strName;

	static protected $arrParadas = array();

	/**
	 * Will do something cool
	 *
	 * @return string
	 */
	final public function doSomethingCool( $strName = "hi" , exampleSecond $obSecond = null , exampleSecond $objLastOne = null  )
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

	public function fat( $n )
	{
		if( $n <= 1 ) return 1;
		return $n  * $this->fat( $n - 1 );
	}

}
';

// creating the class into a temporary namespace //
// this is needed to the reflection load is attributes withou create the class into the real scope //

// changing the namespace //
$strNamespaceContent = "namespace temp; \n" . $strDynamicContent ;
$strNamespaceRequired = "namespace temp; \n" . $strRequired;
// eval the codes //
CorujaDebug::debug($strNamespaceRequired , false , "php" );
eval( $strNamespaceRequired );
CorujaDebug::debug($strNamespaceContent , false , "php" );
eval( $strNamespaceContent );

// creating the debug reflection of some class into another scope //
// it is necessary inform into the second parameter the eval content //
$oReflectionCode = new DebugReflectionClass( "temp::ExampleCodeReflecion" , $strNamespaceContent );

// getting the code of the new class //
$strNewCode = $oReflectionCode->getCode();

// show this code //
//debug( highlight_string( "<?" . "php" . $strNewCode ) );

// eval the required into the global scope //
CorujaDebug::debug( $strRequired , false , "php" );
eval( $strRequired );
// eval the new code into the global scope //
CorujaDebug::debug( $strNewCode  , false , "php" );
eval ( $strNewCode );

// make the object of the changed class perform some method //
$objTest = new ExampleCodeReflecion();
$objTest->fat(4);

// this method send informations to the log, what can now be read//
$strLog = DebugRefletionReceiver::showLog();

// show the log information about this execution //
CorujaDebug::debug( $strLog , false , "xml");
print $strLog;
?>