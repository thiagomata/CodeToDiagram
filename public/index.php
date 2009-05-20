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
?>
<html>
    <head>
        <style >
            @import url("css/default.css");
        </style>
        <title>
            Code To Diagram - Automatic Sequence Diagram
        </title>
    </head>
    <body>
    <h3>
        Code To Diagram
    </h3>
    <h4> Sequence Diagram Generator Of Code Execution - PHP => HTML  </h4>
        <div class="intro">
            <p>
                The sequence diagram it is probably the must intuitive way to understand some code execution.
            </p>
            <p>
                Use it in the pre-project phase it is very common to describe the excepted behavior
                from some software. From the sequence diagram it is possible to developer test diagram,
                as check if all the features used on it was describe into the another phase of the planning
                as the use cases, for example.
            </p>
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
            <p>
                The solution proposed here it is the automatic generation of sequence diagrams based on the PHP
                code execution. One full code execution or some stretch of execution it is monitored by classes
                of code instrumentation what, based on the in formations received, creating the diagram of that
                code execution. This diagram can be seen as HTML, saved as HTML, and also to be saved
                as XML and in the future exported as a jpeg image.
            </p>
            <p>
                All this process must be simple and enough to be used simply append one call, but flexible also
                to deal with all the special cases. The big idea it is to create the diagram of the execution been
                less invader as possible into the source code what the execution will run. You can see the runing
                examples <a href="../examples">here</a>.
            </p>
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
            <p>
                You can download the last version of this project just downloading from it's 
                <a href="http://subversion.assembla.com/svn/codetodiagram" title="Code to Diagram - SVN">
                    SVN.
                </a>
                
                But, if you just want to take a look into the code, it is better view by
                <a href="http://code.assembla.com/codetodiagram/subversion/nodes" title="Code to Diagram - SVN Nodes" >
                    this
                </a>
                link.
            </p>
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
            <p>
                Click
                <a  href="http://www.assembla.com/wiki/show/codetodiagram/How_To_Use" title="Code to Diagram - How to Use" >
                    here
                </a>
                to know how to use this project into your application
            </p>
            <p>
                Click
                <a href="http://www.ibm.com/developerworks/rational/library/3101.html" title="IBM - UML's Sequence Diagram">
                    here
                </a>
                to know more about sequence diagrams.
            </p>
            <p>
                Click
                    <a href="http://tkyte.blogspot.com/2005/06/instrumentation.html" title="The Tom Kyte Blog"> 
                        here
                    </a>
                or 
                    <a href="http://www.glenmccl.com/instr/instr.htm" title="Java(tm) Source Code Instrumentation">
                        here
                   </a>
                to know more about code instrumentation.
            </p>
            <p >
                Click
                <a href="http://www.assembla.com/wiki/show/codetodiagram/Team" title="Code to Diagram - Team">
                    here
                </a>
                to know the team involved into the development of this project
            </p>
        </div>
        <div>
            <div class="duasColunas">
                <p>
                    In a short preview this code:
                </p>
                <p>
                    <?php highlight_string(
    "
    <?php
        require_once( '../../public/codetodiagram.php' );
        CodeToDiagram::getInstance()->start();

        require_once( 'Wolf.class.php' );
        require_once( 'Pig.class.php' );
        require_once( 'House.class.php' );
        require_once( 'History.class.php' );

        new History();
    ?>
    "
                    );?>
                </p>
            </div>
            <div>
                <p>
                    Will bring to you this:
                </p>
                <p>
                    <a style="border-style:none;" href="../examples/ThreeLittlePigs/threeLittlePigs.php">
                        <img style="border-style:none;" src="./images/pigs_small.png" />
                    </a>
                </p>
            </div>
        </div>
    </body>
</html>