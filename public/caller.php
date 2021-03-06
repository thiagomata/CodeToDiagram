<?php
/**
 * @package public
 * @subpackage xmlToDiagram
 */

/**
 * This class it was maded to make easy to the public
 * test the sequence.php and see how they can create
 * a xml and send it to be process and geneare a html
 * sequence diagram calling the sequence.php
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * 
 */
 header( "Content-Type: text/html; charset=UTF-8" );
?>
<html>
    <body>
    <form action="sequence.php" method="post">
        zoom: <input type="text" value="100" name="zoom"/>
        title: <input type="text" value="just talk" name="title"/>
        <br/>
        xml:
        <textarea name="xml" style="width:100%;height:400px"><?php print file_get_contents( "sequence.xml" ) ?>
        </textarea>
        <input type="submit" value="send"/>
    </form>
    <?php require_once( "footer.php" ); ?>
    </body>
</html>
