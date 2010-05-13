/**
 * Canvas Box it is a canvas element what can be append and remove elements.
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
	return CanvasBox.Static.filterResults (
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
	return CanvasBox.Static.filterResults (
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
	return CanvasBox.Static.filterResults (
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
	return CanvasBox.Static.filterResults (
		window.pageYOffset ? window.pageYOffset : 0,
		document.documentElement ? document.documentElement.scrollTop : 0,
		document.body ? document.body.scrollTop : 0
	);
};

/**
 * browsers workaround for missing standarts
 *
 * @link http://www.softcomplex.com/docs/get_window_size_and_scrollbar_position.html
 */
CanvasBox.Static.filterResults = function filterResults( intWin, intDocel, intBody )
{
	var intresult = intWin ? intWin : 0;
	if (intDocel && (!intresult || (intresult > intDocel)))
		intresult = intDocel;
	return intBody && (!intresult || (intresult > intBody)) ? intBody : intresult;
};

CanvasBox.prototype = 
{
    x: 0,

    y: 0,

    /**
     * Id of the Box, to deal with many canvas box into the same page
     *
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
    intIntervalDraw: 150,

    /**
     * Interval of Objects Timers
     * @type integer
     */
    intIntervalTimer: 150,

    /**
     * Control if the refreshing is active or not
     * @type boolean
     */
    booActive: false,

    /**
     * Mouse X position
     */
    mouseX: 0,

    /**
     * Mouse Y position
     */
    mouseY: 0,

    booOnDraw: false,


    booOnTimer: false,

    /**
     * Javascript constant of right button click
     */
    intRightButtonClick: 2,
    
    strClassName: "CanvasBox",

    intFps: 0,

    intLastFps: 0,
    
    booCountFps: true,

    backgroundColor: "white",
    
    booShowMenu: false,

    objMenu: null,

    objMenuSelected: null,
    
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
    },

    /**
     * Initialize the Canvas Box
     *
     * - Validate the canvas html element
     * - set the width and the height into the canvas html element
     *
     * @param idCanvasHtmlElement string
     * @throws CanvasBoxException
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
        this.play();
    },

    /**
     * Add a CanvasBoxElement intot he CanvasBox
     *
     * @param objElement CanvasBoxElement
     */
    addElement: function addElement( objElement )
    {
        this.arrElements.push( objElement );
        objElement.objBox = this;
        objElement.objContext = this.getContext();
    },

    /**
     * Get the Context of the Canvas Html Element
     */
    getContext: function getContext()
    {
        var objContext = this.objCanvasHtml.getContext( '2d' );
        return objContext;
    },

    /**
     * Clear the image into the Canvas Html Element Context
     */
    clear: function clear()
    {
        var objContext = this.getContext();
        objContext.clearRect( 0, 0, this.width, this.height );
    },

    /**
     * Draw all the elements into the CanvasBox
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

    onCountFps: function onCountFps()
    {
        this.intLastFps = this.intFps;
//        document.title = "FPS: " + this.intLastFps;
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

    onMouseUp: function onMouseUp( event )
    {
        if( this.objElementSelected != null )
        {
            this.objElementSelected.onDrop( event);
        }
        this.objElementSelected = null;
    },

    onMouseDown: function onMouseDown( event )
    {
        if( event.button == this.intRightButtonClick )
        {
            if( is_object( this.objElementOver ) )
            {
//                this.objElementOver.onContextMenu( event );
            }
            else
            {
//                this.onBoxRightClick( event );
            }
        }
        this.objElementSelected = this.objElementOver;
        return false;
    },

    onClick: function onClick( event )
    {
        if( this.booShowMenu )
        {
            this.objMenuSelected.onClick( event );
            this.booShowMenu = false;
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

    onBoxRightClick: function onBoxRightClick( event )
    {
        return false;
    },

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
    
    onBoxClick: function onBoxClick( event )
    {
        if( this.booShowMenu )
        {
            this.objMenuSelected.onClick( event );
            this.booShowMenu = false;
        }
    },

    onBoxDblClick: function onBoxDblClick( event )
    {

    },
    
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
