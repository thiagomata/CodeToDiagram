/*
 * Canvas Box Button
 *
 * Interactive Elements to make possible to create new interactions without the use of the menu
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
var CanvasBoxButton = Class.create();
CanvasBoxButton.prototype =
{
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
    width: 25,

    /**
     * Button Height
     */
    height: 25,

    /**
     * Distance between the button and the element
     */
    borderWidth: 10,

    /**
     * Distance between the button and the element
     */
    borderHeight: 3,

    /**
     * @var CanvasBoxButton
     */
    objPreviousButton: null,

    /**
     * @var CanvasBoxElement
     */
    objElement: null,


    /**
     * Canvas 2D Context from the Canvas Box Container
     * @type CanvasRenderingContext2D
     */
    objContext: null,

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
    },

    refresh: function refresh()
    {
        if( this.objPreviousButton == null )
        {
            switch( this.strPositionHorizontal )
            {
                case "left":
                {
                    this.intRelativeX = -this.width -this.borderWidth;
                    break;
                }
                case "center":
                {
                    this.intRelativeX = this.objElement.width / 2;
                    break;
                }
                case "right":
                {
                    this.intRelativeX = this.objElement.width + this.borderWidth;
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
                    this.intRelativeY = -this.height -this.borderHeight;
                    break;
                }
                case "middle":
                {
                    this.intRelativeY = this.objElement.height / 2;
                    break;
                }
                case "bottom":
                {
                    this.intRelativeY = this.objElement.height + this.borderHeight;
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
        this.x = this.objElement.x - this.objElement.width/2 + this.intRelativeX;
        this.y = this.objElement.y - this.objElement.height/2 + this.intRelativeY;
    },

    drawOut: function drawOut()
    {
        this.objElement.objContext.fillStyle = "rgb( 250 , 250 , 250 )";
        this.objElement.objContext.fillRect( Math.round( this.x ) , Math.round( this.y ),
                                  Math.round( this.width ) , Math.round( this.height ) );
        this.objElement.objContext.strokeStyle = "rgb( 100 , 100 , 100 )";
        this.objElement.objContext.lineWidth = 1;//1px";
        this.objElement.objContext.strokeRect( Math.round( this.x ) , Math.round( this.y ),
                                  Math.round( this.width ) , Math.round( this.height ) );
    },

    drawOver: function drawOver()
    {
        this.objElement.objContext.fillStyle = 'rgb( 230 , 230 , 250 )';
        this.objElement.objContext.fillRect( Math.round( this.x ) , Math.round( this.y ),
                                  Math.round( this.width ) , Math.round( this.height ) );
        this.objElement.objContext.strokeStyle = "blue";
        this.objElement.objContext.lineWidth = 1;//1px";
        this.objElement.objContext.strokeRect( Math.round( this.x ) , Math.round( this.y ),
                                  Math.round( this.width ) , Math.round( this.height ) );
    },

    drawIcon: function drawIcon()
    {
        this.objElement.objContext.beginPath();
        this.objElement.objContext.save();
        this.objElement.objContext.strokeStyle = "rgb( 20, 20, 20)";
        this.objElement.objContext.fillStyle = this.booMouseOver ? "rgb( 250, 250, 250)" : "rgb( 220, 220, 220)" ;
        this.objElement.objContext.moveTo( this.x  , this.y + this.height  );
        this.objElement.objContext.lineTo( this.x + 6 , this.y + this.height - 2 );
        this.objElement.objContext.lineTo( this.x + 8 , this.y + this.height - 8 );
        this.objElement.objContext.lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.objContext.lineTo( this.x + 30 , this.y + this.height - 16 );
        this.objElement.objContext.lineTo( this.x + 30 , this.y + this.height - 30 );
        this.objElement.objContext.lineTo( this.x + 16 , this.y + this.height - 30 );
        this.objElement.objContext.lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.objContext.lineTo( this.x + 8 , this.y + this.height - 8 );
        this.objElement.objContext.lineTo( this.x + 2 , this.y + this.height - 6 );
        this.objElement.objContext.lineTo( this.x , this.y + this.height );
        this.objElement.objContext.stroke();
        this.objElement.objContext.fill();
        this.objElement.objContext.restore();
        this.objElement.objContext.closePath();
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
        this.drawIcon();
    },

    draw: function draw()
    {
        this.refresh();
        if ( this.objElement.booMouseOver )
        {
            this.drawButton();
        }
    },

    onClick: function onClick( event )
    {
        return CanvasBoxClass.Static.createRelation( this.objElement , true, "CanvasBoxAggregation" );
    },

    onDrag: function onDrag( event )
    {
        var objElement = this.onClick( event );
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

