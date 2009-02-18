<?php

error_reporting( E_ALL );
ini_set( "display_errors" , "on" );

function getArrayElement( $arrElement , $strKey , $mixValueNotFound = null )
{
    if( array_key_exists( $strKey , $arrElement ) )
    {
        return $arrElement[ $strKey ];
    }
    else
    {
        return $mixValueNotFound;
    }
}

require_once( 'XmlSequenceActor.class.php' );
require_once( 'XmlSequenceMessage.class.php' );
require_once( 'XmlSequenceValue.class.php' );
require_once( 'XmlSequence.class.php' );

?>
