var CanvasBoxClass = Class.create();
Object.extend( CanvasBoxClass.prototype, CanvasBoxElement.prototype);
Object.extend( CanvasBoxClass.prototype,
{
    width: 150,

    height: 150,

    x0: 0,

    x1: 0,

    dx: 0,

    y0: 0,

    y1: 0,

    dy: 0,

    color: "rgb(200,200,200)",

    borderColor: "rgb(100,100,100)",

    borderWidth: 1,
    
    objBehavior: null,

    objContext: null,

    intMass: 5,

    intMagnetism: 25,

    strClassName: "noop",

    arrAttributes: Array( "#strName: string","#intAge: integer"),

    arrMethods: Array( "getName(): string","setName( string strName )"),

    fillColor: "rgb( 250 , 250, 255 )",

    fixedColor: "rgb( 200, 100 ,100 )",

    overColor: "rgb( 100 , 200 , 100 )",

    dragColor: "rgb( 200 , 200 , 250 )",

    intWallRepelsForce: 1,

    refresh: function refresh()
    {
        this.x0 = this.x - ( this.width / 2 );
        this.x1 = this.x + ( this.width / 2 );
        this.y0 = this.y - ( this.height / 2 );
        this.y1 = this.y + ( this.height / 2 );

    },

    draw: function draw()
    {
        var intHeaderHeigth = 18;

        this.refresh();

        if( this.mouseOver )
        {
        this.objContext.strokeStyle = 'rgb( 200 , 200 , 250 )';
        this.objContext.lineWidth = 1;
        this.objContext.strokeRect( Math.round( this.x0 ) - 10 , Math.round( this.y0 ) - 10,
                                  Math.round( this.width ) + 20 , Math.round( this.height ) + 20 );
        }

        this.objContext.fillStyle = this.fillColor;//this.color;
        this.objContext.fillRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , Math.round( this.height ) );
        this.objContext.fillStyle = this.color;
        this.objContext.fillRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , intHeaderHeigth );
        this.objContext.fillStyle = this.fillColor;//this.color;
        this.objContext.strokeStyle = this.borderColor;
        this.objContext.lineWidth = this.borderWidth;
        this.objContext.strokeRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , Math.round( this.height ) );
        this.objContext.strokeText( Math.round( this.x ) + ' ' + Math.round( this.y ) + ' ' + Math.round( this.dx ) + ' ' + Math.round( this.dy ) , this.x0 + 10 , this.y0 + 10 );

        var intAttributesStart = intHeaderHeigth + 20;
        var intAttributesEnd = intAttributesStart + this.arrAttributes.length * 10;
        
        this.objContext.strokeRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , Math.round( intAttributesEnd ) );


        for( var i = 0 ; i < this.arrAttributes.length; ++i )
        {
            this.objContext.strokeText( this.arrAttributes[ i ], this.x0 + 10 , this.y0 + intAttributesStart + ( i ) * 10 );
        }

        var intMethodsStart = intAttributesEnd;

        this.objContext.strokeRect( Math.round( this.x0 ) , this.y0 + intMethodsStart ,
                                  Math.round( this.width ) , Math.round( this.height ) - intMethodsStart );
        
        for( var i = 0 ; i < this.arrMethods.length; ++i )
        {
            this.objContext.strokeText( this.arrMethods[ i ], this.x0 + 10 ,  this.y0 + intMethodsStart + ( i ) * 10 + 20 );
        }
    },

    drawMouseOver: function drawMouseOver( event )
    {
        if(!this.defaultColor)
        {
            this.defaultColor = this.color;
        }
        this.color = this.overColor;
        this.mouseOver = true;
    },

    drawMouseOut: function drawMouseOut( event )
    {
        if( this.defaultColor )
        {
            this.color = this.fixed ? this.fixedColor : this.defaultColor;
        }
        this.mouseOver = false;
    },

    drawDrag: function drawDrag( event )
    {
        if(!this.defaultColor)
        {
            this.defaultColor = this.color;
        }
        this.color = this.dragColor;
    },

    drawDrop: function drawDrop( event )
    {
        if( this.defaultColor )
        {
            this.color = this.fixed ? this.fixedColor : this.defaultColor;
        }
    },

    drawFixed: function drawFixed( boolFixed )
    {
        this.fixed = boolFixed;
        
        if( boolFixed )
        {
            this.color = this.fixedColor;
        }
        else
        {
            this.color = this.fixedColor;
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
