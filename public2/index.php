<?php
require_once( "header.php" )
?>
<div id="content">
    <div class="post">
        <h2 class="title"><a href="#Diagrams" name="Diagrams">Diagrams</a></h2>
        <p class="meta">
            <span class="subtopic">Why Diagrams?</span>
            <span class="topic">Diagrams</span>
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
            <span class="subtopic">Diagramas Weaknesses</span>
            <span class="topic">Diagrams</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                When the diagram it is used to describe the features into the code level, as the
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
            <span class="subtopic">Tools Weaknesses</span>
            <span class="topic">Diagrams</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                When the Diagram it is created in the planing moment. It should be possible to created it without the
                code need. Many tools are able to create sequence diagrams but big part of them are not able to keep on sync all
                the diagrams created to the team members, most of then are monoplataform,
                not colaborative, without history of changes, close format file, etc.
            </p>
            <p>
                In addition all design changes must be replicated in all the diagrams of the project and for all team members.
                Therefore, keep all update subtopic diagrams will become an increasingly expensive activity until it becomes unfeasible.
                The diagrams then become mere representations of how the project was originally designed without contemplating
                the continuous modifications and losing a lot of utility to enable the understanding of the current version of
                the project without the need to consult the source code.
            </p>
        </div>
    </div>
    <div class="post" >
        <h2 class="title"><a href="#Code to Diagram Propose" name="Code to Diagram Propose" >Code to Diagram Proposal</a></h2>
        <p class="meta">
            <span class="subtopic">Introduction</span>
            <span class="topic">Code to Diagram Proposal</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div>
            <div class="entry">
                <p>
                    This application proposal it is to provide ways to create diagrams based on PHP code execution or by web tools or
                    based on XML files / API making possible convert the result from each one tool to another.
                </p>
            </div>
            <canvas id="abc">
            </canvas>
            <div style="float:left; width: 35%; text-align: justify">
                <p>
                    So, external tools can create the XML Files what can be converted into diagrams and edited. The diagram can be created by some API call. PHP Code executions can
                    create XML files of diagrams what can be export to anothers applications. Diagrams can be created into the web
                    application exported to XML file what can be be read by some external application what can create code, for example.
                </p>
                <p >
                    In addition all design changes will be automatically replicated in all the diagrams of some project and for all team members.
                    Moreover, each change will be keeped into history, what can provide informations of who, when and why some change had to be done.
                </p>
                <p>
                    When the implementation provided in the diagrams, become a reality, a new diagram can be formed from the execution of that code. This new diagram will remain faithful to the reality of running the code, contemplating your changes.
                </p>
            </div>
            <script type="text/javascript" charset="utf-8">
                var intWidth = Math.round( document.body.clientWidth / 3 );
                var intHeight = Math.round(  intWidth * 1.15 );
                var dblProportion =  intWidth / 400;
                var objBox = new window.autoload.newCanvasBoxStateDiagram( "abc" , intWidth , intHeight );
                window.box = objBox;
                function addStateElement( color )
                {
                    var objStateElement = new window.autoload.newCanvasBoxState();
                    objStateElement.objBehavior = new window.autoload.newCanvasBoxMagneticBehavior( objStateElement );
                    objStateElement.x = 0;//Math.random() *  window.box.width ;
                    objStateElement.y = 0;//Math.random() * window.box.height ;
                    objStateElement.fixed = true;
                    objStateElement.fillColor = "orange";
                    objStateElement.fixedColor = "orange";
                    objStateElement.drawFixed( true );
                    if( color )
                    {
                        objStateElement.fillColor = color;
                        objStateElement.fixedColor = color;
                        objStateElement.defaultColor = color;
                    }
                    window.box.addElement( objStateElement );
                    return objStateElement;
                }
                function addLine( objFrom , objTo , color )
                {
                    var objLine = new window.autoload.newCanvasBoxDependency( objFrom , objTo );
                    objLine.objBehavior = new window.autoload.newCanvasBoxDefaultConnectorBehavior( objLine );
                    //objLine.objBehavior = new window.autoload.newCanvasBoxDefaultConnectorBehavior( objLine );
                    objLine.x =  ( objFrom.x + objTo.x  ) / 2
                    objLine.y =  ( objFrom.y + objTo.y  ) / 2
                    if( color )
                    {
                        objLine.color = color;
                    }
                    window.box.addElement( objLine );
                    return objLine;
                }
                var objFactoryFromXml = addStateElement(  );
                objFactoryFromXml.strStateName = "Factory From Xml";
                objFactoryFromXml.x = 70 * dblProportion;
                objFactoryFromXml.y = 80 * dblProportion;

                var objFactoryFromCode = addStateElement(  );
                objFactoryFromCode.strStateName = "Factory From Code";
                objFactoryFromCode.x = 330 * dblProportion;
                objFactoryFromCode.y = 80 * dblProportion;

                var objDiagram = addStateElement( "rgb(200,200,230)" );
                objDiagram.strStateName = "Uml Diagram";
                objDiagram.x = 200 * dblProportion;
                objDiagram.y = 200 * dblProportion;

                var objPrinterHtml = addStateElement( );
                objPrinterHtml.strStateName = "Printer Html";
                objPrinterHtml.x = 100 * dblProportion;
                objPrinterHtml.y = 350 * dblProportion;

                var objPrinterXml = addStateElement( );
                objPrinterXml.strStateName = "Printer Xml";
                objPrinterXml.x = 200 * dblProportion;
                objPrinterXml.y = 400 * dblProportion;

                var objPrinterPng = addStateElement( );
                objPrinterPng.strStateName = "Printer Png";
                objPrinterPng.x = 300 * dblProportion;
                objPrinterPng.y = 350 * dblProportion;

        var objLine;
        objLine = addLine( objFactoryFromXml , objDiagram );
        objLine = addLine( objFactoryFromCode , objDiagram );
        objLine = addLine( objDiagram , objPrinterHtml );
        objLine = addLine( objDiagram , objPrinterXml  );
        objLine = addLine( objDiagram , objPrinterPng  );

                window.objLine = objLine;
            </script>
        </div>
        <p class="meta">
            <span class="subtopic">Code Instrumentation</span>
            <span class="topic">Code to Diagram Proposal</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                Just appending one line into your PHP bootstrap file(s) the execution will be sniffer by the
                <a href="codeInstrumentation.php">Code to Diagram - Code Instrumentation Application</a> what will log each method
                call and return, each function call and return and convert this log into a XML what can be
                see as a Sequence Diagram or Class Diagram using ours web editors of diagrams.
            </p>
        </div>
        <p class="meta">
            <span class="subtopic">Web Diagram Editor</span>
            <span class="topic">Code to Diagram Proposal</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                A web application to create and edit UML Diagrams what can read the XML files generated by the
                code instrumentation application and save the diagrams into others XML files. The diagram can
                be export as image. This web tool can be called by some external application what can send the
                diagram description into a XML form into the post data.
            </p>
        </div>
    </div>
    <div class="post">
        <h2 class="title"><a href="#">Code to Diagram Tool Kit</a></h2>
        <p class="meta">
            <span class="subtopic"><a href="codeInstrumentation.php">Code Instrumentation Tool</a></span>
            <span class="topic">Code to Diagram Tool Kit</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                This tool provides the creation of the XML of diagrams based on some
                code execution using code instrumentation or XDebug
                log analisys.
            </p>
        </div>
        <p class="meta">
            <span class="subtopic"><a href="sequenceDiagram.php" >Sequence Diagram Web Editor Tool</a></span>
            <span class="topic">Code to Diagram Tool Kit</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <img src="./images/thumb_mvc_codetodiagram.jpg" class="floatimage" alt="code to diagram sequence diagram thumbnail"/>
            <div>
                <p>
                    This tool provides the creation and edition of sequence diagrams
                    what can read and write the XMLs files generates by the code instrumentation tool.
                </p>
                <p>
                    Diagrams can be created based on data received by post from external applications.
                    The diagrams can be created and changed into a drag drop application created in javascript / php
                    what can exported the diagrams as images.
                </p>
                <p>
                    Future implementations will bring to this web tool the feature of history, web syncronization and
                    enterprise application using the google wave and google applications.
                </p>
            </div>
        </div>
        <p class="meta">
            <span class="subtopic"><a href="classDiagram.php">Class Diagram Web Editor Tool</a></span>
            <span class="topic">Code to Diagram Tool Kit</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <img src="./images/thumb_class_diagram.jpg" class="floatimage" alt="code to diagram class diagram thumbnail"/>
            <div>
                <p>
                    This tool provides the creation and edition of class diagrams
                    what can read and write the XMLs files generates by the code instrumentation tool.
                </p>
                <p>
                    Diagrams can be created based on data received by post from external applications.
                    The diagrams can be created and changed into a drag drop application created in javascript / php
                    what can exported the diagrams as images.
                </p>
                <p>
                    Future implementations will bring to this web tool the feature of history, web syncronization and
                    enterprise application using the google wave and google applications.
                </p>
            </div>
        </div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="post">
        <h2 class="title"><a href="#">Limitations</a></h2>
        <p class="meta">
            <span class="subtopic">Internet Explorer Output</span>
            <span class="topic">Limitations</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                While still not fully working on Internet Explorer because the
                <a href="http://www.findmebyip.com/litmus#target-selector">Internet Explorer Problems</a>,
                the generator already makes life easier for those
                responsible in maintaining this kind of diagrams.
                We welcome anyone with the patience and desire to make the
                CSS changes need for it to work on Internet Explorer but the
                diagram web tool is been rewrite into canvas tag
                can make the Internet Explorer compatibility more hard to do.
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
            <p>
                The web tools have been rewrited as canvas web tools that should bring some unstable versions
                and big changes into application code.
            </p>
            <p>
                The speed of development is slow mainly due to lack of investment in project.
                Case you think this project interesting and would like to see new features on it pretty soon,
                you can make a donation.
            </p>
        </div>
    </div>
    <div style="clear: both;">&nbsp;</div>
</div>
<?php
require_once( "footer.php" );
?>
