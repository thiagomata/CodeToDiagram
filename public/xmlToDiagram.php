<?php
/**
 * This file make a little intro about what is the xml to diagram and
 * how it works, its projects, team, etc. After that it create a html
 * web form what make possible the creation of real time diagrams just
 * changing the xml and posting the form.
 * 
 * @package public
 * @subpackage xmlToDiagram
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
require_once( "../_start.php" );

$intZoom = (integer)CorujaArrayManipulation::getArrayField( $_POST , "zoom" , 50 );
$strXml = CorujaArrayManipulation::getArrayField( $_POST , "xml" , file_get_contents( 'sequence.xml' ) );

$objXmlSequence = XmlSequenceFactoryXml::getInstance()->setXml( $strXml )->perform();

?>
<html>
    <head>
        <style >
            @import url("css/default.css");
        </style>
        <title>
            Automatic Sequence Diagram
        </title>
    </head>
    <body>
        <h3>
            Code To Diagram
        </h3>
        <h4> Sequence Diagram Generator From XML - XML => HTML  </h4>
        <div class="intro">
            <p>
                Sequence diagrams are simple and easy to understand.
                However, keeping them up-to-date during the development
                phase of a project can be onerous, sometimes even impeditive.
            </p>
            <p>
                To make this process easier, I've developed an automatic
                diagram generator that receives XML as input and ouputs
                an HTML page with the diagram.
            </p>
            <p>
                While still not fully working on Internet Explorer, the generator
                already makes life easier for those responsible in maintaining
                this kind of diagrams. We welcome anyone with the patience
                and desire to make the CSS changes need for it to work on IE.
            </p>
            <p>
                Also, fully compliance with UML 2.0 is still under development.
                Anyone interested in working in these fields is more than welcome
                to join the team. And if you have a patch on add-on to send, feel
                free to do so. Just send an e-mail to thiago.henrique.mata@gmail.com
            </p>
            <p>
                The example I posted is the <a href="http://www.shol.com/agita/pigs.htm" > story </a> of <a href="http://en.wikipedia.org/wiki/The_Three_Little_Pigs"> "Three Little Pigs"</a>.
                It should give you a view of how the generator works and also entertain you
                a little bit. Change the XML as you please to generate other
                diagrams of your own.

            </p>
            <p>
                And remember, this is free software, and as such, I can give you no
                warranty. Use it at your own risk. It's not for the faint of heart.
            </p>
            <p>
                For external use <a href="caller.php"> try this link </a> and see the HTML code.
            </p>
            <p>
                This software can be download by the SVN into the
                <a href="http://www.assembla.com/spaces/codetodiagram" title="Code To Diagram Project">
                    Code To Diagram
                </a>
                inside the
                <a href="http://www.assembla.com/">
                    Assembla
                </a>
                where you can find a detail description about the
                <a href="http://www.assembla.com/wiki/show/codetodiagram/Team" title="Code to Diagram - Team" >
                development team
                </a>
                and
                the project
            </p>
            <p>
                Special thanks to Raphael Melo and
                <a href="http://pt-br.facebook.com/people/Igor-Moreno/678110783">
                    Igor Moreno
                </a>
                for helping.
            </p>
            <p>
                This look nice ? And if the diagram was created by a 
                <a href="index.php" title=="PHP to Diagram">
                    code execution 
                </a>?
            </p>
         </div>
        <h4>
            Three Little Pigs
        </h4>
        <?php print XmlSequencePrinterDiagram::getInstance()->setZoom( $intZoom )->perform( $objXmlSequence ) ?>
        <div style="float:left;width:100%">
            <h4>
                Now, change and create your own sequence diagram.
            </h4>
            <form method="post">
                <label>
                    <span> Zoom: </span>
                    <span> <input type="text" name="zoom" value="<?php print $intZoom ?>" style="width:50px"/> % </span>
                </label>
                <label>
                    <span> Xml: </span>
                    <textarea name="xml">
                    <?php print $strXml ?>
                    </textarea>
                </label>
                <label>
                    <input type="submit" value="Make My Sequence Diagram"/>
                </label>
            </form>
        </div>
    </body>
</html>