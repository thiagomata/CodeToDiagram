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
?>
<html>
    <form action="sequence.php" method="post">
        zoom: <input type="text" value="100" name="zoom"/>
        title: <input type="text" value="just talk" name="title"/>
        <br/>
        xml:
        <textarea name="xml" style="width:100%;height:400px">
            <sequence>
                <actors>
                    <actor id="1" type="user">me:people</actor>
                    <actor id="2" type="system">you:people</actor>
                </actors>
                <messages>
                    <message type="call" from="1" to="2" text="hi"/>
                    <message type="return" from="2" to="1" text="hello"/>
                </messages>
            </sequence>
        </textarea>
        <input type="submit" value="send"/>
    </form>
</html>