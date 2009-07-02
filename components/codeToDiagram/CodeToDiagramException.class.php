<?php
/**
 * CodeToDiagramException - to the Exceptions in the CodeToDiagram scope
 *
 * @package CodeToDiagram
 */

/**
 * Code To Diagram Exception
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class CodeToDiagramException extends Exception
{
    public function __construct( $strMessage )
    {
        print $strMessage . " on " . $this->getFile() . " line " . $this->getLine() . " <br/>\n<pre> ";
        print_r( $this->getTrace() );
        exit();
    }
}
?>