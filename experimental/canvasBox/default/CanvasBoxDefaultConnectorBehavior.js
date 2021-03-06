
var CanvasBoxDefaultConnectorBehavior = Class.create();
CanvasBoxDefaultConnectorBehavior.prototype =
{
    strClassName: "CanvasBoxDefaultConnectorBehavior",
    
    objBox: null,

    objBoxElement: null,

    intXDistance: 0,

    intYDistance: 0,
    
    initialize: function initialize( objBoxElement )
    {
        this.objBoxElement = objBoxElement;
        this.objBox = objBoxElement.objBox;
    },

    draw: function draw()
    {
        return this.objBoxElement.draw();
    },

    refresh: function refresh()
    {
        this.objBoxElement.refresh();
    },

    isInside: function isInside()
    {
        return this.objBoxElement.isInside();
    },


    onTimer: function onTimer()
    {
        this.move();
    },

    onMouseOver: function onMouseOver( event )
    {
        if( this.objBoxElement.drawMouseOver )
        {
            this.objBoxElement.drawMouseOver( event );
        }
    },

    onMouseOut: function onMouseOut( event )
    {
        if( this.objBoxElement.drawMouseOut )
        {
            this.objBoxElement.drawMouseOut( event );
        }
    },

    onDblClick: function onDblClick( event )
    {
        if( this.objBoxElement.drawFixed )
        {
            this.objBoxElement.drawFixed( !this.objBoxElement.fixed  );
        }
    },

    onDrag: function onDrag( event )
    {
       var intOldX = Math.round( ( this.objBoxElement.objElementFrom.x + this.objBoxElement.objElementTo.x ) / 2 );
       var intOldY = Math.round( ( this.objBoxElement.objElementFrom.y + this.objBoxElement.objElementTo.y ) / 2 );
        this.objBoxElement.booDrag = true;

        this.intXDistance = this.objBoxElement.objBox.mouseX - intOldX;
        this.intYDistance = this.objBoxElement.objBox.mouseY - intOldY;
    },

    onDrop: function onDrop( event )
    {
        this.objBoxElement.booDrag = false;
    },

    onMouseDown: function onMouseDown( event )
    {
    },

    onClick: function onClick( event )
    {
    },

    move: function move()
    {
        if( this.objBoxElement.fixed )
        {
            return;
        }
        if( this.objBoxElement.objElementFrom != this.objBoxElement.objElementTo )
        {
            this.objBoxElement.x = ( this.objBoxElement.objElementFrom.x + this.objBoxElement.objElementTo.x ) / 2  + this.intXDistance;
            this.objBoxElement.y = ( this.objBoxElement.objElementFrom.y + this.objBoxElement.objElementTo.y ) / 2  + this.intYDistance;
        }
        else
        {
            if( Math.sqrt( this.intXDistance * this.intXDistance + this.intYDistance * this.intYDistance ) < 100 )
            {
                this.intXDistance = 100;
                this.intYDistance = 100;
            }
            this.objBoxElement.x = ( this.objBoxElement.objElementFrom.x + this.intXDistance );
            this.objBoxElement.y = ( this.objBoxElement.objElementFrom.y + this.intYDistance );
        }
    },

    getForce: function getForce( objElement )
    {
        return null;
    }
}