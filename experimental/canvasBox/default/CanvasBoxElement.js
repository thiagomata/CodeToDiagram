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
    booDrag: false,

    objMenu: null,

    booMouseOver: false,

    /**
     * Visual Buttons to interact with the element without
     * the menu use.
     */
    arrButtons: null,

    intMass: 1,

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

    init: function init()
    {
        this.objBehavior = new autoload.newCanvasBoxDefaultBehavior( this );
        this.arrButtons = Array();
        this.booMouseOver = false;
        this.fixed = false;
    },
    
    /**
     * Initialize the Canvas Box Element
     */
    initialize: function initialize()
    {
        this.init();
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
     * On Element Mouse Over Event
     * 
     * @param Event event
     * @return boolean
     */
    onMouseOver: function onMouseOver( event )
    {
        this.booMouseOver = true;
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
        this.booMouseOver = false;
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
        if( !this.booDrag && this.intMass !== 0 && ( this.objBox.objElementSelected == null || this.objBox.objElementSelected == this ) )
        {
            for( var i = 0 ; i <  this.arrButtons.length ; ++i )
            {
                var objButton = this.arrButtons[ i ];
                if( objButton.booMouseOver )
                {
                    return objButton.onClick( event );
                }
            }
        }

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
        this.booDrag = true;

        if( this.intMass !== 0 && ( this.objBox.objElementSelected == null || this.objBox.objElementSelected == this ) )
        {
            for( var i = 0 ; i <  this.arrButtons.length ; ++i )
            {
                var objButton = this.arrButtons[ i ];
                if( objButton.booMouseOver )
                {
                    return objButton.onDrag( event );
                }
            }
        }

        return this.objBehavior.onDrag( event );
    },

    onDrop: function onDrop( event )
    {
        this.booDrag = false;

        if( this.intMass == 0 )
        {
            var arrConnectors = this.getConnectors();
            if( arrConnectors.length == 1 && ( this.objBox.objElementOver != this ) )
            {
                var objConnector = arrConnectors[0];
                if( objConnector.objElementFrom == this )
                {
                    objConnector.objElementFrom = this.objBox.objElementOver;
                }
                if( objConnector.objElementTo == this )
                {
                    objConnector.objElementTo = this.objBox.objElementOver;
                }
                this.objBox.deleteElement( this );
            }
        }
        this.intMass = 1;
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
        this.objBox.booShowMenu = !this.objBox.booShowMenu;
        if( this.objBox.booShowMenu )
        {
            this.objMenu.intMenuX = this.objBox.mouseX;
            this.objMenu.intMenuY = this.objBox.mouseY;
            this.objMenu.objBox = this.objBox;
            this.objMenu.strActualMenuItem = null;
            this.objBox.objMenuSelected = this.objMenu;
        }
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
        if( this.objMenu !== null )
        {
            this.objMenu.objBox = this.objBox;
        }
    },

    drawFixed: function drawFixed( boolFixed )
    {
        this.fixed = boolFixed;
    },

    goUp: function goUp()
    {
        this.drawFixed( true );
        this.y -= 10;
    },

    goDown: function goDown()
    {
        this.drawFixed( true );
        this.drawFixed( this.fixed );
        this.y += 10;
    },

    goLeft: function goLeft()
    {
        this.drawFixed( true );
        this.drawFixed( this.fixed );
        this.x -= 10;
    },

    goRight: function goRight()
    {
        this.drawFixed( true );
        this.drawFixed( this.fixed );
        this.x += 10;
    },

    isInside: function isInside( mouseX , mouseY )
    {
        var booResult = false;
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
            booResult = true;
        }

        if( this.intMass !== 0 && ( this.objBox.objElementSelected == null || this.objBox.objElementSelected == this ) )
        {
            for( var i = 0 ; i <  this.arrButtons.length ; ++i )
            {
                var objButton = this.arrButtons[ i ];
                if( !booResult )
                {
                    if( objButton.isInside( mouseX , mouseY ) )
                    {
                        booResult = true;
                    }
                }
                else
                {
                    objButton.booMouseOver = false;
                }
            }
        }

        return booResult;
    },


    addButton: function addButton( objButton )
    {
        if( this.arrButtons.length > 0 )
        {
            var objLast = this.arrButtons[ this.arrButtons.length - 1 ];
            objButton.objPreviousButton = objLast;
        }
        this.arrButtons.push( objButton );
    }

};

