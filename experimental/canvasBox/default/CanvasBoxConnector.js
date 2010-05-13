var CanvasBoxConnector = Class.create();
CanvasBoxConnector.prototype =
{
    objBox: null,

    objElementFrom: null,

    objElementTo: null,

    x: 0,

    y: 0,

    z: 0,
    
    dx: 3,

    dy: 3,
    
    objBehavior: null,

    objContext: null,

    strClassName: "CanvasBoxConnector",
    
    isConnector: true,

    booShowMenu: false,

    objMenu: null,
    
    toSerialize: function toSerialize()
    {
        var objResult = new Object();
        objResult.x = this.x;
        objResult.y = this.y;
        objResult.dx = this.dx;
        objResult.dy = this.dy;
        objResult.objElementFrom = this.objBox.arrElements.indexOf( this.objElementFrom );
        objResult.objElementTo = this.objBox.arrElements.indexOf( this.objElementTo );
        objResult.strClassName = this.strClassName;
        return objResult;
    },
      
    loadMenu: function loadMenu()
    {
        this.objMenu = new CanvasBoxMenu();
        this.objMenu.objParent = this;
        this.objMenu.arrMenuItens = ({
            0:{
                name: "clone connector",
                event: function( objParent ){
                    objParent.copy();
                }
            }
        });
    },
      
    initialize: function initialize( objElementFrom , objElementTo )
    {
        this.objElementFrom = objElementFrom;
        this.objElementTo = objElementTo;
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
        this.objBox.booShowMenu = !this.objBox.booShowMenu;
        if( this.objBox.booShowMenu )
        {
            this.loadMenu();
            this.objMenu.intMenuX = this.objBox.mouseX;
            this.objMenu.intMenuY = this.objBox.mouseY;
            this.objMenu.objContext = this.objContext;
            this.objMenu.strActualMenuItem = null;
            this.objBox.objMenuSelected = this.objMenu;
        }
        return false;
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
        
        objConnector.objBehavior = new window[ this.objBehavior.strClassName ]( objConnector );
        objConnector.x =  this.x;
        objConnector.y =  this.y;
        objConnector.side = this.defaultSide ? this.defaultSide : this.side;
        objConnector.color = this.defaultColor ? this.defaultColor : this.color;
        objConnector.borderColor = this.defaultBorderColor ? this.defaultBorderColor : this.borderColor;
        objConnector.borderWidth = this.defaultBorderWidth ? this.defaultBorderWidth : this.borderWidth;
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
    },
    
    onDelete: function onDelete()
    {
        if( this.objElementFrom.isConnector )
        {
            this.objElementFrom.objElementTo = this.objElementTo;
        }
        if( this.objElementTo.isConnector )
        {
            this.objElementTo.objElementFrom = this.objElementFrom;
        }
    },
    
    deleteCascade: function deleteCascade()
    {
        this.deleteCascadeFrom();
        this.deleteCascadeTo();
        this.objBox.deleteElement( this , false );
    },
    
    deleteCascadeTo: function deleteCascadeTo()
    {
        if( is_object( this.objElementTo ) && this.objElementTo.isConnector )
        {
            if( this.objElementTo.getId() != -1 )
            {
                this.objElementTo.deleteCascadeTo();
            }
            this.objBox.deleteElement( this.objElementTo , false );
        }
    },
    
    deleteCascadeFrom: function deleteCascadeFrom()
    {
        if( is_object( this.objElementFrom ) && this.objElementFrom.isConnector )
        {
            if( this.objElementFrom.getId() != -1 )
            {
                this.objElementFrom.deleteCascadeFrom();
            }
            this.objBox.deleteElement( this.objElementFrom , false );
        }
    },
  
    copy: function copy()
    {
        objConnector = new window[ this.strClassName ]();
        this.clone( objConnector );
    },
    
    getId: function getId()
    {
        return this.objBox.arrElements.indexOf( this );
    }    
};
