<?php

class XmlSequenceValue
{
    protected $strName;

    protected $strValue;

    public function setName( $strName )
    {
        $this->strName = $strName;
    }

    public function getName()
    {
        return $this->strName;
    }

    public function setValue( $strValue )
    {
        $this->strValue = $strValue;
    }

    public function getValue()
    {
        return $this->strValue;
    }
}

?>
