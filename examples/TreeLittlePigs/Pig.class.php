<?php

class LittlePig {

    protected $strName;
    protected $objHouse;

    public function say( $strText )
    {

    }
    
    public function setName( $strName )
    {
        $this->strName = $strName;
    }

    public function buildHouse( $strType )
    {
        $objHouse = new House();
        $objHouse->setType( $strType );
        $this->objHouse = $objHouse;
        $this->objHouse->setPig( $this );
    }

    public function getHouse()
    {
        return $this->objHouse;
    }
    
    public function happyEverAfter()
    {
        
    }

    public function isEaten()
    {

    }

    public function isKilled()
    {

    }

    public function wakeUpBy( Wolf $objWolf )
    {
        $objWolf->isKilled();
        $this->happyEverAfter();
    }
}
?>