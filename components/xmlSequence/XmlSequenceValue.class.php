<?php
/**
 * Object with the values send into the message
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @package XmlSequence
 */
class XmlSequenceValue
{
    /**
     * Name of the attribute
     *
     * @var string
     */
    protected $strName;

    /**
     * Value of the attribute
     *
     * @var string
     */
    protected $strValue;

    /**
     * Set the name of the attribute value
     *
     * @see XmlSequenceValue::getName()
     * @see XmlSequenceValue->strName
     * @param string $strName
     * @return XmlSequenceValue me
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
        return $this;
    }

    /**
     * set the name of the attribute value
     *
     * @see XmlSequenceValue::setName( string )
     * @see XmlSequenceValue->strName
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the value of the attribute 
     *
     * @see XmlSequenceValue::getValue()
     * @see XmlSequenceValue->strValue
     * @param string $strValue
     * @return XmlSequenceValue me
     */
    public function setValue( $strValue )
    {
        $this->strValue = $strValue;
        return $this;
    }

    /**
     * set the value of the attribute 
     *
     * @see XmlSequenceValue::setValue( string )
     * @see XmlSequenceValue->strValue
     * @return string
     */
    public function getValue()
    {
        return $this->strValue;
    }
}

?>
