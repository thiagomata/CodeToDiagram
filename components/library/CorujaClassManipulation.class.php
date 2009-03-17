<?php

/**
 * Class for manipulation of classes
 */
class CorujaClassManipulation
{

        /**
         * Return classe name from class definition
         *
         * @param String $strClassDefinition Class definition
         * @return String Class name
         * @example getClassNameFromClassDefinition( "myNamespace::myClass" ); // returns "myClass"
         *
         * @assert ( "myNamespace::myClass" ) = "myClass"
         * @assert ( "myClass" ) = "myClass"
         * @assert ( "" ) = ""
         *
		 * @assert (null) throws InvalidArgumentException
		 * @assert (123) throws InvalidArgumentException
		 * @assert (array()) throws InvalidArgumentException
		 * @assert (new stdClass()) throws InvalidArgumentException
		 * @assert (false) throws InvalidArgumentException
         */
	public static function getClassNameFromClassDefinition( $strClassDefinition )
	{
		if(!is_string($strClassDefinition))
		{
			throw new InvalidArgumentException("Invalid argument [ ". var_export($strClassDefinition) ." ]. It should be string");
		}

        $arrClassDefinition = explode( "::" , $strClassDefinition );
		return array_pop( $arrClassDefinition );
	}

        /**
         * Return namespace from class definition
         *
         * @param String $strClassDefinition Class definition
         * @return String Namespace
         * @example getClassNameFromClassDefinition( "myNamespace::myClass" ); // returns "myNamespace"
         *
         * @assert ( "myNamespace::myClass" ) = "myNamespace"
         * @assert ( "myClass" ) = ""
         * @assert ( "" ) = ""
         *
		 * @assert (null) throws InvalidArgumentException
		 * @assert (123) throws InvalidArgumentException
		 * @assert (array()) throws InvalidArgumentException
		 * @assert (new stdClass()) throws InvalidArgumentException
		 * @assert (false) throws InvalidArgumentException
		 *
		 */
	public static function getNamespaceFromClassDefinition( $strClassDefiniton )
	{
		if(!is_string($strClassDefiniton))
		{
			throw new InvalidArgumentException("Invalid argument [ ". var_export($strClassDefiniton) ." ]. It should be string");
		}

		return CorujaArrayManipulation::getArrayField( explode( "::" , $strClassDefiniton )  , 1 , "" );
	}

}

?>
