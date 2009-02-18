<?php
class XmlSequenceActor
{
    protected $intId;

    protected $strType;

    protected $strName;

    public function getId() {
        return $this->intId;
    }

    public function setId($intId) {
        $this->intId = $intId;
    }

    public function getType() {
        return $this->strType;
    }

    public function setType($strType) {
        if( !in_array( $strType, Array( 'user' , 'system' ) ) )
        {
            throw new Exception( "Invalid type of user " . $strType );
        }

        $this->strType = $strType;
    }

    public function getName() {
        return $this->strName;
    }

    public function setName($strName) {
        $this->strName = $strName;
    }
}

?>