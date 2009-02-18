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