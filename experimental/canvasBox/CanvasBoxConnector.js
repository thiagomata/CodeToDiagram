var CanvasBoxConnector = Class.create();
Object.extend( CanvasBoxConnector.prototype, CanvasBoxElement.prototype);
Object.extend( CanvasBoxConnector.prototype,
{
    objBox: null,

    objElementFrom: null,

    objElementTo: null,

    x: 0,

    y: 0,

    dx: 3,

    dy: 3,
    
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
    },

    cloneConnector: function cloneConnector( objConnector )
    {
        if( !objConnector )
        {
            objConnector = new CanvasBoxConnector( this , this.objElementTo );
        }
        else
        {
            objConnector.initialize( this , this.objElementTo );
        }
        
        objConnector.objBehavior = new CanvasBoxMagneticConnectorBehavior( objConnector );
        objConnector.x =  this.x;
        objConnector.y =  this.y;
        objConnector.side = 5;
        if( this.color )
        {
            objConnector.color = this.color;
        }
        this.objBox.addElement( objConnector );
        this.objElementTo = objConnector;
        objConnector.objElementFrom = this;
        if( this.objElementFrom )
        {
            this.objElementFrom.objElementTo = this;
        }
        if( this.objElemenTo )
        {
            this.objElemenTo.objElementFrom = this;
        }
        if( objConnector.objElementFrom )
        {
            objConnector.objElementFrom.objElementTo = objConnector;
        }
        if( objConnector.objElementTo )
        {
            objConnector.objElementTo.objElementFrom = objConnector;
        }
        return objConnector;
    },

    clone: function clone( objConnector )
    {
        return this.cloneConnector( objConnector );
    }
});
