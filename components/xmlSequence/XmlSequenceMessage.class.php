<?php

class XmlSequenceMessage
{
    protected $strText = null;

    protected $strType = null;

    protected $objActorFrom = null;

    protected $objActorTo = null;

    protected $arrValues = Array();

    protected $intTimeStart;

    protected $intTimeEnd;

    public function setText( $strText )
    {
        $this->strText = $strText;
    }

    public function getText()
    {
        return $this->strText;
    }

    public function setType( $strType )
    {
        if( !in_array( $strType, Array( 'call' , 'return' ) ) )
        {
            throw new Exception( "Invalid type of message " . $strType );
        }
        $this->strType = $strType;
    }

    public function getType()
    {
        return $this->strType;
    }

    public function setActorFrom( XmlSequenceActor $objActor )
    {
        $this->objActorFrom = $objActor;
    }

    public function getActorFrom()
    {
        return $this->objActorFrom;
    }

    public function setActorTo( XmlSequenceActor $objActor )
    {
        $this->objActorTo = $objActor;
    }

    public function getActorTo()
    {
        return $this->objActorTo;
    }

    public function setValues( Array $arrValues )
    {
        $this->arrValues = $arrValues;
    }

    public function getValues()
    {
        return $this->arrValues;
    }

    public function addValue( XmlSequenceValue $objValue )
    {
        $this->arrValues[] = $objValue;
    }

    public function isReverse()
    {
        return ( $this->objActorFrom->getId() > $this->objActorTo->getId() );
    }

    public function isLarge()
    {
        return ( abs( $this->objActorFrom->getId() - $this->objActorTo->getId() ) > 1 );
    }

    public function isRecursive()
    {
        return( $this->objActorFrom->getId() == $this->objActorTo->getId() );
    }

    public function showValues()
    {
        if( sizeof( $this->arrValues ) > 0 )
        {
            $strHtml = '<div class="parameters">';
            $strHtml .= '<ul>' . "\n";

            foreach( $this->arrValues as $objValue )
            {
                $strHtml .= '<li>' . "\n";
                $strHtml .= '   <strong>' . $objValue->getName() . '</strong>' . "\n";
                $strHtml .= '   ' . $objValue->getValue() . ' ' . "\n";
                $strHtml .= '</li>' . "\n";

            }

            $strHtml .= '</ul></div>' . "\n";
        }
        else
        {
            $strHtml = '';
        }
        return $strHtml;
    }

    public function setTimeStart( $intTime )
    {
        $this->intTimeStart = $intTime;
    }

    public function getTimeStart()
    {
        return $this->intTimeStart;
    }

    public function setTimeEnd( $intTime )
    {
        $this->intTimeEnd = $intTime;
    }

    public function getTimeEnd()
    {
        return $this->intTimeEnd;
    }

    public function getTimeDuration()
    {
        return $this->intTimeEnd - $this->intTimeStart;
    }
}

?>
