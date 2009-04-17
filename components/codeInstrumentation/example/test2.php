<?php
require_once( "_start.php" );

/**
 * This test will consist into show the code of the new class
 * based no the original class what is into a eval command
 */

$strBigFile = '
class ExampleSimple
{
    public function __construct()
    {
        print "i am";
    }
};
';

eval( $strBigFile );

// call the debug reflection send into the second parameter the eval content //
$oReflectionCode = new CodeInstrumentationClass( "ExampleSimple" , $strBigFile );
$oReflectionCode->setClassName( "SomethingElse" );
$strNewCode = $oReflectionCode->getCode();
eval( $strNewCode );
$objNewCode = new CodeReflectionClass( "SomethingElse" , $strNewCode );
print $objNewCode->getMethod( CodeInstrumentationMethod::PREFIX_METHOD . "__construct" )->getCodeContent();
?>