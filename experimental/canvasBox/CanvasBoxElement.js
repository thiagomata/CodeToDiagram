
var CanvasBoxElement = Class.create();
CanvasBoxElement.prototype =
{
    objBox: null,

    x: 0,

    y: 0,

    objBehavior: null,

    objContext: null,

    initialize: function initialize()
    {
        this.objBehavior = new CanvasBoxDefaultBehavior( this );
    },

    refresh: function refresh()
    {
        // to be overhide //
    },

    draw: function draw()
    {
        // to be overhide //
    },

    isInside: function isInside()
    {
        return false;
    },

    onMouseOver: function onMouseOver( event )
    {
        this.objBehavior.onMouseOver( event );
    },

    onMouseOut: function onMouseOut( event )
    {
        this.objBehavior.onMouseOut( event );
    },

    onMouseDown: function onMouseDown( event )
    {
        this.objBehavior.onMouseDown( event );
    },

    onClick: function onClick( event )
    {
        this.objBehavior.onClick( event );
    },

    onDblClick: function onDblClick( event )
    {
        this.objBehavior.onDblClick( event );
    },

    onDrag: function onDrag( event )
    {
        this.objBehavior.onDrag( event );
    },

    onDrop: function onDrop( event )
    {
        this.objBehavior.onDrop( event );
    },

    onTimer: function onTimer( event )
    {
        this.objBehavior.onTimer( event );
    }
}