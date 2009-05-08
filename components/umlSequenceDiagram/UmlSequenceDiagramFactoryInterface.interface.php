<?php
/**
 * UmlSequenceDiagramFactoryInterface - definition of the factorys of UmlSequenceDiagram Objects
 * @package UmlSequenceDiagram
 */

/**
 * Interface to the factory of UmlSequenceDiagram
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
interface UmlSequenceDiagramFactoryInterface
{
	/**
	 * Return the singleton of the UmlSequenceDiagramFactoryInterface
	 *
	 * @return UmlSequenceDiagramFactoryInterface
	 */
	public static function getInstance();

    /**
     * set the Uml Sequence Diagram object
     *
	 * @see UmlSequenceDiagramFactoryInterface->setUmlSequenceDiagram( UmlSequenceDiagram )
     * @param $objUmlSequenceDiagram
     * @return UmlSequenceDiagramFactoryInterface
     */
    public function setUmlSequenceDiagram( UmlSequenceDiagram $objUmlSequenceDiagram );

    /**
     * get the Uml Sequence Diagram object
     *
	 * @see UmlSequenceDiagramFactoryInterface->getUmlSequenceDiagram()
     * @return UmlSequenceDiagram
     */
    public function getUmlSequenceDiagram();

    /**
     * create a Uml Sequence Diagram based into its configurations
     *
	 * @see UmlSequenceDiagramFactoryInterface->perform()
     * @return UmlSequenceDiagram
     */
    public function perform();
}
?>