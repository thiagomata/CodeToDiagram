<?php
/**
 * UmlClassDiagramFactoryInterface - definition of the factorys of UmlClassDiagram Objects
 * @package UmlClassDiagram
 */

/**
 * Interface to the factory of UmlClassDiagram
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
interface UmlClassDiagramFactoryInterface
{
	/**
	 * Return the singleton of the UmlClassDiagramFactoryInterface
	 *
	 * @return UmlClassDiagramFactoryInterface
	 */
	public static function getInstance();

    /**
     * set the Uml Class Diagram object
     *
	 * @see UmlClassDiagramFactoryInterface->setUmlClassDiagram( UmlClassDiagram )
     * @param $objUmlClassDiagram
     * @return UmlClassDiagramFactoryInterface
     */
    public function setUmlClassDiagram( UmlClassDiagram $objUmlClassDiagram );

    /**
     * get the Uml Class Diagram object
     *
	 * @see UmlClassDiagramFactoryInterface->getUmlClassDiagram()
     * @return UmlClassDiagram
     */
    public function getUmlClassDiagram();

    /**
     * create a Uml Class Diagram based into its configurations
     *
	 * @see UmlClassDiagramFactoryInterface->perform()
     * @return UmlClassDiagram
     */
    public function perform();
}
?>