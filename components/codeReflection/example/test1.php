<?
require_once( "_start.php" );

/**
 * This example will consist into change the content of some methods using the debug reflection
 * and namespaces.
 * 
 */

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

$oReflectionCode = new CodeReflectionClass( "ExampleCodeReflecion" );
$strNewCode = $oReflectionCode->getCode();
CorujaDebug::debug( $strNewCode, true, "php" );

?>