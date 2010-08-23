var CanvasBoxState = Class.create();
Object.extend( CanvasBoxState.prototype, window.autoload.loadCanvasBoxElement().prototype);
Object.extend( CanvasBoxState.prototype,
{
    width: 90,

    height: 90,

    z: 3,

    borderColor: "rgb(10,10,10)",

    borderWidth: 1,
    
    intMagnetism: 25,

    strStateName: "state",

    fillColor: "rgb( 232 , 232, 255  )",

    fixedColor: "rgb( 200, 200 ,200 )",

    overColor: "rgb( 100 , 200 , 200 )",

    dragColor: "rgb( 200 , 200 , 250 )",

    strClassName: "CanvasBoxState",

    side: 45,

    initialize: function initialize()
    {
        this.init();
        
        this.objMenu = new autoload.newCanvasBoxMenu();
        this.objMenu.objBox = this.objBox;
        this.objMenu.arrMenuItens = ({
            0:{
                name: "create from state",
                event: function( objParent ){

                    var objClass = new autoload.newCanvasBoxState();
                    objClass.objBehavior = new window[ objParent.objBehavior.strClassName ]( objClass );
                    objClass.x = objParent.objBox.mouseX + 100;
                    objClass.y = objParent.objBox.mouseY + 100;
                    objParent.objBox.addElement( objClass );

                    var objFrom = objClass;
                    var objTo = objParent;
                    var objLine = new autoload.newCanvasBoxStateLink( objFrom , objTo );
                    switch( objParent.objBehavior.strClassName )
                    {
                        case "CanvasBoxMagneticBehavior":
                        {
                            objLine.objBehavior = new autoload.newCanvasBoxMagneticConnectorBehavior( objLine );
                            break;
                        }
                        case "CanvasBoxDefaultBehavior":
                        default:
                        {
                            objLine.objBehavior = new autoload.newCanvasBoxDefaultConnectorBehavior( objLine );
                            break;
                        }

                    }
                    objLine.x =  ( objFrom.x + objTo.x  ) / 2
                    objLine.y =  ( objFrom.y + objTo.y  ) / 2
                    objParent.objBox.addElement( objLine );

                }
            },
            1:{
                name: "create to state",
                event: function( objParent ){

                    var objClass = new autoload.newCanvasBoxState();
                    objClass.objBehavior = new window[ objParent.objBehavior.strClassName ]( objClass );
                    objClass.x = objParent.objBox.mouseX + 100;
                    objClass.y = objParent.objBox.mouseY + 100;
                    objParent.objBox.addElement( objClass );

                    var objFrom = objParent;
                    var objTo = objClass;
                    var objLine = new autoload.newCanvasBoxStateLink( objFrom , objTo );
                    switch( objParent.objBehavior.strClassName )
                    {
                        case "CanvasBoxMagneticBehavior":
                        {
                            objLine.objBehavior = new autoload.newCanvasBoxMagneticConnectorBehavior( objLine );
                            break;
                        }
                        case "CanvasBoxDefaultBehavior":
                        default:
                        {
                            objLine.objBehavior = new autoload.newCanvasBoxDefaultConnectorBehavior( objLine );
                            break;
                        }

                    }
                    objLine.x =  ( objFrom.x + objTo.x  ) / 2
                    objLine.y =  ( objFrom.y + objTo.y  ) / 2
                    objParent.objBox.addElement( objLine );

                }
            }
        });

    },

    toSerialize: function toSerialize()
    {
        var objResult = new Object();
        objResult.x = Math.round( this.x );
        objResult.y = Math.round( this.y );
        objResult.width = this.width;
        objResult.height = this.height;
        objResult.Color = this.fillColor;
        objResult.borderColor = this.borderColor;
        objResult.borderWidth = this.borderWidth;
        objResult.intMass = this.intMass;
        objResult.intMagnetism = this.intMagnetism;
        objResult.strClassName = this.strClassName;
        objResult.arrAttributes = this.arrAttributes;
        objResult.arrMethods = this.arrMethods;
        objResult.fillColor = this.fillColor;
        objResult.fixedColor = this.fixedColor;
        objResult.overColor = this.overColor;
        objResult.dragColor = this.dragColor;
        objResult.intWallRepelsForce = this.intWallRepelsForce;
        objResult.strClassName = this.strClassName;
        return objResult;
    },
    
    refresh: function refresh()
    {
        this.width = this.side * 2;
        this.height = this.side * 2;
        this.x0 = this.x - ( this.width / 2 );
        this.x1 = this.x + ( this.width / 2 );
        this.y0 = this.y - ( this.height / 2 );
        this.y1 = this.y + ( this.height / 2 );

    },

    draw: function draw()
    {
        var i;

        this.refresh();

        if( this.mouseOver || this.objBox.objElementClicked == this )
        {
            /**
             * Draw External Border
             */
            this.objBox.setStrokeStyle( 'rgb( 200 , 200 , 250 )' );
            this.objBox.setLineWidth( 1 );
            this.objBox.beginPath();
            this.objBox.arc( this.x , this.y , this.side + 10 , 0 ,  Math.PI * 2 , true );
            this.objBox.stroke();
            this.objBox.closePath();
        }

        /**
         * Class Big Rect
         */
        this.objBox.setStrokeStyle( this.borderColor );
        this.objBox.setFillStyle( this.fillColor );
        this.objBox.beginPath();
        this.objBox.arc( this.x , this.y , this.side , 0 ,  Math.PI * 2 , true );
        this.objBox.fill();
        this.objBox.closePath();
        
        this.objBox.setLineWidth( "0.5" );
        this.objBox.setFont( "10px Arial lighter" );
        this.objBox.setTextAlign( "center" );
        this.objBox.strokeText( this.strStateName  , this.x , this.y );
    },

    drawMouseOver: function drawMouseOver( event )
    {
        if(!this.defaultColor)
        {
            this.defaultColor = this.fillColor;
        }
        this.fillColor = this.overColor;
    },

    drawMouseOut: function drawMouseOut( event )
    {
        if( this.defaultColor )
        {
            this.fillColor = this.fixed ? this.fixedColor : this.defaultColor;
        }
    },

    drawDrag: function drawDrag( event )
    {
        if(!this.defaultColor)
        {
            this.defaultColor = this.fillColor;
        }
        this.fillColor = this.dragColor;
    },

    drawDrop: function drawDrop( event )
    {
        if( this.defaultColor )
        {
            this.fillColor = this.fixed ? this.fixedColor : this.defaultColor;
        }
    },

    drawFixed: function drawFixed( boolFixed )
    {
        this.fixed = boolFixed;
        
        if( boolFixed )
        {
            this.fillColor = this.fixedColor;
        }
        else
        {
            this.fillColor = this.mouseOver ? this.overColor : this.defaultColor;
        }
    },
    
    rename: function rename()
    {
        var strClassNewName = prompt( "Inform the new name of the state." );
        if ( strClassNewName !== null )
        {
            this.strStateName = strClassNewName;
        }
    }
});
