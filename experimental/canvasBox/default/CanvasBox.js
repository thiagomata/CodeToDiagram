/**
 * Canvas Box it is a canvas element where the user can be append and remove elements.
 *
 * It elements can be selected and clicked and interact each other.
 *
 * @package myBox
 */

/**
 * Exception of Canvas Box Component
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
window.CanvasBoxException = window.Error;

/**
 * Sand Box to the Canvas Elements
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
var CanvasBox = Class.create();

/**
 * Static Vars
 */
CanvasBox.Static = new Object();

/**
 * Static Array with the
 * Instances of the Canvas Box
 */
CanvasBox.Static.arrInstances = Array();

/**
 * getCanvasBoxById
 * 
 * Get instance of canvas box by it's id
 * 
 * @param integer id
 */
CanvasBox.Static.getCanvasBoxById = function getCanvasBoxById( id )
{
    return CanvasBox.Static.arrInstances[ id ];
};

/**
 * Get the client width fixing browsers missing standarts
 *
 * @link http://www.softcomplex.com/docs/get_window_size_and_scrollbar_position.html
 */
CanvasBox.Static.clientWidth = function clientWidth()
{
    return CanvasBox.Static.filterResults 
    (
        window.innerWidth ? window.innerWidth : 0,
        document.documentElement ? document.documentElement.clientWidth : 0,
        document.body ? document.body.clientWidth : 0
    );
};

/**
 * Get the client height fixing browsers missing standarts
 *
 * @link http://www.softcomplex.com/docs/get_window_size_and_scrollbar_position.html
 */
CanvasBox.Static.clientHeight = function clientHeight()
{
    return CanvasBox.Static.filterResults 
    (
        window.innerHeight ? window.innerHeight : 0,
        document.documentElement ? document.documentElement.clientHeight : 0,
        document.body ? document.body.clientHeight : 0
    );
};

/**
 * Get the scroll left fixing browsers missing standarts
 *
 * @link http://www.softcomplex.com/docs/get_window_size_and_scrollbar_position.html
 */
CanvasBox.Static.scrollLeft = function scrollLeft()
{
    return CanvasBox.Static.filterResults
    (
        window.pageXOffset ? window.pageXOffset : 0,
        document.documentElement ? document.documentElement.scrollLeft : 0,
        document.body ? document.body.scrollLeft : 0
    );
};

/**
 * Get the scroll Top fixing browsers missing standarts
 *
 * @link http://www.softcomplex.com/docs/get_window_size_and_scrollbar_position.html
 */
CanvasBox.Static.scrollTop= function scrollTop()
{
    return CanvasBox.Static.filterResults 
    (
        window.pageYOffset ? window.pageYOffset : 0,
        document.documentElement ? document.documentElement.scrollTop : 0,
        document.body ? document.body.scrollTop : 0
    );
};

/**
 * browsers workaround for missing standarts
 * @link http://www.softcomplex.com/docs/get_window_size_and_scrollbar_position.html
 */
CanvasBox.Static.filterResults = function filterResults(intWin, intDocel, intBody){
    var intresult = intWin ? intWin : 0;
    if (intDocel && (!intresult || (intresult > intDocel))) 
    {
        intresult = intDocel;
    }
    return intBody && (!intresult || (intresult > intBody)) ? intBody : intresult;
};

CanvasBox.prototype =
{
    /**
     * Position x of the Canvas Box Element relative to the page
     * @type integer
     */
    x: 0,
    
    /**
     * Position y of the Canvas Box Element relative to the page
     * @type integer
     */
    y: 0,

    /**
     * Id of the Box, to deal with many canvas box into the same page
     * @type integer
     */
    id: null,

    /**
     * Width of the Sand Box
     * @type integer
     */
    width: 400,

    /**
     *Height of the Sand Box
     *@type integer
     */
    height: 400,

    /**
     * Html Canvas Box Element
     * @type Canvas
     */
    objCanvasHtml: null,

    /**
     * Collection of Elements inside the Box
     * @type CanvasBoxElement[]
     */
    arrElements: Array(),

    /**
     * CanvasBoxElement Over
     * @type CanvasBoxElement
     */
    objElementOver: null,

    /**
     * CanvasBoxElement Clicked
     * @type CanvasBoxElement
     */
    objElementClicked: null,

    /**
     * Interval of Image Refreshing
     * @type integer
     */
    intIntervalDraw: 2,

    /**
     * Interval of Objects Timers
     * @type integer
     */
    intIntervalTimer: 2,

    /**
     * Control if the refreshing is active or not
     * @type boolean
     */
    booActive: false,
    
    /**
     * Mouse X position relative to canvas box
     * @integer
     */
    mouseX: 0,
    
    /**
     * Mouse Y position relative to canvas box
     * @integer
     */
    mouseY: 0,
    
    /**
     * Flag of control if the canvas box is drawing right now
     * @type boolean
     */
    booOnDraw: false,

    /**
     * Flag of control if the canvas box is moving right now
     */
    booOnTimer: false,

    /**
     * Javascript constant of right button click
     */
    intRightButtonClick: 2,

    /**
     * Class Name of the Canvas Box
     * @type string
     */
    strClassName: "CanvasBox",

    /**
     * Frames per Second Counter
     * @type integer
     */
    intFps: 0,

    /**
     * Frames per Second Last Result
     * @type integer
     */
    intLastFps: 0,

    /**
     * Flag that controls if the FPS counter is active
     */
    booCountFps: true,

    /**
     * Background Color of the Canvas Box
     */
    backgroundColor: "white",

    /**
     * Flag that controls if the menu is showing
     */
    booShowMenu: false,

    /**
     * Native Menu element of the Canvas Box
     */
    objMenu: null,

    /**
     * Actual Menu Element of the Canvas
     */
    objMenuSelected: null,

    /**
     * Serialized result that describe the CanvasBox Object
     * @return Object
     */
    toSerialize: function toSerialize()
    {
        var objResult = new Object();
        objResult.x = this.x;
        objResult.y = this.y;
        objResult.width = this.width;
        objResult.height = this.height;
        objResult.objCanvasHtml = this.objCanvasHtml;
        objResult.intIntervalDraw = this.intIntervalDraw;
        objResult.booActive = this.booActive;
        objResult.booOnDraw = this.booOnDraw;
        objResult.arrElements = this.arrElements;
        return objResult;
    },

    /**
     * Method that defined the Native Menu of the Canvas Box.
     * 
     * This menu will be see when the user right click into some
     * empty area of the canvas box 
     * 
     * @return CanvasBox
     */
    defineMenu: function defineMenu()
    {
        this.objMenu = new CanvasBoxMenu();
        this.objMenu.objParent = this;
        this.objMenu.objContext = this.getContext();
        this.objMenu.arrMenuItens = ({
            0:{
                name: "create class",
                event: function( objParent ){

                    var objClass = new CanvasBoxClass();
                    objClass.objBehavior = new CanvasBoxMagneticBehavior( objClass );
                    objClass.x = objParent.mouseX;
                    objClass.y = objParent.mouseY;
                    objParent.addElement( objClass );
                }
            },
            1:{
                name: "create square",
                event: function( objParent ){

                    var objSquare = new CanvasBoxSquare();
                    objSquare.objBehavior = new CanvasBoxMagneticBehavior( objSquare );
                    objSquare.x = objParent.mouseX;
                    objSquare.y = objParent.mouseY;
                    objParent.addElement( objSquare );
                }
            }
        });
        this.objMenuSelected = null;
		return this;
    },

    /**
     * Calculates the absolute position of the canvas box object based
     * on the position of the parents objects
     * 
     * @return CanvasBox
     */
    getPosition: function getPosition()
    {
        var x = this.objCanvasHtml.offsetLeft;
        var y = this.objCanvasHtml.offsetTop;

        var objElement = this.objCanvasHtml;

        while( objElement.offsetParent )
        {
            if( objElement == document.getElementsByTagName( 'body' )[0] )
            {
                break;
            }
            else
            {
                x =  x + objElement.offsetParent.offsetLeft;
                y =  y + objElement.offsetParent.offsetTop;
                objElement = objElement.offsetParent;
            }
        }

        this.x = x;
        this.y = y;
		
		return this;
    },

    /**
     * Initialize the Canvas Box
     *
     * - Validate the canvas html element
     * - set the width and the height into the canvas html element
     *
     * @param idCanvasHtmlElement string
     * @throws CanvasBoxException
     * 
     * @return CanvasBox
     */
    initialize: function initialize( idCanvasHtmlElement , intWidth, intHeight )
    {
        this.width = intWidth;
        this.height = intHeight;
        this.id = CanvasBox.Static.arrInstances.length;
        CanvasBox.Static.arrInstances[ this.id ] = this;
        
        this.objCanvasHtml = document.getElementById( idCanvasHtmlElement );
        if( this.objCanvasHtml == null )
        {
            throw new CanvasBoxException( "Invalid canvas html element id [" + idCanvasHtmlElement + "]" );
        }
        this.getPosition();
        
        this.objCanvasHtml.setAttribute( "width" ,  this.width  + "px" );
        this.objCanvasHtml.setAttribute( "height" , this.height + "px" );
        this.objCanvasHtml.setAttribute( "onmousemove",   ( 'return CanvasBox.Static.getCanvasBoxById(' + this.id + ').onMouseMove( event )' ) );
        this.objCanvasHtml.setAttribute( "onclick",       ( 'return CanvasBox.Static.getCanvasBoxById(' + this.id + ').onClick( event )' ) );
        this.objCanvasHtml.setAttribute( "ondblclick",    ( 'return CanvasBox.Static.getCanvasBoxById(' + this.id + ').onDblClick( event )' ) );
        this.objCanvasHtml.setAttribute( "onmouseup",     ( 'return CanvasBox.Static.getCanvasBoxById(' + this.id + ').onMouseUp( event )' ) );
        this.objCanvasHtml.setAttribute( "onmousedown",   ( 'return CanvasBox.Static.getCanvasBoxById(' + this.id + ').onMouseDown( event )' ) );
        this.objCanvasHtml.setAttribute( "oncontextmenu", ( 'return CanvasBox.Static.getCanvasBoxById(' + this.id + ').onContextMenu( event )' ) );
        this.objCanvasHtml.setAttribute( "onKeyup",       ( 'return CanvasBox.Static.getCanvasBoxById(' + this.id + ').onKeyUp( event )' ) );
        this.objCanvasHtml.setAttribute( "contentEditable" , "true");
        this.objCanvasHtml.contentEditable = true;
        this.defineMenu();
        this.play();
		
		return this;
    },

    /**
     * Add a CanvasBoxElement intot he CanvasBox
     *
     * @param objElement CanvasBoxElement
     * @return void
     */
    addElement: function addElement( objElement )
    {
        this.arrElements.push( objElement );
        objElement.objBox = this;
        objElement.objContext = this.getContext();
    },

    /**
     * Get the Context of the Canvas Html Element
     * @return CanvasRenderingContext2D
     */
    getContext: function getContext()
    {
        var objContext = this.objCanvasHtml.getContext( '2d' );
        return objContext;
    },

    /**
     * Clear the image into the Canvas Html Element Context
     * @return void
     */
    clear: function clear()
    {
        var objContext = this.getContext();
        objContext.clearRect( 0, 0, this.width, this.height );
    },

    /**
     * Draw all the elements into the CanvasBox
     * @return void
     */
    draw: function draw()
    {
        this.booOnDraw = true;

        this.clear();

        var arrZIndexElements = Array();
        var arrZIndex = Array();
        var objElement;
        var i;

        /**
         * Create one array to each layer into the z dimension
         */
        for( i = 0 ; i < this.arrElements.length; ++i )
        {
            objElement = this.arrElements[ i ];
            if( Object.isUndefined( arrZIndexElements[ objElement.z ] ) )
            {
                arrZIndexElements[ objElement.z ] = Array();
                arrZIndex.push( objElement.z );
            }
            arrZIndexElements[ objElement.z ].push( objElement );
        }

        /**
         * Order layers by the z dimension
         */
        arrZIndex = sort( arrZIndex );

        /**
         * Draw Elements each z dimension layer of time
         */
        for( var intElement = 0; intElement < arrZIndex.length; ++intElement )
        {
            var z = arrZIndex[ intElement ];
            for( i = 0 ; i < arrZIndexElements[ z ].length; ++i )
            {
                objElement = arrZIndexElements[ z ][ i ];
                if( is_object( objElement ) )
                {
                    objElement.draw();
                }
            }
        }

        objElement = null;
        arrZIndexElements = null;

        if( this.booShowMenu )
        {
            this.objMenuSelected.mouseX = this.mouseX;
            this.objMenuSelected.mouseY = this.mouseY;
            this.objMenuSelected.draw();
        }

        this.booOnDraw = false;
    },

    /**
     * Draw all the elements into the CanvasBox
     * @return void
     */
    onTimerElements: function onTimerElements()
    {
        this.booOnTimer = true;

        for( var i = 0, l = this.arrElements.length; i < l; ++i )
        {
            var objElement = this.arrElements[ i ];
            objElement.onTimer();
        }

        this.booOnTimer = false;
    },

    /**
     * Active the auto refresh timer
     * @return void
     */
    play: function play()
    {
        this.booActive = true;
        setTimeout( 'CanvasBox.Static.arrInstances[ ' + this.id + '].onTimer()' , this.intIntervalTimer );
        setTimeout( 'CanvasBox.Static.arrInstances[ ' + this.id + '].onDraw()' , this.intIntervalDraw );
        setTimeout( 'CanvasBox.Static.arrInstances[ ' + this.id + '].onCountFps()' , 1000 );
    },

    /**
     * Stop the auto refresh timer
     * @return void
     */
    stop: function stop()
    {
        this.booActive = false;
    },

    /**
     * Refresh the Canvas Box
     *
     * - Draw the elements
     * - Call the next timer if should
     * @return boolean
     */
    onTimer: function onTimer()
    {
        if( this.booActive == false )
        {
            return false;
        }
        setTimeout( 'CanvasBox.Static.arrInstances[ ' + this.id + '].onTimer()' , this.intIntervalTimer );
        if( !this.booOnTimer )
        {
            this.onTimerElements();
        }
        return true;
    },

    /**
     * On show counter FPS
     * @return void
     */
    onCountFps: function onCountFps()
    {
        this.intLastFps = this.intFps;
        document.title = "FPS: " + this.intLastFps;
        this.intFps = 0;
        if( ! this.booCountFps )
        {
            return false;
        }
        setTimeout( 'CanvasBox.Static.arrInstances[ ' + this.id + ' ].onCountFps()' , 1000 );
    },

    /**
     * Refresh the Canvas Box
     *
     * - Draw the elements
     * - Call the next timer if should
     */
    onDraw: function onDraw()
    {
        if( this.booActive == false )
        {
            return false;
        }
        setTimeout( 'CanvasBox.Static.arrInstances[ ' + this.id + ' ].onDraw()' , this.intIntervalDraw );
        if( !this.booOnDraw )
        {
            this.draw();
            this.intFps++;
        }
        return true;
    },

    /**
     * Refresh Mouse Position based on Event
     *
     * @param event Event
     */
    refreshMousePosition: function refreshMousePosition( event )
    {
        this.mouseX = event.clientX - this.x + CanvasBox.Static.scrollLeft();
        this.mouseY = event.clientY - this.y + CanvasBox.Static.scrollTop();
    },

    /**
     * On Move Move over the Canvas Box
     * Search if the Mouse is Over some Canvas Element
     * 
     * @param event event
     */
    onMouseMove: function onMouseMove( event )
    {
        var objElementOver = null;
        this.refreshMousePosition( event );

        for( var i = 0, l = this.arrElements.length; i < l; ++i )
        {
            var objElement = this.arrElements[ i ];
            if( objElement.isInside( this.mouseX , this.mouseY ) )
            {
                objElementOver = objElement;
                i = l;
            }
        }
        if( this.objElementOver != objElementOver )
        {
            if( this.objElementOver != null )
            {
                this.objElementOver.onMouseOut( event );
            }
            if( objElementOver != null )
            {
                this.objCanvasHtml.style.cursor = "pointer";
                objElementOver.onMouseOver( event );
            }
            else
            {
                this.objCanvasHtml.style.cursor = "default";
            }
            this.objElementOver = objElementOver;
        }
        if( this.objElementSelected != null )
        {
            this.objElementSelected.onDrag( event );
        }
    },

    /**
     * On Mouse Up Canvas Box Event
     * 
     * @see onMouseDown
     * @see CanvasBoxElement::onDrop()
     * @param Event event
     */
    onMouseUp: function onMouseUp( event )
    {
        if( this.objElementSelected != null )
        {
            this.objElementSelected.onDrop( event);
        }
        this.objElementSelected = null;
    },

    /**
     * On Mouse Down Canvas Box Event
     * 
     * @param Event event
     */
    onMouseDown: function onMouseDown( event )
    {
        this.objElementSelected = this.objElementOver;
        return false;
    },

    /**
     * On Mouse Click Canvas Box Event
     * 
     * @param Event event
     */
    onClick: function onClick( event )
    {
        if( this.booShowMenu )
        {
            this.booShowMenu = this.objMenuSelected.onClick( event );
            return false;
        }

        if( this.objElementOver != null )
        {
            this.objElementClicked = this.objElementOver;
            this.objElementOver.onClick( event );
        }
        else
        {
            this.objElementClicked = null;
            this.onBoxClick( event );
        }
        this.objCanvasHtml.focus();
        return false;
    },

    /**
     * On Double Click Canvas Box Event
     * 
     * @param Event event
     */
    onDblClick: function onDblClick( event )
    {
        if( this.objElementOver != null )
        {
            this.objElementOver.onDblClick( event );
        }
        else
        {
            this.onBoxDblClick( event );
        }
    },

    /**
     * On Right Click Canvas Box Event
     * 
     * @param Event event
     */
    onBoxRightClick: function onBoxRightClick( event )
    {
        return false;
    },

    /**
     * On Context Menu Canvas Box Event
     * 
     * @param Event event
     */
    onContextMenu: function onContextMenu( event )
    {
        if( this.objElementOver != null )
        {
            this.objElementOver.onContextMenu( event );
        }
        else
        {
            this.onBoxContextMenu( event );
        }
        return false;
    },

    /**
     * On Context Menu Clicked into a empty space of the Canvas Box
     * @param Event event
     */
    onBoxContextMenu: function onBoxContextMenu( event )
    {
        this.booShowMenu = !this.booShowMenu;
        if( this.booShowMenu )
        {
            this.objMenuSelected = this.objMenu;
            this.objMenuSelected.intMenuX = this.mouseX;
            this.objMenuSelected.intMenuY = this.mouseY;
            this.objMenuSelected.strActualMenuItem = null;
        }

    },

    /**
     *  On Click into a empty space of the Canvas Box
     * 
     * @param Event event
     */
    onBoxClick: function onBoxClick( event )
    {
        if( this.booShowMenu )
        {
            this.booShowMenu = this.objMenuSelected.onClick( event );
        }
    },

    /**
     * On Double click into a empty space of the Canvas Box
     * 
     * @param Event event
     */
    onBoxDblClick: function onBoxDblClick( event )
    {

    },

    /**
     * On Key Up into the Canvas Box Element
     * 
     * @param Event event
     */
    onKeyUp: function onKeyUp( event )
    {
        switch( event.keyCode )
        {
            case 46: // delete
            {
                if( this.objElementClicked !== null )
                {
                    this.deleteElement( this.objElementClicked );
                }
                break;
            }
            case 38: // up
            {
                if( this.objElementClicked !== null )
                {
                    this.objElementClicked.goUp();
                }
                break;
            }
            case 40: // down
            {
                if( this.objElementClicked !== null )
                {
                    this.objElementClicked.goDown();
                }
                break;
            }
            case 39: // =>
            {
                if( this.objElementClicked !== null )
                {
                    this.objElementClicked.goRight();
                }
                break;
            }
            case 37: // <=
            {
                if( this.objElementClicked !== null )
                {
                    this.objElementClicked.goLeft();
                }
                break;
            }
            case 32: // SPACE
            {
                if( this.objElementClicked !== null )
                {
                    this.objElementClicked.fixed = !this.objElementClicked.fixed;
                    this.objElementClicked.drawFixed( this.objElementClicked.fixed );
                }
                break;
            }
            case 113: // F2
            {
                if( this.objElementClicked !== null )
                {
                    this.objElementClicked.rename();
                }
                break;
            }
            case 45: // INSERT
            {
                if( this.objElementClicked !== null )
                {
                    this.objElementClicked.copy();
                }
                break;
            }
        }
        return false;
    },

    /**
     * Delete some element from the Canvas Box
     * 
     * @param CanvasBoxElement objElement
     * @param boolean booCallOnDelete
     */
    deleteElement: function deleteElement( objElement , booCallOnDelete )
    {
        if( Object.isUndefined( booCallOnDelete ) )
        {
            booCallOnDelete = true;
        }

        if( booCallOnDelete )
        {
            this.objElementClicked.onDelete();
        }

        var intId = this.arrElements.indexOf( objElement );
        if( intId != -1 )
        {
            this.arrElements.splice( intId  , 1 );
        }
        if ( this.arrElements.length > 0 )
        {
            this.objElementClicked = this.arrElements[ 0 ];
        }
        else
        {
            this.objElementClicked = null;
        }
    }
}