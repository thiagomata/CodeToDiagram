var CanvasBoxElement = Class.create();
CanvasBoxElement.prototype =
{
    /**
     * Canvas Box owner of this object
     * @type CanvasBox
     */
    objBox: null,

    /**
     * Position X of the Element inside the Canvas Box
     * @type integer
     */
    x: 0,

    /**
     * Position Y of the Element inside the Canvas Box
     * @type integer
     */
    y: 0,

    /**
     * Position Z of the Element inside the Canvas Box
     * @type integer
     */
    z: 1,
        
    /**
     * Velocity into the X position
     * @type integer
     */
    dx: 0,

    /**
     * Veolocity into the Y position
     * @type integer
     */
    dy: 0,
    
    /**
     * Behavior of the Canvas Box Element
     * 
     * @type CanvasBoxDefaultElementBehavior
     */
    objBehavior: null,

    /**
     * Canvas 2D Context from the Canvas Box Container
     * @type CanvasRenderingContext2D
     */
    objContext: null,

    /**
     * Class name of the Canvas Box Element
     * @type string
     */
    strClassName: "CanvasBoxElement",
    
	/**
	 * Flag that make easy diff the connectors from the regular elements
	 * without type cast ( slow in javascript )
	 * @type boolean
	 */
    isConnector: false,

    /**
     * Flag that controls if the relative menu is showing up
     * @type boolean
     */
    booShowMenu: false,

    /**
     * Relative menu from the Elements
     * @type CanvasBoxMenu
     */
    objMenu: null,

    /**
     * Flag of control if the Element is Fixed ( not moving )
     * @type boolean
     */
    fixed: false,

    /**
     * Flag of control if Element is on DragDrop Event
     * @type boolean
     */
    dragdrop: false,
    
    /**
     * Visual Buttons to interact with the element without
     * the menu use.
     */
    arrButtons: Array(),
    
    /**
     * Create a serializable version of this object
     * @return Object
     */
    toSerialize: function toSerialize()
    {
        var objResult = new Object();
        objResult.x = this.x;
        objResult.y = this.y;
        objResult.strClassName = this.strClassName;
        return objResult;
    }, 

    /**
     * Initialize the Canvas Box Element
     */
    initialize: function initialize()
    {
        this.objBehavior = new CanvasBoxDefaultBehavior( this );
    },

    /**
     * Refresh the Canvas Box Element, changing it's position if necessary
     * @return void
     */
    refresh: function refresh()
    {
        // to be overhide //
    },

    /**
     * Draw the Canvas Box Element
     * @return void
     */
    draw: function draw()
    {
        // to be overhide //
    },

    /**
     * Mouse Over check
     * @return boolean
     */
    isInside: function isInside()
    {
        return false;
    },

    /**
     * On Element Mouse Over Event
     * 
     * @param Event event
     * @return boolean
     */
    onMouseOver: function onMouseOver( event )
    {
        return this.objBehavior.onMouseOver( event );
    },

    /**
     * On Element Mouse Out Event
     * 
     * @param Event event
     * @return boolean
     */
    onMouseOut: function onMouseOut( event )
    {
        return this.objBehavior.onMouseOut( event );
    },

    /**
     * On Element Mouse Down Event
     * 
     * @param Event event
     * @return boolean
     */
    onMouseDown: function onMouseDown( event )
    {
        return this.objBehavior.onMouseDown( event );
    },

    /**
     * On Element Mouse Click Event
     * @param Event event
     * @return boolean
     */
    onClick: function onClick( event )
    {
        return this.objBehavior.onClick( event );
    },

    /**
     * On Element Double Mouse Click Event
     * @param Event event
     * @return boolean
     */
    onDblClick: function onDblClick( event )
    {
        return this.objBehavior.onDblClick( event );
    },

    /**
     * On Drag Event
     * @param Event event
     * @return boolean
     */
    onDrag: function onDrag( event )
    {
        return this.objBehavior.onDrag( event );
    },

    /**
     * On Drop Event
     * @param Event event
     * @return boolean
     */
    onDrop: function onDrop( event )
    {
        return this.objBehavior.onDrop( event );
    },

    /**
     * On Timer Event
     * @param Event event
     * @return boolean
     */
    onTimer: function onTimer( event )
    {
        return this.objBehavior.onTimer( event );
    },

    /**
     * On Context Menu Event
     * @param Event event
     * @return boolean
     */
    onContextMenu: function onContextMenu( event )
    {
        return false;
    },
    
    /**
     * Get Force from Element
     *
     * @param CanvasBoxElement
     * @return Object
     */
    getForce: function getForce( objBoxElement )
    {
        return this.objBehavior.getForce( objBoxElement );
    },

    getConnectors: function getConnectors()
    {
        var arrConnection = Array();
        var i;
        for( i = 0 ; i < this.objBox.arrElements.length; ++i )
        {
            var objElementElement = this.objBox.arrElements[ i ];
            if( is_object( objElementElement ) )
            {
                if( objElementElement.objElementFrom == this || objElementElement.objElementTo == this )
                {
                    arrConnection.push( objElementElement );
                }
            }
        }
        return arrConnection;
    },

    /**
     * Event on Delete Element
     */    
    onDelete: function onDelete( event )
    {
        var arrConnection = Array();
        var i;
        for( i = 0 ; i < this.objBox.arrElements.length; ++i )
        {
            var objElementElement = this.objBox.arrElements[ i ];
            if( is_object( objElementElement ) )
            {
                if( objElementElement.objElementFrom == this || objElementElement.objElementTo == this )
                {
                    arrConnection.push( objElementElement );
                }
            }
        }
        for( i = 0; i < arrConnection.length; ++i )
        {
            objElementElement = arrConnection[ i ];
            objElementElement.deleteCascade();
        }
    },
    
    /**
     * Get Id From Element
     * @return integer
     */  
    getId: function getId()
    {
        return this.objBox.arrElements.indexOf( this );
    },
    
    /**
     * Copy a Element
     */
    copy: function copy()
    {
        var objElement = new window[ this.strClassName ]();
        objElement.objBehavior = new window[ this.objBehavior.strClassName ]( objElement );
        objElement.x = Math.random() *  this.objBox.width ;
        objElement.y = Math.random() * this.objBox.height ;
        this.objBox.addElement( objElement );    
    },

    select: function select()
    {
        this.objBox.objElementSelected = this;
    },

    load: function load()
    {
    }
};

