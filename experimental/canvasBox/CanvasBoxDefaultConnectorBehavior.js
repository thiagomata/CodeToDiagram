
var CanvasBoxDefaultConnectorBehavior = Class.create();
CanvasBoxDefaultConnectorBehavior.prototype =
{
    objBox: null,

    objBoxElement: null,

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

    onMouseOver: function onMouseOver( event )
    {
    },

    onMouseOut: function onMouseOut( event )
    {
    },

    onMouseDown: function onMouseDown( event )
    {
    },

    onClick: function onClick( event )
    {
    },

    onDblClick: function onDblClick( event )
    {
    },

    onDrag: function onDrag( event )
    {
    },

    onDrop: function onDrop( event )
    {
    },

    onTimer: function onTimer()
    {
    },

    getForce: function getForce( objElement )
    {
        return null;
    }
}