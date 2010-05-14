<?php
/**
 * @package public
 * @subpackage CodeToDiagram
 */

/**
 * This file make a little intro about what it the code to diagram and the
 * xml to diagram, how it works and where you can find some others helps
 * as the examples, phpdocs, web site of the project, etc.
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */

require_once( "../public/codetodiagram.php" );

if( !isset( $strPageItem ) )
{
    $strPageItem = "Project";
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php require_once( "meta.php" ) ?>
        <style type="text/css">
            /*<![CDATA[*/

            @import url("css/default.css");
            /*]]>*/
        </style>
        <link href="./css/style.css" rel="stylesheet" type="text/css" media="screen" />
        <title>
            Code To Diagram - Automatic UML Diagrams from PHP Code Execution and Diagrams Web Editor
        </title>
        <script src="../experimental/phpjs/php.js" type="text/javascript" charset="utf-8"></script>
        <?php require_once( "./box/classDiagram.php" )?>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div id="logo">
                    <h1><a href="#">Code to Diagram</a></h1>
                </div>
            </div>
            <!-- end #header -->
            <div id="menu">
                <ul>
                    <li
                    <?php print ( $strPageItem == "Project" ) ? 'class="current_page_item"' : "" ?>
                    >
                        <a href="index.php">Project</a>
                    </li>
                    <li
                    <?php print ( $strPageItem == "Sequence" ) ? 'class="current_page_item"' : "" ?>
                    >
                        <a href="sequenceDiagram.php">Sequence</a>
                    </li>
                    <li
                    <?php print ( $strPageItem == "Class" ) ? 'class="current_page_item"' : "" ?>
                    >
                        <a href="classDiagram.php">Class</a>
                    </li>
                    <li
                    <?php print ( $strPageItem == "Database" ) ? 'class="current_page_item"' : "" ?>
                    >
                        <a href="databaseDiagram.php">Database</a>
                    </li>
                    <li
                    <?php print ( $strPageItem == "BPMN" ) ? 'class="current_page_item"' : "" ?>
                    >
                        <a href="bpmnDiagram.php">BPMN</a>
                    </li>
                    <li
                    <?php print ( $strPageItem == "Support" ) ? 'class="current_page_item"' : "" ?>
                    >
                        <a href="https://www.assembla.com/spaces/codetodiagram/support/tickets">Support</a>
                    </li>
                    <li
                    <?php print ( $strPageItem == "Suggestions" ) ? 'class="current_page_item"' : "" ?>
                    >
                        <a href="http://codetodiagram.uservoice.com">Suggestions</a>
                    </li>
                    <li
                    <?php print ( $strPageItem == "Wiki" ) ? 'class="current_page_item"' : "" ?>
                    >
                        <a href="https://www.assembla.com/wiki/show/codetodiagram">Wiki</a>
                    </li>
                    <li
                    <?php print ( $strPageItem == "Team" ) ? 'class="current_page_item"' : "" ?>
                    >
                        <a href="https://www.assembla.com/spaces/codetodiagram/team">Team</a>
                    </li>
                </ul>
            </div>
            <div id="page">
                <div id="page-bgtop">
                    <div id="page-bgbtm">
                        <div id="sidebar">
                            <ul>
                                <li>
                                    <div id="search" >
                                        <form method="get" action="#">
                                            <div>
                                                <input type="text" name="s" id="search-text" value="" />
                                                <input type="submit" id="search-submit" value="GO" />
                                            </div>
                                        </form>
                                    </div>
                                    <div style="clear: both;">&nbsp;</div>
                                </li>
                                <li>
                                    <h2>Code To Diagram</h2>
                                    <p>We create free, open-source web tools what can bring to your company productivity
					    creating automatic diagrams code based, providing a web plataform tool to create,
					    edit and share collaboratively diagrams, keeping the history controll, access controll
					    but still been easy to use and simple to be integrated with anothers existing tools.</p>
                                </li>
                                <li>
                                    <h2>Products</h2>
                                    <ul>
                                        <li><a href="#"></a></li>
                                        <li><a href="codeInstrumentation.php#PHP Code to Sequence Diagram">PHP Code to Sequence Diagram</a></li>
                                        <li><a href="sequenceDiagram.php#Sequence Diagram Web Editor">Sequence Diagram Web Editor</a></li>
                                        <li><a href="codeInstrumentation.php#PHP Code to Class Diagram">PHP Code to Class Diagram</a></li>
                                        <li><a href="classDiagram.php#Class Diagram Web Editor">Class Diagram Web Editor</a></li>
                                        <li><a href="databaseDiagram.php#Database Link to Database Modeling">Database Link to Database Modeling</a></li>
                                        <li><a href="databaseDiagram.php#Database Modeling Web Tool">Database Modeling Web Tool</a></li>
                                        <li><a href="bpmnDiagram.php#BPMN Web Editor">BPMN Web Editor</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <h2>Reference</h2>
                                    <ul>
                                        <li><a href="http://www.ibm.com/developerworks/rational/library/3101.html">UML's Sequence Diagram</a> by Donald Bell, IBM IT Specialist</li>
                                        <li><a href="http://www.glenmccl.com/instr/instr.htm">Java(tm) Source Code Instrumentation</a></li>
                                        <li><a href="http://tkyte.blogspot.com/2005/06/instrumentation.html">Instrumentation</a> by Tom Kyte</li>
                                    </ul>
                                </li>
                                <li>
                                    <h2>Similar Projects</h2>
                                    <ul>
                                        <li><a href="http://marketplace.eclipse.org/content/flowchart4j-v2-released-code-sequence-diagram-visio-uml">Flowchart4j</a></li>
                                        <li><a href="http://pigeonholdings.com/bombaygene/2008/06/23/visual-guice/">Visual Guice</a></li>
                                        <li><a href="http://www.websequencediagrams.com/">Web Sequence Diagram</a></li>
                                        <li><a href="http://sdedit.sourceforge.net/">Quick Sequence Diagram Editor</a></li>
                                        <li><a href="http://code.google.com/p/modsl/">ModSL</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <h2>Related Projects</h2>
                                    <ul>
                                        <li><a href="http://www.ohloh.net/p/corujaphpframework">Coruja PHP Framework</a></li>
                                        <li><a href="http://code.google.com/p/wsdldocument/">Wsdl Document</a></li>
                                        <li><a href="http://xdebug.org/">XDebug</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <h2>Donate</h2>
                                    <ul>
                                        <form
                                        action="https://www.paypal.com/cgi-bin/webscr"
                                        method="post"
                                        >
                                            <input
                                            type="hidden"
                                            name="cmd"
                                            value="_s-xclick"
                                            />
                                            <input
                                            type="hidden"
                                            name="hosted_button_id"
                                            value="W2C5JEXXUY8JY"
                                            />
                                            <input
                                            type="image"
                                            src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif"
                                            border="0"
                                            name="submit"
                                            alt="PayPal - The safer, easier way to pay online!"
                                            />
                                            <img
                                            alt=""
                                            border="0"
                                            src="https://www.paypal.com/pt_BR/i/scr/pixel.gif"
                                            width="1"
                                            height="1"
                                            />
                                        </form>
                                    </ul>
                                </li>
                            </ul>
                        </div>
