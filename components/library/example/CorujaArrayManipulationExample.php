<?php
require_once( "_start.php" );
$arrExample = Array( "first" => 1 , "second" => 2 , "third" => 3); 

print 'CorujaArrayManipulation::getArrayField( $arrExample , "first" ) = 					' . var_export( CorujaArrayManipulation::getArrayField( $arrExample , "first" ) , true ) . "<br/>\n"; 
print 'CorujaArrayManipulation::getArrayField( $arrExample , "notfound" ) =				  	' . var_export( CorujaArrayManipulation::getArrayField( $arrExample , "notfound" ) , true ) . "<br/>\n"; 
print 'CorujaArrayManipulation::getArrayField( $arrExample , "notfound" , "newdefault") = 	' . var_export( CorujaArrayManipulation::getArrayField( $arrExample , "notfound" , "newdefault") , true ) . "<br/>\n"; 
?>