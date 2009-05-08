<?php
/**
 * UmlSequenceDiagramValue - UML Object of the Sequence Diagram Message Value
 *
 * Uml Sequence Diagramas have messages what have values
 * @package UmlSequenceDiagram
 */

/**
 * Object with the values send into the message
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlSequenceDiagramValue
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
     * @see UmlSequenceDiagramValue::getName()
     * @see UmlSequenceDiagramValue->strName
     * @param string $strName
     * @return UmlSequenceDiagramValue me
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
        return $this;
    }

    /**
     * set the name of the attribute value
     *
     * @see UmlSequenceDiagramValue::setName( string )
     * @see UmlSequenceDiagramValue->strName
     * @return string
     */
    public function getName()
    {
        return $this->strName;
    }

    /**
     * Set the value of the attribute 
     *
     * @see UmlSequenceDiagramValue::getValue()
     * @see UmlSequenceDiagramValue->strValue
     * @param string $strValue
     * @return UmlSequenceDiagramValue me
     */
    public function setValue( $strValue )
    {
        $this->strValue = $strValue;
        return $this;
    }

    /**
     * set the value of the attribute 
     *
     * @see UmlSequenceDiagramValue::setValue( string )
     * @see UmlSequenceDiagramValue->strValue
     * @return string
     */
    public function getValue()
    {
        return $this->strValue;
    }
}
?>