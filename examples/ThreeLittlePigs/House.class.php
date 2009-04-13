<?php

class House
{
    protected $strType;

    protected $objPig;

    protected $booIsColapsed = false;

   
    public function setType( $strType )
    {
        $this->strType = $strType;
    }

    public function getType()
    {
        return $this->strType;
    }
    
    public function colapse()
    {
        $this->booIsColapsed = true;
    }

    public function isColapsed()
    {
        return $this->booIsColapsed;
    }
    
    public function setPig( LittlePig $objPig )
    {
        $this->objPig = $objPig;
    }

    public function getBlowBy( Wolf $objWolf )
    {
        if( $this->getType() == "Brick" )
        {
            $this->getPig()->wakeUpBy( $objWolf );
            return false;
        }
        else
        {
            $this->colapse();
            return true;
        }
    }
    
    /**
     *
     * @return LittlePig
     */
    public function getPig()
    {
        return $this->objPig;
    }
}
?>