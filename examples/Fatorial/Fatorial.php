<?php
/**
 * Class of the math fatorial function to be used into
 * the sequence diagram
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @package examples
 * @subpackage Fatorial
 */
class Fatorial
{
    /**
     * calc the fatorial of the value received
     *
     * @param integer $n
     * @return integer
     */
    public static function play( $n )
    {
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
