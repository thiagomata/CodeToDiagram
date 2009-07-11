<?php
/**
 * @package public
 * @subpackage xmlToDiagram
 */

/**
 * This file make a little intro about what is the xml to diagram and
 * how it works, its projects, team, etc. After that it create a html
 * web form what make possible the creation of real time diagrams just
 * changing the xml and posting the form.
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
require_once( "../public/codetodiagram.php" );

$intZoom = (integer)CorujaArrayManipulation::getArrayField( $_POST , "zoom" , 100 );
$strFile = (string)CorujaArrayManipulation::getArrayField( $_REQUEST , "file" , "threeLittlePigs");

switch( $strFile )
{
    case "mvc":
    {
        $strXmlFile = '../examples/xmls/mvc.xml';
        $strTitle = "Model View Controller";
        break;
    }
    case "threeLittlePigs":
    default:
    {
        $strTitle = "Three Little Pigs";
        $strXmlFile = '../examples/ThreeLittlePigs/threeLittlePigs.xml';
    }
}
$strXml = CorujaArrayManipulation::getArrayField( $_POST , "xml" , file_get_contents( $strXmlFile ) );
$strXml =  html_entity_decode( trim( $strXml ) );
$strXml = stripslashes( $strXml );
$objXmlSequence = UmlSequenceDiagramFactoryFromXml::getInstance()->setXml( $strXml )->perform();

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
            Automatic Sequence Diagram
        </title>
    </head>
    <body>
        <h3>
            Code To Diagram
        </h3>
        <h4> Interpreting XML into Sequence Diagrams  </h4>
        <h5> Sequence Diagrams </h5>
        <div class="intro">
            <p>
                Sequence diagrams are simple and easy to understand.
                However, create sequence diagrams automatically can
                be very complex by XMI interpratation, image generation
                and still very restrict to some kind language or output.
            </p>
            <h5> Code to Diagram Proposal </h5>
                <div style="width:50%; float:left">
            <p>
                To make this process easier, We've developed an automatic
                diagram generator that factory the diagram object from
                many different factory as XML and
                <a href="index.php">Code Execution</a>
                ( yeahhh )
                then it can be sent to one of the printers that have the
                most diverse output types as XML, HTML, Jpeg, etc..
            </p>
            <p>
                Some printers need to be maded yet. And, if you have some
                special case, when any of the avaliable printers and factorys
                solve your problem, everthing it is extremly well 
                <a href="http://www.thiagomata.com/codetodiagram/svn/doc/dox/html/">doc</a>
                to help
                to you create new classes and append new features.
            </p>
                </div>
                <div style="text-align: center;width:50%; float:left">
                    <img src="./images/flow_codetodiagram.png"
                    alt="code to diagram flow"
                    longdesc="./images/flow_codetodiagram.txt"/>
                </div>
            <h5> Limitations </h5>
            <p>
                While still not fully working on Internet Explorer, the generator
                already makes life easier for those responsible in maintaining
                this kind of diagrams. We welcome anyone with the patience
                and desire to make the CSS changes need for it to work on IE.
            </p>
            <h5> Under Development </h5>
            <p>
                Also, fully compliance with UML 2.0 is still under development.
                Anyone interested in working in these fields is more than welcome
                to join the team. And if you have a patch on add-on to send, feel
                free to do so. Just send an e-mail to me thiago.henrique.mata@gmail.com .
            </p>
            <p>
                And remember, this is free software, in development, and as such, I can give you no
                warranty. Use it at your own risk. It's not for the faint of heart.
            </p>
            <p>
                Tag names can and should change. New tags can be add anytime. Stay tunned for more news.
            </p>
            <h5> Code to Diagram can do more ? </h5>
            <p>
                This look nice ? And if the diagram was created by a
                <a href="index.php" title="PHP to Diagram">
                    code execution
                </a>?
            </p>
            <h5> Download </h5>
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
                For external use <a href="caller.php"> try this link </a> and see the HTML code.
            </p>
            <h5> Examples </h5>
            <p>
                The example I posted is the <a href="http://www.shol.com/agita/pigs.htm" > story </a> of <a href="http://en.wikipedia.org/wiki/The_Three_Little_Pigs"> "Three Little Pigs"</a>.
                It should give you a view of how the generator works and also entertain you
                a little bit. Change the XML as you please to generate other
                diagrams of your own.
            </p>
            <ul>
                <li><a href="?file=threeLittlePigs">Three Little Pigs</a></li>
                <li><a href="?file=mvc">Model View Controller</a></li>
            </ul>
            <h5> Team </h5>
            <p>
                Special thanks to Raphael Melo and
                <a href="http://pt-br.facebook.com/people/Igor-Moreno/678110783">
                    Igor Moreno
                </a>
                for helping.
            </p>
            <p >
                Click
                <a href="http://www.assembla.com/wiki/show/codetodiagram/Team" title="Code to Diagram - Team">
                    here
                </a>
                to see the team responsible for the development of these projects
            </p>
         </div>
        <h4>
            <?php print $strTitle ?>
        </h4>
        <?php print UmlSequenceDiagramPrinterToHtml::getInstance()->getConfiguration()->setEmbeded( true )->setZoom( $intZoom )->perform( $objXmlSequence ) ?>
        <div style="float:left;width:100%">
            <h4>
                Now, change and create your own sequence diagram.
            </h4>
            <form method="post" action="">
                <label>
                    <span> Zoom: </span>
                    <span> <input type="text" name="zoom" value="<?php print $intZoom ?>" style="width:50px"/> % </span>
                </label>
                <label>
                    <span> Xml: </span>
                    <textarea name="xml" rows="20" cols="20"><?php print htmlentities( $strXml ) ?>
                    </textarea>
                </label>
                <label>
                    <input type="submit" value="Make My Sequence Diagram"/>
                </label>
            </form>
        </div>
        <?php require_once( "footer.php" ); ?>
    </body>
</html>