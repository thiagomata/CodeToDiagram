<?php
/**
 * @package public
 * @subpackage CodeToDiagram
 */

/**
 * This file make a little intro about the code to diagram - class diagram creator.
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */

require_once( "../public/codetodiagram.php" );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php require_once( "header.php" ) ?>
        <style type="text/css">
            /*<![CDATA[*/

            @import url("css/default.css");
            /*]]>*/
        </style>
        <link href="./css/style.css" rel="stylesheet" type="text/css" media="screen" />
        <title>
            Code To Diagram - Automatic UML Diagram from PHP Code Execution - Class Diagram Web Creator
        </title>
        <script src="../experimental/phpjs/php.js" type="text/javascript" charset="utf-8"></script>
        <style type="text/css">
          *
          {
              padding: 0;
              margin: 0;
              border: none;
          }
          canvas
          {
              border-style: solid;
              border-color: black;
              border-width: 1px;
          }
          #canvaBox
          {
            margin-left:0px;
            margin-top:0px;
          }
        </style>
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
                    <li class="current_page_item"><a href="#">Project</a></li>
                    <li><a href="sequenceDiagram.php">Sequence</a></li>
                    <li><a href="classDiagram.php">Class</a></li>
                    <li><a href="databaseDiagram.php">Database</a></li>
                    <li><a href="bpmnDiagram.php">BPMN</a></li>
                    <li><a href="https://www.assembla.com/spaces/codetodiagram/support/tickets">Support</a></li>
                    <li><a href="http://codetodiagram.uservoice.com">Suggestions</a></li>
                    <li><a href="https://www.assembla.com/wiki/show/codetodiagram">Wiki</a></li>
                    <li><a href="https://www.assembla.com/spaces/codetodiagram/team">Team</a></li>
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
                                        <li><a href="sequenceDiagram.php#PHP Code to Sequence Diagram">PHP Code to Sequence Diagram</a></li>
                                        <li><a href="sequenceDiagram.php#Sequence Diagram Web Editor">Sequence Diagram Web Editor</a></li>
                                        <li><a href="classDiagram.php#PHP Code to Class Diagram">PHP Code to Class Diagram</a></li>
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
                        <div id="content">
                            <div class="post">
                                <p class="meta">
                                    <span class="date"><a name="PHP Code to Class Diagram" href="classDiagram.php#PHP Code to Class Diagram">PHP Code to Class Diagram</a></span>
                                    <span class="posted">Propose</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        This tool is for the
                                        automatic generation of class diagrams based on the PHP
                                        code execution or recursive analysis of the PHP project folder.
                                        In the first case, just like the Sequence Diagram Generation, one full code execution or some stretch of
                                        execution it is monitored by classes of <a href="http://www.glenmccl.com/instr/instr.htm">Code Instrumentation</a>
                                        what, based on the in formations received,
                                        creating the diagram of that code execution. This diagram can be seen as HTML, saved as HTML, and also
                                        to be saved as XML and in the future exported as a jpeg image and as a XMI UML file.
                                    </p>
                                    <p>
                                        The same project pattern it is used here. That is the factorys and printers.
                                        There is many factorys what builds UML class
                                        diagram objects and many options of printers what create a different result based on the UML class
                                        diagram object received.
                                    </p>
                                    <p>
                                        If you have some special case, when any of the avaliable printers and factorys
                                        solve your problem, everthing it is extremly well
                                        <a href="http://www.thiagomata.com/codetodiagram/doc/dox/html/">doc</a>
                                        to help
                                        to you create new classes and append new features.
                                    </p>
                                    <p>
                                        <strong>The Class Diagram generation still is in working progress</strong>. You can help to accelerate
                                        it making a <a href="#donation">donation</a>.
                                    </p>
                                </div>
                                <p class="meta">
                                    <span class="date"><a href="classDiagram.php#Class Diagram Web Editor">Class Diagram Web Editor</a></span>
                                    <span class="posted">Propose</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        This tool can be used to create new Class Diagram without existing code
                                        as well to bring more richness to the diagrams created by a code execution, append to
                                        them notes of comments, colors, changing layout, or even to create a new sequence
                                        diagram based on some existing one.
                                    </p>
                                    <p>
                                        XML of Class Diagrams can be created by some different tool, into a different language. The
                                        Class Diagram Editor will receive the XML file by a SOA and return the created diagram without any problems.
                                        The XML used it is much more simple of the XML of the UML XMI.
                                    </p>
                                    <p>
                                        As a web tool it has no plataform restriction and new features of colaborative edition with history, maybe using google wave,
                                        are into the planned features.
                                    </p>
                                    <p>
                                        As said above, <strong>The Class Diagram generation still is in working progress</strong>. You can help to accelerate
                                        it making a <a href="#donation">donation</a>.
                                    </p>
                                </div>
                                <p class="meta">
                                    <span class="date"><a href="databaseDiagram.php#Database Modeling Web Tool">Database Modeling Web Tool</a></span>
                                    <span class="posted">Propose</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        To the planning phase the user should be able to create a database diagram of non existing database objects and change existing
                                        database diagrams. This element will bring the feature to append, change and remove tables and fields. For that we propouse the
                                        <strong> Database Modeling Web Tool </strong> and should be able to receive the XML data.
                                    </p>
                                    <p>
                                        All the diagrams will be shared with the team, always in sync and with history of changes.
                                    </p>
                                    <p>
                                        This tool is still in the planning phase and should begin to be made so far the
                                        <a href="sequenceDiagram.php#Sequence Diagram Tool">Sequence Diagram Tool</a>
                                        and the <a href="classDiagram.php#Class Diagram Tool">Class Diagram Tool</a> been completely ready.
                                    </p>
                                </div>
                            </div>
                            <div class="post">
                                <h2 class="title">
                                    <a href="#What is Ready to Go?" name="What is Ready to Go?">
                                        What is Ready to Go?
                                    </a>
                                </h2>
                                <p class="meta">
                                    <span class="date">Class Diagram Web Editor</span>
                                    <span class="posted">What is Ready to Go?</span>
                                </p>
                                <div class="entry">
                                    <p>
                                        Using Javascript Canvas the web tool of Class Diagrams is ready to be tested as can be seen
                                        in this <a href="#classDiagramEditor.php">the three little pigs</a> where it can be editaded.
                                    </p>
                                    <p>
                                        <div id="box">
                                            <canvas id="canvaBox">
                                            </canvas>

                                            <script type="text/javascript" charset="utf-8">
                                                require_once( "_start.js" );
                                                objBox = new CanvasBox( "canvaBox" ,
                                                    document.getElementById("box").clientWidth, 700     );
                                            </script>
                                        </div>
                                    </p>
                                </div>
                            </div>
                            <div class="post">
                                <h2 class="title"><a href="#">Limitations</a></h2>
                                <p class="meta">
                                    <span class="date">Internet Explorer Output</span>
                                    <span class="posted">Limitations</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        While still not fully working on <a href="http://www.findmebyip.com/litmus#target-selector">Internet Explorer</a>,
                                        the generator already makes life easier for those
                                        responsible in maintaining this kind of diagrams.
                                        We welcome anyone with the patience and desire to make the
                                        CSS changes need for it to work on Internet Explorer.
                                    </p>
                                </div>
                                <p class="meta">
                                    <span class="date">Under Development</span>
                                    <span class="posted">Limitations</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        Also, fully compliance with UML 2.0 is still under development.
                                        Anyone interested in working in these fields is more than welcome to join the team.
                                        And if you have a patch on add-on to send, feel free to do so.
                                        Just send an e-mail to me <a href="mailto:thiago.henrique.mata@gmail.com">thiago.henrique.mata@gmail.com</a> .
                                        And remember, this is free software, in development, and as such, I can give you no warranty.
                                        Use it at your own risk. It's not for the faint of heart.
                                        Tag names can and should change. New tags can be add anytime. Stay tunned for more news.
                                    </p>
                                </div>
                            </div>
                            <div style="clear: both;">&nbsp;</div>
                        </div>
                        <div style="clear: both;">&nbsp;</div>
                    </div>
                </div>
            </div>
            <!-- end #page -->
        </div>
        <div id="footer">
            <p>Copyright (c) 2008 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
        </div>
        <!-- end #footer -->
    </body>
</html>
