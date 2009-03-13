<?php
class Wolf
{
    public function say( $strText )
    {

    }

    public function huff()
    {

    }

    public function puff()
    {

    }

    public function blowIt( House $objHouse )
    {
        if( $objHouse->getBlowBy( $this ) )
        {
            $objPig = $objHouse->getPig();
            $objPig->isKilled();
            $objPig->isEaten();
        }
    }

    public function isKilled()
    {
        
    }
}
?>
