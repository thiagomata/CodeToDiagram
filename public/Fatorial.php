<?php

class Fatorial
{
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
