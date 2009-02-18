<?php

require_once( '../classes/_start.php' );


$intZoom = (integer)getArrayElement( $_POST , "zoom" , 50 );
$strXml = getArrayElement( $_POST , "xml" , file_get_contents( 'sequence.xml' ) );

$objXmlSequence = new XmlSequence();
$objXmlSequence->setZoom( $intZoom);
$objXmlSequence->setXml( $strXml );

?>
<html>
    <head>
        <style>
            form label
            {
                display: block;
                width: 80%;
            }
            form textarea
            {
                width: 100%;
                height: 400px;
            }
            .intro
            {
                width: 750px;
                text-align:justify;
            }
            .sequenceDiagram
            {
                border-color: #DDDDDD;
                border-style: solid;
                border-width: 1px;
            }
        </style>
        <title>
            Automatic Sequence Diagram
        </title>
    </head>
    <body>
        <h4> Sequence Diagram Generator Xml->Html </h4>
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
                Special thanks to Raphael Melo and 
                <a href="http://pt-br.facebook.com/people/Igor-Moreno/678110783">
                    Igor Moreno 
                </a>
                for helping.
            </p>
         </div>
        <h4>
            Three Little Pigs
        </h4>
        <?php print $objXmlSequence->show(); ?>
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
