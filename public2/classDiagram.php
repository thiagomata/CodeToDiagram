<?php 
$strPageItem = "Class";
require_once( "header.php" ); 
?>
<div id="content">
    <div class="post">
        <h2 class="title"><a href="#Class Diagrams Web Editor" name="Diagrams">Class Diagrams Web Editor</a></h2>
        <p class="meta">
            <span class="subtopic"><a href="classDiagram.php#Class Diagram Web Editor">Proposal</a></span>
            <span class="topic">Class Diagram Web Editor</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                This tool can be used to create new Class Diagram without existing code
                as well to bring more richness and personalize diagrams created by a code execution or by some XML File, 
                append to them notes of comments, colors, changing layout, or even to create a new sequence
                diagram based on some existing one.
            </p>
            <p>
                XML of Class Diagrams can be created by some different tool, into a different language. The
                Class Diagram Editor will receive the XML file by a POST and return the created diagram without any problems.
                The XML used it is much more simple of the XML of the UML XMI.
            </p>
        </div>
        <p class="meta">
            <span class="subtopic"><a href="classDiagram.php#Class Diagram Web Editor">Comming Soon Features</a></span>
            <span class="topic">Class Diagram Web Editor</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                As a web tool it has no plataform restriction and new features of colaborative edition using google wave and
                become a google application are into the planned features.
            </p>
            <p>
                As said above, <strong>The Class Diagram generation still is in working progress</strong>, some necessary features are missing,
                new features are append each day. You can help to accelerate this development making a <a href="#donation">donation</a>.
            </p>
            <p>
                Future features:
            </p>
            <ul>
                <li>
                    Add Attribute
                </li>
                <li>
                    Remove Attribute
                </li>
                <li>
                    Change Attribute
                </li>
                <li>
                    Add Method
                </li>
                <li>
                    Remove Method
                </li>
                <li>
                    Change Method
                </li>
                <li>
                    Zoom in / out
                </li>
                <li>
                    Write File
                </li>
                <li>
                    Read XML File
                </li>
            </ul>
        </div>
        <p class="meta">
            <span class="subtopic"><a href="classDiagram.php#Class Diagram Web Editor">What is already done?</a></span>
            <span class="topic">Class Diagram Web Editor</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                Using Javascript Canvas, the web tool of Class Diagrams is ready to be tested as can be seen
                in this <a href="#classDiagramEditor.php">external example</a> or in the embedded example below.
            </p>
            <p>
                Actual implemented features:
            </p>
            <ul>
                <li>
                    Create and Remove Class Element
                </li>
                <li>
                     F2 to Rename Class
                </li>
                <li>
                    Drag Drop Class
                </li>
                <li>
                    Move class with Arrows
                </li>
                <li>
                    Fix class with space
                </li>
                <li>
                    Context Menu
                </li>
                <li>
                    Aggregation Relationship
                </li>
                <li>
                    Association Relationship
                </li>
                <li>
                    Composition Relationship
                </li>
                <li>
                    Dependency Relationship
                </li>
                <li>
                    Generalization Relationship
                </li>
            </ul>
            <div id="box">
                <canvas id="canvasBox">
                </canvas>
                <script type="text/javascript" charset="utf-8">
                    objBox = new CanvasBox( "canvasBox" ,
                    document.getElementById("box").clientWidth, 700     );

                    var objClass = new CanvasBoxClass();
                    objClass.objBehavior = new CanvasBoxMagneticBehavior( objClass );
                    objClass.x = 100;
                    objClass.y = 100;
                    objClass.strClassElementName = "example";
                    objBox.addElement( objClass );
                </script>
            </div>
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
                Because of the <a href="http://www.findmebyip.com/litmus#target-selector">Internet Explorer Limitiations</a>,
                and of the decision of to make to make the web application in canvas, this application
                may not run into Internet Explorer. Exists some projects to make canvas work into Internet Explorer
                but, make this workaround it is not proprity to our team.
            </p>
        </div>
        <p class="meta">
            <span class="subtopic">Under Development</span>
            <span class="topic">Limitations</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                Also, fully compliance with UML 2.0 is still under development. The class diagram generation
                still does not has the minimal required features to be considered a beta release.
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
<?php require_once( "footer.php" ); ?>
