<?php 
$strPageItem = "Sequence";
require_once( "header.php" );
require_once( "../public/codetodiagram.php" );
$strXml = CorujaArrayManipulation::getArrayField( $_REQUEST , "xml" , "" );
$booPost = ( $strXml != "" );
if( $strXml == "" )
{
    $strXml = file_get_contents ( '../examples/xmls/mvc.xml' );
}
$strXml =  html_entity_decode( $strXml );
$strXml = stripslashes( $strXml );
$objXmlSequence = @UmlSequenceDiagramFactoryFromXml::getInstance()->setXml( $strXml )->perform();
if( count( $objXmlSequence->getActors() ) > 0 )
{
    $strTitle = CorujaArrayManipulation::getArrayField( $_REQUEST, "title" , 'Sequence Diagram' );
    $intFont = (integer)CorujaArrayManipulation::getArrayField( $_REQUEST , "font" , 60 );
    $intZoom = (integer)CorujaArrayManipulation::getArrayField( $_REQUEST , "zoom" , 60 );
    $booDetails = (boolean)CorujaArrayManipulation::getArrayField( $_REQUEST , "detais" , false );

    UmlSequenceDiagramPrinterToHtml::getInstance()->
        getConfiguration()->
        setZoom( $intZoom )->
        setPercentFont( $intFont )->
        setShowDetails( $booDetails )->
        setEmbeded( true );

}
else
{
    $objXmlSequence = null;
}
?>
<div id="content">
    <div class="post">
        <h2 class="title"><a href="#">Sequence Diagram Web Editor</a></h2>
        <p class="meta">
            <span class="subtopic">Proposal</span>
            <span class="topic">Sequence Diagram Web Editor</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                This tool can be used to create new Sequence Diagram without existing code
                as well to bring more richness and personalize diagrams created by a code execution
                or by some XML File,
                append to them notes of comments, colors, changing layout, or even to create a
                new sequence diagram based on some existing one.
            </p>
            <p>
                XML of Sequence Diagrams can be created by some different tool, into a different language. The
                Sequence Diagram Editor will receive the XML file by a POST and return the created diagram without any problems.
                The XML used it is much more simple of the XML of the UML XMI.
            </p>
        </div>
        <p class="meta">
            <span class="subtopic"> Design Pattern </span>
            <span class="topic">Sequence Diagram Web Editor</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <div>
                <div class="comColunas">
                    <div class="duasColunas">
                        <p>
                            The pattern used here was the factorys and printers.
                            There is many factorys what builds UML sequence
                            diagram objects and many options of printers what
                            create a different result based on the UML sequence
                            diagram object received.
                        </p>
                    </div>
                    <div class="duasColunas">
                        <img src="./images/flow_codetodiagram.png" id="flow_codetodiagram" />
                    </div>
                </div>
                <p>
                    If you have some special case, when any of the
                    avaliable printers and factorys
                    solve your problem, everthing it is extremly well
                    <a href="http://www.thiagomata.com/codetodiagram/doc/dox/html/">doc</a>
                    to help
                    to you create new classes and append new features.
                </p>
            </div>
        </div>
        <p class="meta">
            <span class="subtopic"><a href="classDiagram.php#Class Diagram Web Editor">Comming Soon Features</a></span>
            <span class="topic">Sequence Diagram Web Editor</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>
                As a web tool it has no plataform restriction and new features of colaborative edition using google wave and
                become a google application are into the planned features.
            </p>
            <p>
                The Sequence Diagram Web Tool is undergoing a complete rewrite phase,
                leaving to generate a static HTML output to generate an output on
                Javascript Canvas Web Tool, using CanvasBox where the diagram can be changed,
                saved, exported, etc. The HTML output can be one type of export output.
            </p>
            <p>
                As said above, <strong>The Sequence Diagram generation still is in working progress</strong>, some necessary features are missing,
                new features are append each day. You can help to accelerate this development making a <a href="#donation">donation</a>.
            </p>
            <p>
                Future features:
            </p>
            <ul>
                <li>
                    Change the output from HTML to CanvasBox
                </li>
                <li>
                    Rename Actors
                </li>
                <li>
                    Move Actors and Messages
                </li>
                <li>
                    Append Actors
                </li>
                <li>
                    Append Messages
                </li>
                <li>
                    Append Comments
                </li>
                <li>
                    Zoom in / out
                </li>
                <li>
                    Write XML File
                </li>
                <li>
                    Read XML File
                </li>
            </ul>
        </div>
        <p class="meta">
            <span class="subtopic"><a href="classDiagram.php#Class Diagram Web Editor">What is already done?</a></span>
            <span class="topic">Sequence Diagram Web Editor</span>
        </p>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <p>w
                This is the actual version of the Sequence Diagram Web Editor what will
                be deprecated with the new canvas version. This actual version make possible
                read some XML file and created, based on it, a HTML page with the Sequence
                Diagram. This Sequence Diagram can not be edited except changing the XML
                File and recreating all the diagram.
            </p>
            <p>
                Actual implemented features:
            </p>
            <ul>
                <li>
                    Read XML File
                </li>
                <li>
                    Html Diagram Export
                </li>
                <li>
                    Show Actors
                </li>
                <li>
                    Show Messages
                </li>
                <li>
                    Show Comments
                </li>
                <li>
                    Show Messages Return
                </li>
                <li>
                    Show Messages Parameters
                </li>
                <li>
                    Code Instrumentation XML Sequence Diagram Generation
                </li>
            </ul>
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
            <div class="comColunas">
                <div class="duasColunas">
                    <p>
                        And this xml (click on xml to edit it):
                    </p>
                    <a name="draw"><span>&nbsp;</span></a>
                    <div class="myXml" onclick="editXml()">
                        <div id="myHightLightXml"  title="click me to edit">
                            <?php CorujaDebug::printXmlCode(
                                    ($strXml )
                            );?>
                        </div>
                        <div id="editXml"  title="tab to save">
                            <form id="refreshXml" action="sequenceDiagram.php#draw" method="post" target="_self">
                                <textarea id="textAreaXml"
                                    name="xml"
                                    onchange="refreshXml()"
                                    onblur="backToHightLight()"
                                    ><?php print $strXml; ?></textarea>
                            </form>
                        </div>
                    </div>
                    <script>
                        function refreshXml()
                        {
                            document.getElementById( "refreshXml" ).target = "_self";
                            document.getElementById( "refreshXml" ).submit();
                        }

                        function editXml()
                        {
                            objHXml = document.getElementById( "myHightLightXml" );
                            objEXml = document.getElementById( "editXml" );
                            objHXml.style.display = "none";
                            objEXml.style.display = "block";
                        }
                        function backToHightLight()
                        {
                            objHXml = document.getElementById( "myHightLightXml" );
                            objEXml = document.getElementById( "editXml" );
                            objHXml.style.display = "block";
                            objEXml.style.display = "none";
                        }
                        function fullscreenMode()
                        {
                            document.getElementById( "refreshXml" ).action = "sequenceDiagramFullScreen.php";
                            document.getElementById( "refreshXml" ).target = "_blank";
                            document.getElementById( "refreshXml" ).submit();
                        }
                    </script>
                </div>
                <div style="width:100%;float:left">
                    <p>
                        Will bring to you this:
                    </p>
                    <div class="nostyle" id="sequendeDraw" onclick="fullscreenMode()" title="click to see in full screen">
                        <?php
                        if( $objXmlSequence != null )
                        {
                            print ( UmlSequenceDiagramPrinterToHtml::getInstance()->perform( $objXmlSequence ) );
                        }
                        else
                        {
                            ?>
                            <strong> Invalid XML received </strong>
                            <?php
                        }
                        ?>
                    </div>
                </div>
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
                While still not fully working on <a href="http://www.findmebyip.com/litmus#target-selector">Internet Explorer</a>,
                the generator already makes life easier for those
                responsible in maintaining this kind of diagrams.
                We welcome anyone with the patience and desire to make the
                CSS changes need for it to work on Internet Explorer.
            </p>
            <p>
                The Sequence Diagram should migrate from HTML with CSS to Canvas Box
                what the <a href="classDiagram.php">Class Diagram</a> already is using. This should make more easy
                interaction events as drag and drop, save as image, etc. So big changes
                are comming to the Sequence Diagram Web Editor.
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
<?php require_once( "footer.php" ); ?>
