var CanvasBoxClass = Class.create();
Object.extend( CanvasBoxClass.prototype, CanvasBoxElement.prototype);
Object.extend( CanvasBoxClass.prototype,
{
    side: 100,

    x0: 0,

    x1: 0,

    dx: 0,

    y0: 0,

    y1: 0,

    dy: 0,

    width: 0,

    height: 0,

    color: "rgb(250,250,250)",

    borderColor: "rgb(100,100,100)",

    borderWidth: 1,
    
    objBehavior: null,

    objContext: null,

    intMass: 1,

    intMagnetism: 40,

    strClassName: "noop",

    arrParams: Array( "#strName string","#intAge integer"),

    refresh: function refresh()
    {
        this.x0 = this.x - ( this.side / 2 );
        this.x1 = this.x + ( this.side / 2 );
        this.y0 = this.y - ( this.side / 2 );
        this.y1 = this.y + ( this.side / 2 );
        if( this.x0 < 0 )
        {
            this.x0 = 0;
        }
        if( this.y0 < 0 )
        {
            this.y0 = 0;
        }
        this.width = this.side;
        this.height = this.side;
    },

    draw: function draw()
    {
        this.refresh();
        this.objContext.fillStyle = this.color;
        this.objContext.fillRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , Math.round( this.height ) );
        this.objContext.strokeStyle = this.borderColor;
        this.objContext.lineWidth = this.borderWidth;
        this.objContext.strokeRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , Math.round( this.height ) );
        this.objContext.strokeText( this.strClassName, this.x0 + 10 , this.y0 + 10 );

        for( var i = 0 ; i < this.arrParams.length; ++i )
        {
            this.objContext.strokeText( this.arrParams[ i ], this.x0 + 10 , this.y0 + 10 + ( i + 2 ) * 10 );
        }
    },

    drawMouseOver: function drawMouseOver( event )
    {
        if( this.defaultBorderColor == undefined )
        {
            this.defaultBorderColor = this.borderColor;
        }
        this.borderColor = "rgb( 100 , 200, 100 )";
    },

    drawMouseOut: function drawMouseOut( event )
    {
        this.borderColor = this.defaultBorderColor;
    },

    drawDrag: function drawDrag( event )
    {
        if(!this.defaultColor)
        {
            this.defaultColor = this.color;
        }
        this.color = "rgb( 200 , 200 , 250 )"
    },

    drawDrop: function drawDrop( event )
    {
        if( this.defaultColor )
        {
            this.color = this.defaultColor;
        }
    },

    drawFixed: function drawFixed( boolFixed )
    {
        if( boolFixed )
        {
            this.borderWidth *= 5;
        }
        else
        {
            this.borderWidth /= 5;
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
    }

});