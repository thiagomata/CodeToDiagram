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
        <title>
            Code To Diagram - Automatic Sequence Diagram
        </title>
    </head>
    <body>
	<center>
    		<img src="./images/codetodiagramheader.jpg" alt="code to diagram logo" title="code to diagram"/>
    		<h3>
		        Code To Diagram
    		</h3>
	</center>
    <h4> Converting Code Execution into Sequence Diagrams </h4>
        <div class="intro">
            <h5> Sequence Diagramas </h5>
            <p>
                The sequence diagram it is probably the must intuitive way to understand some code execution.
            </p>
            <p>
                Use it in the pre-project phase it is very common to describe the excepted behavior
                from some software. From the sequence diagram it is possible to developer test diagram,
                as check if all the features used on it was describe into the another phase of the planning
                as the use cases, for example.
            </p>
            <h5> Sequence Diagramas Weaknesses </h5>
            <p>
                When the sequence diagram it is used to describe the features into the code level, as the
                interaction of objects, using methods, it is possible to plan how the classes will be. But,
                as the code development evolves, been caused by the analysis fail or by requirement change,
                the diagrams will losing the link with the reality losing consequently the descriptive function
                to one analysis history function.
            </p>
            <p>
                Also, to require the existence of one diagram to each test methods of some project will bring
                a huge spent of time, into it's creation as is in the maintenance. This is because each change
                of some method name or attribute name will require a change into all diagrams what involve it.
            </p>
            <h5> Code to Diagram Propose </h5>
            <div style="float:left">
             <div style="width:50%; float:left">
                <p>
                    The solution proposed here it is the automatic generation of sequence diagrams based on the PHP
                    code execution. One full code execution or some stretch of execution it is monitored by classes
                    of code instrumentation what, based on the in formations received, creating the diagram of that
                    code execution. This diagram can be seen as HTML, saved as HTML, and also to be saved
                    as XML and in the future exported as a jpeg image.
                </p>
                <p>
                    The pattern used here was the factorys and printers. There is many factorys what builds uml sequence
                    diagram objects and many options of printers what create a different result based on the uml sequence
                    diagram object received.
                </p>
                <p>
                    if you have some
                special case, when any of the avaliable printers and factorys
                solve your problem, everthing it is extremly well
                <a href="http://www.thiagomata.com/codetodiagram/doc/dox/html/">doc</a>
                to help
                to you create new classes and append new features.
                </p>
            </div>
            <div class="diagram_flow">
                <img src="./images/flow_codetodiagram.png"
                alt="code to diagram flow"
                longdesc="./images/flow_codetodiagram.txt"/>
            </div>
            </div>
            <h5> How it Works ? </h5>
            <p>
                All this process must be simple and enough to be used simply append one call, but flexible also
                to deal with all the special cases. The big idea it is to create the diagram of the execution been
                less invader as possible into the source code what the execution will run. You can see the runing
                examples <a href="../examples" title="click here to see the examples">here</a>.
            </p>
            <h5> Preview of Diagram from Code Execution </h5>
            <div>
                <div class="duasColunas">
                    <p>
                        In a short preview this code:
                    </p>
                    <div class="php">
                        <p class="line">
                            <span class="tag">&lt;?php</span>
                        </p>
                        <p class="line"><span
                            class="function">require_once</span><span
                            class="parenthesis">(</span><span
                            class="string">'../../public/codetodiagram.php'</span><span
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
                            class="parenthesis">(</span><span
                            class="string">'Wolf.class.php'</span><span
                            class="parenthesis">)</span><span
                            class="semicolon">;</span>
                        </p>
                        <p class="line"><span
                            class="function">require_once</span><span
                            class="parenthesis">(</span><span
                            class="string">'House.class.php'</span><span
                            class="parenthesis">)</span><span
                            class="semicolon">;</span>
                        </p>
                        <p class="line"><span
                            class="function">require_once</span><span
                            class="parenthesis">(</span><span
                            class="string">'Pig.class.php'</span><span
                            class="parenthesis">)</span><span
                            class="semicolon">;</span>
                        </p>
                        <p class="line"><span
                            class="function">require_once</span><span
                            class="parenthesis">(</span><span
                            class="string">'History.class.php'</span><span
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
                <div>
                    <p>
                        Will bring to you this:
                    </p>
                    <p>
                        <a style="border-style:none;" href="../examples/ThreeLittlePigs/threeLittlePigs.php">
                            <img
                                style="border-style:none;"
                                src="./images/pigs_small.png"
                                alt="three little pigs diagram automatically generated"
                                longdesc="./images/pigs_small.txt"
                            />
                        </a>
                    </p>
                </div>
            </div>
            <p>
                Click
                <a  href="http://www.assembla.com/wiki/show/codetodiagram/How_To_Use" title="Code to Diagram - How to Use" >
                    here
                </a>
                to know how to use this project into your application
            </p>
            <h5> Draw your diagram </h5>
            <p>
                One small component was created in the process of generation of this software what can be used separately.
                It is the generator of sequence diagrams from one XML.
                This application can be test
                <a href="xmlToDiagram.php"> here </a>
                where one XML of example it is used but can be change freely.
            </p>
            <p>
                The target of this project it is make possible the generation of a sequence diagram from each test method.
                Been each generated diagram saved with an easy to find name. Some new features should be appending to as
                show the code of the caller, make improvements into the parameters descriptions and many more.
            </p>
            <h5> Preview of Diagram from Xml Iterpretation </h5>
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
                                src="./images/mvc_codetodiagram.jpg" 
                                longdesc="./images/mvc_codetodiagram.txt"
                                alt="model view controller sequence diagram automatically generated by the code to diagram"
                            />
                        </a>
                    </p>
                </div>
            </div>
            <h5> Download </h5>
            <p>
                You can download the last version of this project just downloading from it's 
                <a href="http://subversion.assembla.com/svn/codetodiagram" title="Code to Diagram - SVN">
                    SVN
                </a>.
                
                But, if you just want to take a look into the code, it is better view by
                <a href="http://code.assembla.com/codetodiagram/subversion/nodes" title="Code to Diagram - SVN Nodes" >
                    this
                </a>
                link.
            </p>
            <h5> Features </h5>
            <p>
                While still not fully working on Internet Explorer, the generator already makes life easier for those responsible
                in maintaining this kind of diagrams. We welcome anyone with the patience and desire to make the CSS changes need
                for it to work on IE.
            </p>
            <p>
                Also, fully compliance with UML 2.0 is still under development. Anyone interested in working in these fields is more
                than welcome to join the team. And if you have a patch on add-on to send, feel free to do so.And remember, this is
                free software, and as such, I can give you no warranty. Use it at your own risk. It's not for the faint of heart.
            </p>
            <h5> Who build this stuff ? And Why ? </h5>
            <p>
                This project was buid to create a high quality documentation in our other project,
                called Coruja PHP Framework. That aims to do everything with the highest quality
                and, of course, the documentation could not be out of this.
            </p>
            <p >
                Click
                <a href="http://www.assembla.com/wiki/show/codetodiagram/Team" title="Code to Diagram - Team">
                    here
                </a>
                to see the team responsible for the development of these projects
            </p>
            <h5> Links Related </h5>
            <p>
                Click
                <a href="http://www.ibm.com/developerworks/rational/library/3101.html" title="IBM - UML's Sequence Diagram">
                    IBM - UML's Sequence Diagram
                </a>
                to know more about sequence diagrams.
            </p>
            <p>
                Click
                    <a href="http://tkyte.blogspot.com/2005/06/instrumentation.html" title="The Tom Kyte Blog">
                        The Tom Kyte Blog talk about Code Instrumentation
                    </a>
                or
                    <a href="http://www.glenmccl.com/instr/instr.htm" title="Java(tm) Source Code Instrumentation">
                        Java(tm) Source Code Instrumentation
                   </a>
                to know more about code instrumentation.
            </p>
        </div>
        <?php require_once( "footer.php" ); ?>
    </body>
</html>
