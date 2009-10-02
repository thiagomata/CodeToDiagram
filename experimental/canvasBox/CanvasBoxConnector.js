var CanvasBoxConnector = Class.create();
Object.extend( CanvasBoxConnector.prototype, CanvasBoxElement.prototype);
Object.extend( CanvasBoxConnector.prototype,
{
    objBox: null,

    objElementFrom: null,

    objElementTo: null,

    x: 0,

    y: 0,

    objBehavior: null,

    objContext: null,

    initialize: function initialize( objElementFrom , objElementTo )
    {
        this.objElementFrom = objElementFrom;
        this.objElementTo = objElementTo;
        return this.objBehavior = new CanvasBoxDefaultBehavior( this );
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
        return this.objBehavior.onMouseOver( event );
    },

    onMouseOut: function onMouseOut( event )
    {
        return this.objBehavior.onMouseOut( event );
    },

    onMouseDown: function onMouseDown( event )
    {
        return this.objBehavior.onMouseDown( event );
    },

    onClick: function onClick( event )
    {
        return this.objBehavior.onClick( event );
    },

    onDblClick: function onDblClick( event )
    {
        return this.objBehavior.onDblClick( event );
    },

    onDrag: function onDrag( event )
    {
        return this.objBehavior.onDrag( event );
    },

    onDrop: function onDrop( event )
    {
        return this.objBehavior.onDrop( event );
    },

    onTimer: function onTimer( event )
    {
        return this.objBehavior.onTimer( event );
    },

    getForce: function getForce( objElement )
    {
        return this.objBehavior.getForce( objElement );
    }
});