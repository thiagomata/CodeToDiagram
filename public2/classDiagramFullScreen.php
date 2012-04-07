<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Testing the Box</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <?php require_once ( "./box/classDiagram.php" ) ?>
      <style>
          *
          {
              padding: 0;
              margin: 0;
              border: none;
          }
          canvas
          {
              border-style: solid;
              border-color: black;
              border-width: 1px;
          }
          #abc
          {
            margin-left:0px;
            margin-top:0px;
          }
      </style>
  </head>
  <body>
    <div id="tool">
        <div id="codeMode">
            
        </div>
        <div id="graphMode">
            <canvas id="abc" >
            </canvas>
            <script type="text/javascript" charset="utf-8">
                window.box = new CanvasBox( "abc" , document.body.clientWidth - 10, document.body.clientHeight - 10  );
                //window.box = objBox;
                function addClass( color )
                {
                    var objClass = new CanvasBoxClass();
                    objClass.objBehavior = new CanvasBoxMagneticBehavior( objClass );
                    //objClass.objBehavior = new CanvasBoxDefaultBehavior( objClass );
                    objClass.x = Math.random() *  window.box.width ;
                    objClass.y = Math.random() * window.box.height ;
                    if( color )
                    {
                        objClass.color = color;
                    }
                    window.box.addElement( objClass );
                    return objClass;
                }
                function addLine( objFrom , objTo , color )
                {
                    var objLine = new CanvasBoxLine( objFrom , objTo );
                    objLine.objBehavior = new CanvasBoxMagneticConnectorBehavior( objLine );
                    //objLine.objBehavior = new CanvasBoxDefaultConnectorBehavior( objLine );
                    objLine.x =  ( objFrom.x + objTo.x  ) / 2
                    objLine.y =  ( objFrom.y + objTo.y  ) / 2
                    if( color )
                    {
                        objLine.color = color;
                    }
                    window.box.addElement( objLine );
                    return objLine;
                }
                function cloneLine( objLineOriginal )
                {
                    return objLineOriginal.cloneLine();
                }
                addClass();
                //var objRed = addClass(  );
                //var objGreen = addClass(  );
                //var objYellow = addClass(  );
                //var objBlue = addClass( );
                //var objBlue1 = addClass( );
                //var objBlue2 = addClass( );

                //var objLine = addLine( objRed , objGreen );
                //var objLine = addLine( objYellow , objBlue );
                //var objLine = addLine( objYellow , objGreen );
                //var objLine = addLine( objBlue , objRed  );

                //window.objLine = objLine;
            </script>
        </div>
    </div>
  </body>
</html>
