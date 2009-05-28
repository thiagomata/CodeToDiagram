<?php
/**
 * LittlePig of the Three Little Pigs Example
 * @package examples
 * @subpackage ThreeLittlePigs
 */

/**
 * Little pigs of the example of the code to diagram
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class LittlePig {

	/**
	 * Little Pig name
	 * 
	 * @var string
	 */
    protected $strName;
    
    /**
     * Little Pig House
     * 
     * @var House
     */
    protected $objHouse;

    /**
     * The pig speak the received text
     * 
     * @param string $strText
     * @return LittlePig
     */
    public function say( $strText )
    {
        print "pig say: " . $strText . "<br/>\n";
        return $this;
    }
    
    /**
     * Set the Little Pig name
     * 
     * @param string $strName
     * @return LittlePig me
     */
    public function setName( $strName )
    {
        $this->strName = $strName;
        return $this;
    }

    /**
     * Make the Little Pig buid the house of the received type
     * 
     * @param string $strType type of the house
     * @return LittlePig me
     */
    public function buildHouse( $strType )
    {
        $objHouse = new House();
        $objHouse->setType( $strType );
        $this->objHouse = $objHouse;
        $this->objHouse->setPig( $this );
        return $this;
    }

    /**
     * Get the house of the little pig
     * 
     * @return House
     */
    public function getHouse()
    {
        return $this->objHouse;
    }
    
    /**
     * Little Pig celebrate the happy ever after
     * 
     */
    public function happyEverAfter()
    {
    	$this->say( "i am happy ever after!" );
    }

    /**
     * Little pig it is eaten
     */
    public function isEaten()
    {

    }

    /**
     * 
     * Little pig is killed
     */
    public function isKilled()
    {

    }

    /**
     * 
     * Little pig is wake up by the wolf
     * 
     * 1. little pig kill the wolf
     * 2. little pig is happy ever after
     * 
     */
    public function wakeUpBy( Wolf $objWolf )
    {
        $objWolf->isKilled();
        $this->happyEverAfter();
    }
}
?>