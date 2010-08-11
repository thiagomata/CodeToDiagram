var CanvasBoxState = Class.create();
Object.extend( CanvasBoxState.prototype, CanvasBoxElement.prototype);
Object.extend( CanvasBoxState.prototype,
{
    width: 150,

    height: 150,

    x0: 0,

    x1: 0,

    dx: 0,

    y0: 0,

    y1: 0,

    dy: 0,
    
    z: 3,

    borderColor: "rgb(10,10,10)",

    borderWidth: 1,
    
    objBehavior: null,

    objContext: null,

    intMass: 1,

    intMagnetism: 15,

    strStateName: "state",

    fillColor: "rgb( 232 , 232, 255  )",

    fixedColor: "rgb( 200, 200 ,200 )",

    overColor: "rgb( 100 , 200 , 200 )",

    dragColor: "rgb( 200 , 200 , 250 )",

    intWallRepelsForce: 0.5,

    strClassName: "CanvasBoxState",

    objMenu: null,

    booMenu: false,

    side: 45,
    
    initialize: function initialize()
    {
        this.objBehavior = new CanvasBoxDefaultBehavior( this );


        this.objMenu = new CanvasBoxMenu();
        this.objMenu.objParent = this;
        this.objMenu.arrMenuItens = ({
            0:{
                name: "create from state",
                event: function( objParent ){

                    var objClass = new CanvasBoxState();
                    objClass.objBehavior = new window[ objParent.objBehavior.strClassName ]( objClass );
                    objClass.x = objParent.objBox.mouseX + 100;
                    objClass.y = objParent.objBox.mouseY + 100;
                    objParent.objBox.addElement( objClass );

                    var objFrom = objClass;
                    var objTo = objParent;
                    var objLine = new CanvasBoxStateLink( objFrom , objTo );
                    switch( objParent.objBehavior.strClassName )
                    {
                        case "CanvasBoxMagneticBehavior":
                        {
                            objLine.objBehavior = new CanvasBoxMagneticConnectorBehavior( objLine );
                            break;
                        }
                        case "CanvasBoxDefaultBehavior":
                        default:
                        {
                            objLine.objBehavior = new CanvasBoxDefaultConnectorBehavior( objLine );
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

                    var objClass = new CanvasBoxState();
                    objClass.objBehavior = new window[ objParent.objBehavior.strClassName ]( objClass );
                    objClass.x = objParent.objBox.mouseX + 100;
                    objClass.y = objParent.objBox.mouseY + 100;
                    objParent.objBox.addElement( objClass );

                    var objFrom = objParent;
                    var objTo = objClass;
                    var objLine = new CanvasBoxStateLink( objFrom , objTo );
                    switch( objParent.objBehavior.strClassName )
                    {
                        case "CanvasBoxMagneticBehavior":
                        {
                            objLine.objBehavior = new CanvasBoxMagneticConnectorBehavior( objLine );
                            break;
                        }
                        case "CanvasBoxDefaultBehavior":
                        default:
                        {
                            objLine.objBehavior = new CanvasBoxDefaultConnectorBehavior( objLine );
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
        this.mouseOver = true;
    },

    drawMouseOut: function drawMouseOut( event )
    {
        if( this.defaultColor )
        {
            this.fillColor = this.fixed ? this.fixedColor : this.defaultColor;
        }
        this.mouseOver = false;
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
    
    isInside: function isInside( mouseX , mouseY )
    {
        this.refresh();
        if  (
                ( mouseX >= this.x0 )
                &&
                ( mouseX <= this.x1 )
                &&
                ( mouseY >= this.y0 )
                &&
                ( mouseY <= this.y1 )
            )
        {
            return true;
        }
        else
        {
            return false;
        }
    },

    onContextMenu: function onContextMenu( event )
    {
        this.objBox.booShowMenu = !this.objBox.booShowMenu;
        if( this.objBox.booShowMenu )
        {
            this.objMenu.intMenuX = this.objBox.mouseX;
            this.objMenu.intMenuY = this.objBox.mouseY;
            this.objMenu.objContext = this.objContext;
            this.objMenu.strActualMenuItem = null;
            this.objBox.objMenuSelected = this.objMenu;
        }
        return false;
    },

    onClick: function onClick( event )
    {
       return this.objBehavior.onClick( event );
    },

    goUp: function goUp()
    {
        this.fixed = true;
        this.drawFixed( this.fixed );
        this.y -= 10;
    },
    
    goDown: function goDown()
    {
        this.fixed = true;
        this.drawFixed( this.fixed );
        this.y += 10;
    },
    
    goLeft: function goLeft()
    {
        this.fixed = true;
        this.drawFixed( this.fixed );
        this.x -= 10;
    },
    
    goRight: function goRight()
    {
        this.fixed = true;
        this.drawFixed( this.fixed );
        this.x += 10;
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
