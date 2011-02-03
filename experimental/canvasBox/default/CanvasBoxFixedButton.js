/*
 * Canvas Box Button
 *
 * Interactive Elements to make possible to create new interactions without the use of the menu
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
var CanvasBoxFixedButton = Class.create();
CanvasBoxFixedButton.prototype =
{
    strTitle: "Default Button",

    intPaddingTop: 0,
    
    intPaddingLeft: 0,

    /**
     * X Position of the Button relative to the element what it's belong to
     */
    intRelativeX: 0,

    /**
     * Y Position of the Button relative to the element what it's belong to
     */
    intRelativeY: 0,

    /**
     * X Absolute Position
     */
    x: 0,

    /**
     * Y Absolute Position
     */
    y: 0,

    /**
     * Possibles Horizontal Positions
     */
    arrPositionsHorizontal: Array( "left" , "center" , "right"),

    /**
     * Button Horizontal Position
     */
    strPositionHorizontal: "right",

    /**
     * Possibles Vertical Positions
     */
    arrPositionsVertical: Array( "top" , "middle" , "bottom"),

    /**
     * Button Vertical Position
     */
    strPositionVertical: "top",

    /**
     * Button Width
     */
    width: 55,

    /**
     * Button Height
     */
    height: 55,

    /**
     * Distance between the button and the element
     */
    borderWidth: 20,

    /**
     * Distance between the button and the element
     */
    borderHeight: 20,

    /**
     * @var CanvasBoxButton
     */
    objPreviousButton: null,

    /**
     * @var CanvasBoxElement
     */
    objElement: null,

    /**
     * Flag to control if the mouse is over the element
     */
    booMouseOver: false,

    /**
     * Constructor of the Canvas Box Button
     *
     * @param objElement CanvasBoxElement
     * @return void
     */
    initialize: function initialize( objElement )
    {
        this.objElement = objElement;
        this.x = 0;
        this.y = 0;
        this.booMouseOver = false;
        this.strPositionVertical = "top";
        this.strPositionHorizontal = "right";
        this.objPreviousButton = null;
    },

    refresh: function refresh()
    {
        if( this.objPreviousButton == null )
        {
            switch( this.strPositionHorizontal )
            {
                case "left":
                {
                    this.intRelativeX = 0;
                    break;
                }
                case "center":
                {
                    this.intRelativeX = this.objElement.width / 2;
                    break;
                }
                case "right":
                {
                    this.intRelativeX = this.objElement.width - this.width - this.borderWidth * 2;
                    break;
                }
                default:
                {
                    throw Error( "invalid horizontal position " + this.strPositionHorizontal );
                }
            }

            switch( this.strPositionVertical )
            {
                case "top":
                {
                    this.intRelativeY = 0;
                    break;
                }
                case "middle":
                {
                    this.intRelativeY = this.objElement.height / 2;
                    break;
                }
                case "bottom":
                {
                    this.intRelativeY = this.objElement.height - this.borderHeight;
                    break;
                }
                default:
                {
                    throw Error( "invalid vertical position " + this.strPositionVertical );
                }
            }
        }
        else
        {
            switch( this.strPositionHorizontal )
            {
                case "left":
                {
                    if( this.strPositionVertical == "middle" )
                    {
                        this.intRelativeX = this.objPreviousButton.intRelativeX;
                    }
                    else
                    {
                        this.intRelativeX = this.objPreviousButton.intRelativeX + this.objPreviousButton.width + this.objPreviousButton.borderWidth;
                    }
                    break;
                }
                case "center":
                { 
                    this.intRelativeX = this.objElement.width / 2;
                    break;
                }
                case "right":
                {
                    if( this.strPositionVertical == "middle" )
                    {
                        this.intRelativeX = this.objPreviousButton.intRelativeX;
                    }
                    else
                    {
                        this.intRelativeX = this.objPreviousButton.intRelativeX - this.width - this.borderWidth;
                    }
                    break;
                }
                default:
                {
                    throw Error( "invalid horizontal position " + this.strPositionHorizontal );
                }
            }

            switch( this.strPositionVertical )
            {
                case "top":
                {
                    if( this.strPositionHorizontal == "center" )
                    {
                        this.intRelativeY = this.objPreviousButton.intRelativeY - this.height - this.borderHeight;
                    }
                    else
                    {
                        this.intRelativeY = -this.height - this.borderHeight;
                    }
                    break;
                }
                case "middle":
                {
                    this.intRelativeY = this.objPreviousButton.intRelativeY + this.height + this.borderHeight;
                    break;
                }
                case "bottom":
                {
                    if( this.strPositionHorizontal == "center" )
                    {
                        this.intRelativeY = this.objPreviousButton.intRelativeY + this.objPreviousButton.height + this.objPreviousButton.borderHeight;
                    }
                    else
                    {
                        this.intRelativeY = this.objElement.height + this.borderHeight;
                    }
                    break;
                }
                default:
                {
                    throw Error( "invalid vertical position " + this.strPositionVertical );
                }
            }
        }
        this.x = this.intRelativeX + this.intPaddingLeft;
        this.y = this.intRelativeY + this.intPaddingTop;
    },

    drawOut: function drawOut()
    {
        this.objElement.getContext().save();
        this.objElement.getContext().fillStyle = ( "rgb( 250 , 250 , 250 )" );
        this.objElement.getContext().globalAlpha = ( 0.1 );
        this.objElement.getContext().fillRect(
            Math.round( this.x ) ,
            Math.round( this.y ) ,
            Math.round( this.width ) ,
            Math.round( this.height )
        );

        this.objElement.getContext().strokeStyle = ( "rgb( 100 , 100 , 100 )" );
        this.objElement.getContext().lineWidth = ( 1 );
        this.objElement.getContext().strokeRect(
            Math.round( this.x ) ,
            Math.round( this.y ) ,
            Math.round( this.width ) ,
            Math.round( this.height )
        );
        this.objElement.getContext().restore();
    },

    drawOver: function drawOver()
    {
        this.objElement.getContext().save();
        this.objElement.getContext().globalAlpha = ( 1 );
        this.objElement.getContext().fillStyle = ( 'rgb( 230 , 230 , 250 )' );
        this.objElement.getContext().fillRect(
            Math.round( this.x ) ,
            Math.round( this.y ) ,
            Math.round( this.width ) ,
            Math.round( this.height )
        );
        this.objElement.getContext().strokeStyle = ( "blue" );
        this.objElement.getContext().lineWidth = ( 1 );//1px";
        this.objElement.getContext().strokeRect(
            Math.round( this.x ) ,
            Math.round( this.y ) ,
            Math.round( this.width ) ,
            Math.round( this.height )
        );
        this.objElement.getContext().restore();
    },

    drawIcon: function drawIcon()
    {
        this.objElement.getContext().beginPath();
        this.objElement.getContext().save();
        this.objElement.getContext().strokeStyle = ( "rgb( 20, 20, 20)" );
        this.objElement.getContext().fillStyle = ( this.booMouseOver ? "rgb( 250, 250, 250)" : "rgb( 220, 220, 220)"  );
        this.objElement.getContext().moveTo( this.x  , this.y + this.height  );
        this.objElement.getContext().lineTo( this.x + 6 , this.y + this.height - 2 );
        this.objElement.getContext().lineTo( this.x + 8 , this.y + this.height - 8 );
        this.objElement.getContext().lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.getContext().lineTo( this.x + 30 , this.y + this.height - 16 );
        this.objElement.getContext().lineTo( this.x + 30 , this.y + this.height - 30 );
        this.objElement.getContext().lineTo( this.x + 16 , this.y + this.height - 30 );
        this.objElement.getContext().lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.getContext().lineTo( this.x + 8 , this.y + this.height - 8 );
        this.objElement.getContext().lineTo( this.x + 2 , this.y + this.height - 6 );
        this.objElement.getContext().lineTo( this.x , this.y + this.height );
        this.objElement.getContext().stroke();
        this.objElement.getContext().fill();
        this.objElement.getContext().restore();
        this.objElement.getContext().closePath();
    },

    drawTitle: function drawTitle()
    {
          this.objElement.getContext().save();
          this.objElement.getContext().shadowOffsetX = ( 2 );
          this.objElement.getContext().shadowOffsetY = ( 2 );
          this.objElement.getContext().shadowBlur = ( 2 );
          this.objElement.getContext().shadowColor = ( "rgba(250, 250, 250, 0.8)" );
          this.objElement.getContext().font = ( "20px Times New Roman" );
          this.objElement.getContext().fillStyle = ("rgb( 100 , 100, 100 )");
          this.objElement.getContext().textAlign = "left";
          this.objElement.getContext().fillText( this.strTitle , this.x + this.width + this.borderWidth , this.y + this.height / 2 + this.borderHeight / 2 );
          this.objElement.getContext().restore();
    },

    drawButton: function drawButton()
    {
        if( this.booMouseOver )
        {
            this.drawOver();
        }
        else
        {
            this.drawOut();
        }
        try{
         this.drawIcon( this.booMouseOver , this.x , this.y  );
        }
        catch(e)
        {
        this.objElement.getContext().strokeText( this.strClassName , this.x , this.y );
        }
    },

    draw: function draw()
    {
        this.refresh();
        if ( this.objElement.booMouseOver )
        {
            this.drawButton();
            if( this.booMouseOver )
            {
                this.drawTitle();
            }
        }
    },

    onClick: function onClick( event )
    {
        return CanvasBoxClass.Static.createRelation( this.objElement , true, "CanvasBoxAggregation" );
    },

    onDrag: function onDrag( event )
    {
        var objElement = this.onClick( event );
        objElement.intMass = 0;
        objElement.select();
        return objElement;
    },

    isInside: function isInside( mouseX , mouseY )
    {
        this.refresh();
        if  (
                ( mouseX >= this.x - this.borderWidth / 2)
                &&
                ( mouseX <= this.x + this.width + this.borderWidth / 2)
                &&
                ( mouseY >= this.y - this.borderHeight / 2 )
                &&
                ( mouseY <= this.y + this.height + this.borderHeight / 2)
            )
        {
            this.booMouseOver = true;
            return true;
        }
        this.booMouseOver = false;
        return false;
    }
}

