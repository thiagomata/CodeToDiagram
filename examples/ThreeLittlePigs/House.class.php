<?php
/**
 * House of the little pigs to the example of the code to diagram
 * 
 * @package examples
 * @subpackage ThreeLittlePigs
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class House
{
	/**
	 * Type of the house
	 * 
	 * @var string
	 */
    protected $strType;

    /**
     * Pig owner of the house
     * 
     * @var LittlePig 
     */
    protected $objPig;

    /**
     * This controlls if the house has colapsed
     * 
     * @var boolean
     */
    protected $booIsColapsed = false;

   	/**
   	 * Set the type of the house
   	 * 
   	 * @see House::getType()
   	 * @see House->strType
   	 * @param string $strType
   	 * @return House me
   	 */
    public function setType( $strType )
    {
        $this->strType = $strType;
        return $this;
    }

   	/**
   	 * get the type of the house
   	 * 
   	 * @see House::setType( string )
   	 * @see House->strType
   	 * @return string
   	 */
    public function getType()
    {
        return $this->strType;
    }
    
    /**
     * Make the house colapse
     * 
     * @return House me
     */
    public function colapse()
    {
        $this->booIsColapsed = true;
        return $this;
    }

    /**
     * Return <code>true</code> if the house
     * is colapsed and <code>false</code> if not
     * 
     * @return boolean
     */
    public function isColapsed()
    {
        return $this->booIsColapsed;
    }
    
    /**
     * Set the little pig owner of the house
     * 
     * @see House::getPig()
     * @see House->objPig
     * @param LittlePig $objPig
     * @return House me
     */
    public function setPig( LittlePig $objPig )
    {
        $this->objPig = $objPig;
        return $this;
    }

    /**
     * Get the little pig onwer of the house
     *
     * @see House::setPig( LittlePig )
     * @see House->objPig
     * @return LittlePig
     */
    public function getPig()
    {
        return $this->objPig;
    }

    /**
     * Receive a blow from the wolf.
     * 
     * If the house has the type "Brick" the
     * house dont colapse the the pig, owner
     * of the house it is waked up by the wolf
     * noise.
     * But, if the house has not, the house
     * colapse.
     * 
     * Return <code>true</code> if the house
     * is colapsed and <code>false</code> if not
     * 
     * @param Wolf $objWolf
     * @return boolean
     */
    public function getBlowBy( Wolf $objWolf )
    {
        if( $this->getType() == "Brick" )
        {
            $this->getPig()->wakeUpBy( $objWolf );
        }
        else
        {
            $this->colapse();
        }
        return $this->isColapsed();
    }
}
?>