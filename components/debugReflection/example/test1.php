<?
require_once( "_start.php" );

/**
 * This test will consist into show the code of the new class 
 * based no the original class what is into a eval command
 */

$strBigFile = '

class exampleFirst{}
class exampleSecond{}
interface exampleInterfaceOne{}
interface exampleInterfaceTwo{}

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
};
';

eval( $strBigFile );

// call the debug reflection send into the second parameter the eval content //
$oReflectionCode = new DebugReflectionClass( "ExampleCodeReflecion" , $strBigFile );
$strNewCode = $oReflectionCode->getCode();
CorujaDebug::debug( $strNewCode , true , "php");
?>