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

    objBehavior: null,

    objContext: null,

    intMass: 1,

    intMagnetism: 20,

    refresh: function refresh()
    {
        this.x0 = this.x - ( this.side / 2 );
        this.x1 = this.x + ( this.side / 2 );
        this.y0 = this.y - ( this.side / 2 );
        this.y1 = this.y + ( this.side / 2 );
        /*
        if( this.x0 < 0 )
        {
            this.x0 = 0;
        }
        if( this.y0 < 0 )
        {
            this.y0 = 0;
        }
        */
        this.width = this.side;
        this.height = this.side;
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
    }
});