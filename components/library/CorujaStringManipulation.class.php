<?php

/**
 * Class for string manipulations
 */
class CorujaStringManipulation
{

    /**
     * Special string casting for boolean
     *
     * @param string $strText String to be turned into boolean
     * @return boolean Input casting
	 * @throws InvalidArgumentException If $strText is not string
     * @example strToBool("false") // returns false
     * 
	 * @assert ("") == false
	 * @assert ("false") == false
	 * @assert ("FaLsE") == false
	 * @assert ("0") == false
	 * 
	 * @assert ("a0a") == true
	 * @assert ("true") == true
	 * @assert ("1") == true
	 *  
	 * @assert (null) throws InvalidArgumentException
	 * @assert (123) throws InvalidArgumentException
	 * @assert (array()) throws InvalidArgumentException
	 * @assert (new stdClass()) throws InvalidArgumentException
	 * @assert (false) throws InvalidArgumentException
     *  
     */    
	public static function strToBool( $strText )
	{
		if(!is_string($strText))
		{
			throw new InvalidArgumentException("Invalid argument [ ". var_export($strText) ." ]. It should be string");
		}
		
		$strText = strtolower( $strText );
		if ( $strText === "false" || $strText === "" || $strText === "0" )
		{
			return( false );
		}
		return( true );
	}

	/**
	 * Get number chars inside a string
	 *
	 * @param string $strText Text with numbers
	 * @return int Numbers in the string
	 * @throws InvalidArgumentException If $strText is not string
	 * @example forceInt("a1b2c3d4") // returns 1234
	 * 
	 * @assert ("a1b2c3d4") == 1234
	 * @assert ("") == 0
	 * @assert ("a0a") == 0
	 * @assert ("001") == 1
	 * @assert ("abc") == 0
	 * @assert ("a-10") == 10
	 * 
	 * @assert ("-10") == -10
	 * @assert ("--10") == -10
	 * @assert ("-a-b-1-0-") == -10
	 * 
	 * @assert (null) throws InvalidArgumentException
	 * @assert (123) throws InvalidArgumentException
	 * @assert (array()) throws InvalidArgumentException
	 * @assert (new stdClass()) throws InvalidArgumentException
	 * @assert (false) throws InvalidArgumentException
	 *  
	 */
	public static function forceInt( $strText )
	{
		if(!is_string($strText))
		{
			throw new InvalidArgumentException("Invalid argument [ ". var_export($strText) ." ]. It should be string");
		}
		
		$arrNum = Array( "0","1","2","3","4","5","6","7","8","9");
		$strResult = "";
		for( $i = 0; $i < strlen( $strText ); ++$i )
		{
			$charLetra = $strText[$i];
			if( $i == 0 && $charLetra == "-" )
			{
				$strResult .= $charLetra;
			}
			if( in_array($charLetra,$arrNum))
			{
				$strResult .= $charLetra;
			}
		}
		return $strResult += 0;
	}

	/**
	 * Change string case standard
	 *
	 * @param string $strFieldName Name in camel case
	 * @return string Name in underline separated case
	 * @throws InvalidArgumentException If $strText is not string
	 * @example 
	 * CorujaStringManipulation::caseTabUnderlineTab("nameOfTheParameter")
	 * // returns "NAME_OF_THE_PARAMETER"
	 * 
	 * @assert ("test") == "TEST"
	 * @assert ("somethingCool") == "SOMETHING_COOL"
	 * @assert ("") == ""
	 * @assert ("1something2Cool3") == "1SOMETHING2_COOL3"
	 * @assert ("111something2222Cool333") == "111SOMETHING2222_COOL333"
	 * 
	 * @assert (null) throws InvalidArgumentException
	 * @assert (123) throws InvalidArgumentException
	 * @assert (array()) throws InvalidArgumentException
	 * @assert (new stdClass()) throws InvalidArgumentException
	 * @assert (false) throws InvalidArgumentException
	 */
	public static function camelCaseToUnderlineCase( $strText )
	{
		if(!is_string($strText))
		{
			throw new InvalidArgumentException("Invalid argument [ ". var_export($strText) ." ]. It should be string");
		}
		
		$arrFind = Array( "A" , "B" , "C" , "D" , "E" , "F" , "G" , "H" , "I" , "J" , "K" , "L" , "M" , "N" , "O" ,
					  "P" , "Q" , "R" , "S" , "T" , "U" , "V" , "X" , "Z" , "W" , "Y"	);

		$arrReplace = Array( "_A" , "_B" , "_C" , "_D" , "_E" , "_F" , "_G" , "_H" , "_I" , "_J" , "_K" , "_L" , "_M" ,
					  "_N" , "_O" , "_P" , "_Q" , "_R" , "_S" , "_T" , "_U" , "_V" , "_X" , "_Z" , "_W" , "_Y"	);

		if( strlen( $strText ) > 0 )
		{
			$strText[0] = strtolower($strText[0]);
		}

		return strtoupper( str_replace( $arrFind , $arrReplace , $strText ) );
	}

	public static function retab( $strText , $intDeeper )
	{
		$arrText = explode( "\n" , $strText );
		foreach( $arrText as $intKey => $strTextElement)
		{
			$arrText [ $intKey ] = trim( $strTextElement );
		}
		$strTab = "\n" .str_repeat( "\t" , $intDeeper );
		$strText = $strTab . implode( $strTab , $arrText ) . $strTab;
		return $strText;
	}

}

?>
