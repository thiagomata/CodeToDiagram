<?php
/**
 * Wolf of the Three Little Pigs Example
 * @package examples
 * @subpackage ThreeLittlePigs
 */

/**
 * Wolf of the example of the code to diagram
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class Wolf
{
	/**
	 * Wolf say the received text
	 * 
	 * @param string $strText
	 * @return Wolf me
	 */
    public function say( $strText )
    {
        print "wolf say: " . $strText . " <br/>\n";
    	return $this;
    }

    /**
     * Wolf buff
     */
    public function huff()
    {

    }

    /**
     * Wolf puff
     */
    public function puff()
    {

    }

    /**
     * Wolf blow the house
     */
    public function blowIt( House $objHouse )
    {
        if( $objHouse->getBlowBy( $this ) )
        {
            $objPig = $objHouse->getPig();
            $objPig->isKilled();
            $objPig->isEaten();
        }
    }

    /**
     * Wolf is killed
     */
    public function isKilled()
    {
        
    }
}
?>
