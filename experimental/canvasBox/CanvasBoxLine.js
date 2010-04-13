var CanvasBoxLine = Class.create();
Object.extend( CanvasBoxLine.prototype, CanvasBoxConnector.prototype);
Object.extend( CanvasBoxLine.prototype,
{
    side: 3,

    x0: 0,

    x1: 0,

    dx: 0,

    y0: 0,

    y1: 0,

    dy: 0,

    width: 0,

    height: 0,

    color: "rgb( 100, 100, 100 )",

    borderColor: "rgb( 200, 200, 200 )",

    borderWidth: 1,
    
    objBehavior: null,

    objContext: null,

    intMass: 1,

    intMagnetism: 2,

    intWallRepelsForce: 10,

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
        this.objContext.arc( this.x , this.y , this.side , 0 ,  Math.PI * 2 , true );
        this.objContext.fill();
        this.objContext.strokeStyle = this.borderColor;
        this.objContext.lineWidth = this.borderWidth;
        this.objContext.moveTo( this.x , this.y );
        this.objContext.lineTo( this.objElementFrom.x , this.objElementFrom.y );
        this.objContext.moveTo( this.x , this.y );
        this.objContext.lineTo( this.objElementTo.x , this.objElementTo.y );
        this.objContext.stroke();
        this.objContext.restore();
        this.objContext.moveTo( this.x , this.y );
        this.objContext.fillStyle = this.color;
        this.objContext.arc( this.x , this.y , this.side , 0 ,  Math.PI * 2 , true );
        this.objContext.fill();
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
    },

    drawMouseOver: function drawMouseOver( event )
    {
        if( !this.defaultSide )
        {
            this.defaultSide = this.side;
        }
        this.side = 6;
    },

    drawFixed: function drawFixed( boolFixed )
    {
        if( !this.defaultColor )
        {
             this.defaultColor = this.color;
        }
        
        if( boolFixed )
        {
            this.color = "rgb( 100 , 100 , 200 )";
            this.borderWidth *= 3;
            this.side = this.defaultSide;
        }
        else
        {
            this.color = this.defaultColor;
            this.borderWidth /= 3;
            this.side = this.defaultSide;
        }
    },

    drawMouseOut: function drawMouseOut( event )
    {
        this.side = this.defaultSide;
    }

});
