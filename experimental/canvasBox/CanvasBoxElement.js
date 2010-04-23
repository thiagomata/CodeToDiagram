var CanvasBoxElement = Class.create();
CanvasBoxElement.prototype =
{
    objBox: null,

    x: 0,

    y: 0,

    z: 1,
    
    objBehavior: null,

    objContext: null,

    strClassName: "CanvasBoxElement",
    
    isConnector: false,

    booShowMenu: false,

    objMenu: null,

    fixed: false,

    dragdrop: false,
    
    toSerialize: function toSerialize()
    {
        var objResult = new Object();
        objResult.x = this.x;
        objResult.y = this.y;
        objResult.strClassName = this.strClassName;
        return objResult;
    }, 

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

    onContextMenu: function onContextMenu( event )
    {
        return false;
    },
    
    getForce: function getForce( objBoxElement )
    {
        return this.objBehavior.getForce( objBoxElement );
    },
    
    onDelete: function onDelete( event )
    {
        var arrConnection = Array();
        for( var i = 0 ; i < this.objBox.arrElements.length; ++i )
        {
            var objConnectorElement = this.objBox.arrElements[ i ];
            if( is_object( objConnectorElement ) && objConnectorElement.isConnector )
            {
                if( objConnectorElement.objElementFrom == this || objConnectorElement.objElementTo == this )
                {
                    arrConnection.push( objConnectorElement );
                }
            }
        }
        for( var i = 0; i < arrConnection.length; ++i )
        {
            objConnectorElement = arrConnection[ i ];
            objConnectorElement.deleteCascade();
        }
    },
    
    getId: function getId()
    {
        return this.objBox.arrElements.indexOf( this );
    },
    
    copy: function copy()
    {
        var objElement = new window[ this.strClassName ]();
        objElement.objBehavior = new window[ this.objBehavior.strClassName ]( objElement );
        objElement.x = Math.random() *  this.objBox.width ;
        objElement.y = Math.random() * this.objBox.height ;
        this.objBox.addElement( objElement );    
    }
};

