var CanvasBoxLine = Class.create();
Object.extend( CanvasBoxLine.prototype, CanvasBoxConnector.prototype);
Object.extend( CanvasBoxLine.prototype,
{
    side: 2,

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

    intMass: 3,

    intMagnetism: 2,

    refresh: function refresh()
    {
        this.x0 = this.x - ( this.side / 2 );
        this.x1 = this.x + ( this.side / 2 );
        this.y0 = this.y - ( this.side / 2 );
        this.y1 = this.y + ( this.side / 2 );
        if( this.x0 < 0 )
        {
            this.x += this.side;
            return this.refresh();
        }
        if( this.y0 < 0 )
        {
            this.y += this.side;
            return this.refresh();
        }
        this.width = this.side;
        this.height = this.side;
    },

    draw: function draw()
    {
        this.refresh();
        this.objContext.save();
        this.objContext.beginPath();
        this.objContext.fillStyle = this.color;
        //this.objContext.fillRect( this.x0 , this.y0 , this.width , this.height );
        this.objContext.arc( this.x , this.y , this.side , 0 ,  Math.PI * 2 , true );
        this.objContext.strokeStyle = this.color;
        this.objContext.fill();
        this.objContext.moveTo( this.x , this.y );
        this.objContext.lineTo( this.objElementFrom.x , this.objElementFrom.y );
        this.objContext.moveTo( this.x , this.y );
        this.objContext.lineTo( this.objElementTo.x , this.objElementTo.y );
        this.objContext.stroke();
        this.objContext.restore();
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

    cloneLine: function cloneLine()
    {
        var objLine = new CanvasBoxLine( this , this.objElementTo );
        this.cloneConnector( objLine );
        return objLine;
    },

    clone: function clone( objConnector )
    {
        return this.cloneLine( objConnector );
    }

});
