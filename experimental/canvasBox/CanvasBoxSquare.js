var CanvasBoxSquare = Class.create();
Object.extend( CanvasBoxSquare.prototype, CanvasBoxElement.prototype);
Object.extend( CanvasBoxSquare.prototype,
{
    side: 6,

    x0: 0,

    x1: 0,

    dx: 0,

    y0: 0,

    y1: 0,

    dy: 0,
    
    width: 0,

    height: 0,

    color: "rgb(200,200,255)",

    init: function init()
    {

    },

    refresh: function refresh()
    {
        this.x += this.dx;
        this.y += this.dy;
        this.x0 = this.x - ( this.side / 2 );
        this.x1 = this.x + ( this.side / 2 );
        this.y0 = this.y - ( this.side / 2 );
        this.y1 = this.y + ( this.side / 2 );
        this.width = this.x1 - this.x0;
        this.height = this.y1 - this.y0;
        if( this.x < 0 )
        {
            //this.x = 0;
            this.dx = -this.dx;
        }
        if( this.x1 > this.objBox.width )
        {
            //this.x = this.objBox.width;
            this.dx = -this.dx;
        }
        if( this.y < 0 )
        {
            //this.y = 0;
            this.dy = -this.dy;
        }
        if( this.y1 > this.objBox.height )
        {
            //this.y = this.objBox.height;
            this.dy = -this.dy;
        }
    },

    draw: function draw()
    {
        this.refresh();
        this.objContext.fillStyle = this.color;
        this.objContext.fillRect( this.x0 , this.y0 , this.width , this.height );
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

    onMouseOver: function onMouseOver( event )
    {
        this.color = "red";
    },

    onMouseOut: function onMouseOut( event )
    {
        this.color = "green";
    },

    onClick: function onClick( event )
    {
        if( this.dx == 0)
        {
            this.dx = 1;
            this.dy = 1;
        }
        else
        {
            this.dx = 0;
            this.dy = 0;
        }
    }
});