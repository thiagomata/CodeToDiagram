<?php
require_once( "_start.php" );

/**
 * This test will consist into show the code of the new class
 * based no the original class what is into a eval command
 */

// 1. create a example class definiton 
$strOriginalClass = '
class ExampleSimple
{
    public function __construct()
    {
        print "i am";
    }
};
';

// 2. eval it
eval( $strOriginalClass );

// 3. create a code instrumentation of the example class
$oReflectionCode = new CodeInstrumentationClass( "ExampleSimple" , $strOriginalClass );

// 4. change the class name into the code instrumentation
$oReflectionCode->setClassName( "SomethingElse" );

// 5. get the code of the new class with code instrumentation
$strNewCode = $oReflectionCode->getCode();

// 6. eval it
eval( $strNewCode );

// 7. create a code reflection of both classes
$objOldCode = new CodeReflectionClass( "ExampleSimple" , $strOriginalClass );
$objNewCode = new CodeReflectionClass( "SomethingElse" , $strNewCode );

// 8. compare the old class construct method with the old class construct method
// with the new class construct method with prefix
print trim($objOldCode->getMethod( "__construct" )->getCodeContent() ) ==
trim( $objNewCode->getMethod( CodeInstrumentationMethod::PREFIX_METHOD . "__construct" )->getCodeContent() );
?>