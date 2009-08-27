<?php
/**
 * @package examples
 * @subpackage Fatorial
 */

/**
 * Fatorial Example
 * 
 * Class of the math fatorial function to be used into
 * the sequence diagram
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class Fatorial
{
    /**
     * calc the fatorial of the value received
     *
     * @assert( 0 ) == 1
     * @assert( 2 ) == 2
     * @assert( 4 ) == 24
     * @param integer $n
     * @return integer
     */
    public static function play( $n )
    {
        if(  $n < 0 )
        {
            throw new Exception( "invalid factorial value" );
        }

       if ( $n == 0 )
        {
            return 1;
        }
        else
        {
            return $n * self::play( $n - 1 );
        }
     }

}

?>
