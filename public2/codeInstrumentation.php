<?php
require_once( "header.php" )
?>
<div id="content">
    <div class="post">
        <h2 class="title"><a href="#Code Instrumentation" name="Code Instrumentation">Code Instrumentation</a></h2>
        <p class="meta">
            <span class="subtopic">What is Code Instrumentation?</span>
            <span class="topic">Code Instrumentation</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                In context of computer programming,
                <a href="http://en.wikipedia.org/wiki/Instrumentation_(computer_programming)">code instrumentation</a>
                refers to an ability to monitor or measure the level of a
                product's performance, to diagnose errors and writing trace
                information.
                Instrumentation is in the form of code instructions that monitor
                specific components in a system
                (for example, instructions that output logging information appear on screen).
                When an application contains instrumentation code,
                it can be managed using a management tool. Instrumentation is
                necessary to review the performance of the application.
                Instrumentation approaches can be of two types, source
                instrumentation and binary instrumentation
                from
                <cite>
                    <a href="http://en.wikipedia.org/wiki/Instrumentation_(computer_programming)">
                    Wikipedia, 2010
                    </a>
                </cite>
            </p>
            <p>
                Code to Diagram it is a project what intent to use code instrumentation and rich internet applications
                to improve the use of diagrams into projects and make easy keep them sync with the real code execution.
                To do that it is possible to create diagrams based on code executions, unitary tests, code files,
                xmls files, text files, etc.
            </p>
            <p>
                To generate diagrams based on code executions it is necessary to make a call to a bootstrap file of the
                code to diagram engine, what will sniffer all the execution and based on the objects interactions
                will generate a diagram. But, to config more detail the diagram, changing the user-agent order, the
                user-agent type, append some note object, change style properties, etc. the user will need to deal
                with the code to diagram objects.
                In this page we will explain to you how to do it.
            </p>
        </div>
    </div>
    <div class="post">
        <p class="meta">
            <span class="subtopic"><a name="PHP Code to Class Diagram" href="codeInstrumentation.php#PHP Code to Class Diagram">PHP Code to Class Diagram</a></span>
            <span class="topic">Code Instrumentation</span>
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
                creating the diagram of that code execution. This diagram can be seen in browser and edited in browser, and also
                to be saved as XML, as a jpeg image and as XMI UML file.
            </p>
            <p>
                MISSING TEXT
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
    </div>
    <div class="post">
        <p class="meta">
            <span class="subtopic"><a name="PHP Code to Sequence Diagram" href="codeInstrumentation.php#PHP Code to Sequence Diagram">PHP Code to Sequence Diagram</a></span>
            <span class="topic">Code Instrumentation</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                MISSING TEXT
            </p>
            <p>
                MISSING TEXT
            </p>
            <p>
                If you have some special case, when any of the avaliable printers and factorys
                solve your problem, everthing it is extremly well
                <a href="http://www.thiagomata.com/codetodiagram/doc/dox/html/">doc</a>
                to help
                to you create new classes and append new features.
            </p>
            <p>
                <strong>The Sequence Diagram generation still is in working progress</strong>. You can help to accelerate
                it making a <a href="#donation">donation</a>.
            </p>
        </div>
    </div>
    <div class="post">
        <h2 class="title"><a href="#">Limitations</a></h2>
        <p class="meta">
            <span class="subtopic">Internet Explorer Output</span>
            <span class="topic">Limitations</span>
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
            <span class="subtopic">Under Development</span>
            <span class="topic">Limitations</span>
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
<?php
require_once( "footer.php" );
?>