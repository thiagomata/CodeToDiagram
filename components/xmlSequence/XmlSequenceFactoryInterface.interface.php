<?php
interface XmlSequenceFactoryInterface
{
    /**
     * set the xml sequence object
     * 
	 * @see XmlSequenceFactoryInterface->setXmlSequence( XmlSequence )
     * @param $objXmlSequence
     * @return XmlSequenceFactoryInterface
     */
    public function setXmlSequence( XmlSequence $objXmlSequence );
    
    /**
     * get the xml sequence object
     * 
	 * @see XmlSequenceFactoryInterface->getXmlSequence()
     * @return XmlSequence
     */
    public function getXmlSequence();
    
    /**
     * create a xml sequence based into its configurations
     * 
	 * @see XmlSequenceFactoryInterface->perform()
     * @return XmlSequence
     */
    public function perform();
    
}
?>
