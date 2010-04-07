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
            Code To Diagram - Automatic UML Diagram from PHP Code Execution
        </title>
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
                            </ul>
                        </div>
                        <div id="content">
                            <div class="post">
                                <h2 class="title"><a href="#">Diagrams</a></h2>
                                <p class="meta">
                                    <span class="date">Why Diagrams?</span>
                                    <span class="posted">Diagrams</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        The UML - <a href="http://en.wikipedia.org/wiki/Unified_Modelling_Language">Unified Modelling Language</a> -
                                        Diagrams are the most standarts and intuitives ways
                                        to describe the operation of a project.
                                        The <a href="http://en.wikipedia.org/wiki/Sequence_diagram">Sequence Diagram</a>,
                                        for example, it is one excellent way to understand a <strong>code execution</strong>.
                                        The <a href="http://en.wikipedia.org/wiki/Class_Diagram">Class Diagram</a>,
                                        another way, it is a better one to show what classes are related, their attributes and depencency.
                                    </p>
                                    <p>
                                        The <a href="http://en.wikipedia.org/wiki/BPMN">BPMN</a> - despide not be a UML Diagram,
                                        but much like the <a href="http://en.wikipedia.org/wiki/Activity_diagram">UML Activity Diagrams</a>
                                        it become the enterprise
                                        standart one of modeling process. The Database Modeling using the <a href="#">Entity-Relationship Model</a>
                                    </p>
                                    <p>
                                        All this diagrams, used it in the pre-project phase are very common to describe the excepted behavior
                                        from some software. From the sequence diagram it is possible to developer test diagram,
                                        as check if all the features used on it was as described into the planning phase
                                        as the use cases, for example.
                                    </p>
                                </div>
                                <p class="meta">
                                    <span class="date">Diagramas Weaknesses</span>
                                    <span class="posted">Diagrams</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        When the sequence diagram it is used to describe the features into the code level, as the
                                        interaction of objects, using methods, it is possible to plan how the classes will be. But,
                                        as the code development evolves, been caused by the analysis fail or by requirement change,
                                        the diagrams will losing the link with the reality losing consequently the descriptive function
                                        to one analysis history function.
                                    </p>
                                    <p>
                                        Also, to require the existence of one diagram to each test methods of some project will bring
                                        a huge spent of time, into it's creation as is in the maintenance. This is because <strong>each change
                                            of some method name or attribute name will require a change into all diagrams what involve it</strong>.
                                    </p>
                                </div>
                                <p class="meta">
                                    <span class="date">Tools Weaknesses</span>
                                    <span class="posted">Diagrams</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        When the Sequence Diagram it is created in the planing moment. It should be possible to created it without the
                                        code need. Many tools are able to create sequence diagrams but big part of them are not able to keep on sync all
                                        the diagrams created to the team members, most of then are monoplataform,
                                        not colaborative, without history of changes, close format file, etc.
                                    </p>
                                    <p>
                                        In addition all design changes must be replicated in all the diagrams of the project and for all team members.
                                        Therefore, keep all updated diagrams will become an increasingly expensive activity until it becomes unfeasible.
                                        The diagrams then become mere representations of how the project was originally designed without contemplating
                                        the continuous modifications and losing a lot of utility to enable the understanding of the current version of
                                        the project without the need to consult the source code.
                                    </p>
                                </div>
                            </div>
                            <div class="post"  style="float:left">
                                <h2 class="title"><a href="#Code to Diagram Propose" name="Code to Diagram Propose" >Code to Diagram Propose</a></h2>
                                <p class="meta">
                                    <span class="date"><a href="sequenceDiagram.php#PHP Code to Sequence Diagram">PHP Code to Sequence Diagram</a></span>
                                    <span class="posted">Propose</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry" style="float:left">
                                    <p>
                                        This proposal tool is for automatic generation of sequence diagrams based on the PHP
                                        code execution. One full code execution or some stretch of execution it is monitored by classes
                                        of <a href="http://www.glenmccl.com/instr/instr.htm">Code Instrumentation</a> what, based on the
                                        in formations received, creating the diagram of that
                                        code execution. This diagram can be seen as HTML, saved as HTML, and also to be saved
                                        as XML and in the future exported as a jpeg image and as a XMI UML file.
                                    </p>
                                    <div>
                                        <div class="comColunas">
                                            <div class="duasColunas">
                                                <img src="./images/flow_codetodiagram.png" id="flow_codetodiagram" />
                                            </div>
                                            <div class="duasColunas">
                                                <p>
                                                    The pattern used here was the factorys and printers. There is many factorys what builds UML sequence
                                                    diagram objects and many options of printers what create a different result based on the UML sequence
                                                    diagram object received.
                                                </p>
                                                <p>
                                                    If you have some special case, when any of the avaliable printers and factorys
                                                    solve your problem, everthing it is extremly well
                                                    <a href="http://www.thiagomata.com/codetodiagram/doc/dox/html/">doc</a>
                                                    to help
                                                    to you create new classes and append new features.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="meta"  style="float:left;width:99%;">
                                    <span class="date"><a href="sequenceDiagram.php#Sequence Diagram Web Editor">Sequence Diagram Web Editor</a></span>
                                    <span class="posted">Propose</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        This tool can be used to create new Sequence Diagram without existing code
                                        as well to bring more richness to the diagrams created by a code execution, append to
                                        them notes of comments, colors, changing layout, or even to create a new sequence
                                        diagram based on some existing one.
                                    </p>
                                    <p>
                                        XML of Sequence Diagrams can be created by some different tool, into a different language. The
                                        Sequence Diagram Editor will receive the XML file by a
                                        <a href="http://en.wikipedia.org/wiki/Service-oriented_architecture">SOA</a> and return the created diagram without any problems.
                                        The XML used it is much more simple of the XML of the UML XMI.
                                    </p>
                                    <p>
                                        As a web tool it has no plataform restriction and new features of colaborative edition with history, maybe using google wave,
                                        are into the planned features.
                                    </p>
                                </div>
                                <p class="meta">
                                    <span class="date"><a href="classDiagram.php#PHP Code to Class Diagram">PHP Code to Class Diagram</a></span>
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
                                    <span class="date"><a href="#donation">Generate Database Model from a Database Link</a></span>
                                    <span class="posted">Propose</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        This tool is for the
                                        automatic generation of database modeling entity relationship diagrams
                                        based on the database access information.
                                        The web tool will access the entities of the Database and based on it's information data will create MER Diagrams.
                                        Every time when the diagram be seen the informations about the Database Entities, tables and fields will be updated
                                        keeping the diagram always synchronized with information existing into the Database. The generated diagram can be saved
                                        into a XML as well the others diagrams.
                                    </p>
                                    <p>
                                        This tool is still in the planning phase and should begin to be made so far the sequence diagram and the class
                                        diagram modules been completely ready.
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
                                <p class="meta">
                                    <span class="date"><a href="bpmnDiagram.php#BPMN Web Editor">BPMN Web Editor</a></span>
                                    <span class="posted">Propose</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        This web tool will provide a simple and efficient way to create, edit and share yours BPMNs Diagrams. All the diagrams will be
                                        saved into XML files what can be export to another tools or received from another tool to be drawn.
                                    </p>
                                    <p>
                                        All the diagrams will be shared with the team, always in sync and with history of changes.
                                    </p>
                                    <p>
                                        This tool is still in the planning phase and should begin to be made so far the
                                        <a href="sequenceDiagram.php#Sequence Diagram Tool">Sequence Diagram Tool</a> ,
                                        the <a href="classDiagram.php#Class Diagram Tool">Class Diagram Tool</a> and the the
                                        <a href="databaseDiagram.php#Database Diagram Tool">Database Diagram Tool</a> been completely ready.
                                    </p>
                                </div>
                            </div>
                            <div class="post">
                                <h2 class="title"><a href="#What is Ready to Go?" name="What is Ready to Go?">What is Ready to Go?</h2>
                                <p class="meta">
                                    <span class="date">PHP Code to Sequence Diagram</span>
                                    <span class="posted">What is Ready to Go?</span>
                                </p>
                                <div class="entry">
                                    <p>
                                        Using <a href="http://www.glenmccl.com/instr/instr.htm">Code Instrumentation</a> the generation of Sequence Diagrams already is working as can be seen
                                        in this <a href="#">the three little pigs</a> where,
                                    </p>
                                    <div class="comColunas">
                                        <div class="duasColunas">
                                            <p>
                                                in a short preview <a href="https://www.assembla.com/code/codetodiagram/subversion/nodes/examples/ThreeLittlePigs/threeLittlePigs.php?rev=193">this code</a>:
                                            </p>
                                            <div class="php">
                                                <p class="line">
                                                    <span class="tag">&lt;?php</span>
                                                </p>
                                                <p class="line"><span
                                                        class="function">require_once</span><span
                                                        class="parenthesis">(</span><a
                                                        href="https://www.assembla.com/code/codetodiagram/subversion/nodes/public/codetodiagram.php"><span
                                                            class="string">'../../public/codetodiagram.php'</span></a><span
                                                        class="parenthesis">)</span><span
                                                        class="semicolon">;</span>
                                                </p>
                                                <p class="line"><span
                                                        class="php_class">CodeToDiagram</span><span
                                                        class="static_operator">::</span><span
                                                        class="method">getInstance</span><span
                                                        class="parenthesis">()</span><span
                                                        class="caller">-></span><span
                                                        class="method">start</span><span
                                                        class="parenthesis">()</span><span
                                                        class="semicolon">;</span>
                                                </p>
                                                <p class="line"><span
                                                        class="function">require_once</span><span
                                                        class="parenthesis">(</span><a
                                                        href="https://www.assembla.com/code/codetodiagram/subversion/nodes/examples/ThreeLittlePigs/Wolf.class.php"><span
                                                            class="string">'Wolf.class.php'</span></a><span
                                                        class="parenthesis">)</span><span
                                                        class="semicolon">;</span>
                                                </p>
                                                <p class="line"><span
                                                        class="function">require_once</span><span
                                                        class="parenthesis">(</span><a
                                                        href="https://www.assembla.com/code/codetodiagram/subversion/nodes/examples/ThreeLittlePigs/House.class.php"><span
                                                            class="string">'House.class.php'</span></a><span
                                                        class="parenthesis">)</span><span
                                                        class="semicolon">;</span>
                                                </p>
                                                <p class="line"><span
                                                        class="function">require_once</span><span
                                                        class="parenthesis">(</span><a
                                                        href="https://www.assembla.com/code/codetodiagram/subversion/nodes/examples/ThreeLittlePigs/Pig.class.php"><span
                                                            class="string">'Pig.class.php'</span></a><span
                                                        class="parenthesis">)</span><span
                                                        class="semicolon">;</span>
                                                </p>
                                                <p class="line"><span
                                                        class="function">require_once</span><span
                                                        class="parenthesis">(</span><a
                                                        href="https://www.assembla.com/code/codetodiagram/subversion/nodes/examples/ThreeLittlePigs/History.class.php"><span
                                                            class="string">'History.class.php'</span></a><span
                                                        class="parenthesis">)</span><span
                                                        class="semicolon">;</span>
                                                </p>
                                                <p class="line"><span
                                                        class="new">new</span><span
                                                        class="space">&nbsp;</span><span
                                                        class="object">History</span><span
                                                        class="parenthesis">()</span><span
                                                        class="semicolon">;</span>
                                                </p>
                                                <p class="line"><span
                                                        class="tag">?&gt;</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="duasColunas">
                                            <div>
                                                <p>
                                                    Will bring to you this:
                                                </p>
                                                <p>
                                                    <a style="border-style:none;" href="../examples/ThreeLittlePigs/threeLittlePigs.php">
                                                        <img
                                                            id="pig_small"
                                                            src="./images/pigs_small.png"
                                                            alt="three little pigs diagram automatically generated"
                                                            longdesc="./images/pigs_small.txt"
                                                            />
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="meta" style="float:left; width:100%">
                                    <span class="date">Sequence Diagram Web Editor</span>
                                    <span class="posted">What is Ready to Go?</span>
                                </p>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="entry">
                                    <p>
                                        The Web Tool of Edition of Sequence Diagrams it is not ready yet.
                                        But the feature of drawn Sequence Diagrams based on a XML it is working fine.
                                    </p>
                                    <div>
                                        <div style="width:100%;float:left">
                                            <p>
                                                In a short preview this xml:
                                            </p>
                                            <?php CorujaDebug::printXmlCode(
                                                    file_get_contents ( '../examples/xmls/mvc.xml' )
                                            );?>
                                        </div>
                                        <div style="width:100%;float:left">
                                            <p>
                                                Will bring to you this:
                                            </p>
                                            <p>
                                                <a style="border-style:none;" href="xmlToDiagram.php?file=mvc">
                                                    <img
                                                        id="mvc_codetodiagram"
                                                        src="./images/mvc_codetodiagram.jpg"
                                                        longdesc="./images/mvc_codetodiagram.txt"
                                                        alt="model view controller sequence diagram automatically generated by the code to diagram"
                                                        />
                                                </a>
                                            </p>
                                        </div>
                                    </div>
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
