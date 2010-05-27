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
    width: 15,

    /**
     * Button Height
     */
    height: 15,

    /**
     * Distance between the button and the element
     */
    border: 10,

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
     * @param CanvasBoxElement
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
                    this.intRelativeX = -this.width -this.border;
                    break;
                }
                case "center":
                {
                    this.intRelativeX = this.objElement.width / 2;
                    break;
                }
                case "right":
                {
                    this.intRelativeX = this.objElement.width + this.border;
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
                    this.intRelativeY = -this.height -this.border;
                    break;
                }
                case "middle":
                {
                    this.intRelativeY = this.objElement.height / 2;
                    break;
                }
                case "bottom":
                {
                    this.intRelativeY = this.objElement.height + this.border;
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
                        this.intRelativeX = this.objPreviousButton.intRelativeX + this.objPreviousButton.width + this.objPreviousButton.border;
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
                        this.intRelativeX = this.objPreviousButton.intRelativeX - this.width - this.border;
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
                        this.intRelativeY = this.objPreviousButton.intRelativeY - this.height - this.border;
                    }
                    else
                    {
                        this.intRelativeY = -this.width - this.border;
                    }
                    break;
                }
                case "middle":
                {
                    this.intRelativeY = this.objPreviousButton.intRelativeY + this.height + this.border;
                    break;
                }
                case "bottom":
                {
                    if( this.strPositionHorizontal == "center" )
                    {
                        this.intRelativeY = this.objPreviousButton.intRelativeY + this.objPreviousButton.height + this.objPreviousButton.border;
                    }
                    else
                    {
                        this.intRelativeY = this.objElement.height + this.border;
                    }
                    break;
                }
                default:
                {
                    throw Error( "invalid vertical position " + this.strPositionVertical );
                }
            }
        }
        document.title = this.intRelativeX;
        this.x = this.objElement.x - this.objElement.width/2 + this.intRelativeX;
        this.y = this.objElement.y - this.objElement.height/2 + this.intRelativeY;
    },

    draw: function draw()
    {
        if( !this.objElement.booMouseOver )
        {
             return;
        }
        this.refresh();
        this.objElement.objContext.fillStyle = ( this.booMouseOver ) ? "yellow" : "blue";
        this.objElement.objContext.fillRect( Math.round( this.x ) , Math.round( this.y ),
                                  Math.round( this.width ) , Math.round( this.height ) );
        this.objElement.objContext.strokeStyle = "red";
        this.objElement.objContext.lineWidth = "blue";
        this.objElement.objContext.strokeRect( Math.round( this.x ) , Math.round( this.y ),
                                  Math.round( this.width ) , Math.round( this.height ) );
        
    },

    isInside: function isInside( mouseX , mouseY )
    {
        this.refresh();
        if  (
                ( mouseX >= this.x - this.border / 2)
                &&
                ( mouseX <= this.x + this.width + this.border / 2)
                &&
                ( mouseY >= this.y - this.border / 2 )
                &&
                ( mouseY <= this.y + this.width + this.border / 2)
            )
        {
            this.booMouseOver = true;
            return true;
        }
        this.booMouseOver = false;
        return false;
    }
}

