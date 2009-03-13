<?php

/**
 * Class with methods for array manipulation
 */
class CorujaArrayManipulation
{

	/**
	 * Returns the value of $mixKey key of $arrElement array or
	 * $mixNotFound in case the key doesn't exist
	 *
	 * @param Array $arrElement Array under manipulation
     * @param unknown  $mixKey Key of desired value
     * @param unknown $mixNotFound Value returned in case the key was not found
	 * @return unknown Field value
	 * @example $arrEx = array('a','b'); CorujaArrayManipulation::getArrayField($arrEx,1); // returns 'b'
	 *
	 * @assert ( array( "a" => 1 , "b" => 2 ) , "a" ) = 1
	 * @assert ( array( "a" => 1 , "b" => 2 ) , "x" ) = null
	 * @assert ( array( "a" => new stdClass() , "b" => new stdClass() ) , new stdClass() ) = new stdClass()
	 * @assert ( array() , "something" ) = null
	 * @assert ( array() , "something" , "nothing" ) = "nothing"
	 */
	public static function getArrayField( array $arrElement, $mixKey, $mixNotFound = null )
	{
		if ( array_key_exists( $mixKey , $arrElement ) )
		{
			return $arrElement[ $mixKey ];
		}
		else
		{
			return $mixNotFound;
		}
	}

}


?>
