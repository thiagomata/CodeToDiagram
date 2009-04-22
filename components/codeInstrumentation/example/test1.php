<?php
require_once( "_start.php" );


$strBigFile = '
class fatorial
{
    protected $n;

    public function __construct( $n )
    {
        $this->n = $n;
    }

    public function calc()
    {
        if ($this->n < 2)
        {
            return 1;
        }
        else
        {
            $objFat = new Fatorial( $this->n - 1 );
            return $this->n * $objFat->calc();
        }
    }
};
';

$strBigFile = str_replace( "class fatorial", "class temp_fatorial", $strBigFile );
eval( $strBigFile );
// call the debug reflection send into the second parameter the eval content //
$oReflectionCode = new CodeInstrumentationClass( "temp_fatorial" , $strBigFile );
$oReflectionCode->setClassName( "fatorial" );
$strNewCode = $oReflectionCode->getCode();
eval( $strNewCode );
define( "PUBLIC_PATH" , str_replace( "\\" , "/" , str_replace( basename( __FILE__ ) , "" , __FILE__ ) ) );
define( "CALLER_PATH" , str_replace( "\\" , "/" , str_replace( basename( __FILE__ ) , "" , __FILE__ ) ) );
CodeInstrumentationReceiver::getInstance()->restart();
$objTest = new fatorial( 2 );
$objTest->calc();
$objSimpleXml = simplexml_load_string( CodeInstrumentationReceiver::getInstance()->getXmlSequence()->createXml() );
print $objSimpleXml->asXml();
?>