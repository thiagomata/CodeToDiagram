
var CanvasBoxDefaultBehavior = Class.create();
CanvasBoxDefaultBehavior.prototype =
{
    objBox: null,

    objBoxElement: null,

    fixed: false,

    dragdrop: false,

    intEscapeForce: 5,

    intMargin: 20,

    strClassName: "CanvasBoxDefaultBehavior",
    
    toSerialize: function toSerialize()
    {
        var objResult = new Object();
        return objResult;
    },
    
    initialize: function initialize( objBoxElement )
    {
        this.objBoxElement = objBoxElement;
        this.objBox = objBoxElement.objBox;
        this.objBoxElement.dx = 0;
        this.objBoxElement.dy = 0;
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

    onMouseDown: function onMouseDown( event )
    {
    },

    onClick: function onClick( event )
    {
    },

    onDblClick: function onDblClick( event )
    {
        this.fixed = !this.fixed;
        if( this.objBoxElement.drawFixed )
        {
            this.objBoxElement.drawFixed( this.fixed );
        }
    },

    onDrag: function onDrag( event )
    {
        this.dragdrop = true;
        this.objBoxElement.x = this.objBoxElement.objBox.mouseX;
        this.objBoxElement.y = this.objBoxElement.objBox.mouseY;

        if( this.objBoxElement.drawDrag )
        {
            this.objBoxElement.drawDrag();
        }
    },

    onDrop: function onDrop( event )
    {
        this.dragdrop = false;

        if( this.objBoxElement.drawDrop )
        {
            this.objBoxElement.drawDrop();
        }
    },
    
    onTimer: function onTimer()
    {
        this.move();
    },

    getForce: function getForce( objElement )
    {
        var objVector = Array();
        return objVector;
    },

    move: function move()
    {
        if( this.fixed || this.dragdrop )
        {
            return;
        }

       this.refresh();
    }
}
