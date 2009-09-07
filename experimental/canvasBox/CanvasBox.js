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
}

CanvasBox.prototype = 
{
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
    intIntervalDraw: 50,

    /**
     * Interval of Objects Timers
     * @type integer
     */
    intIntervalTimer: 50,

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
        this.objCanvasHtml.setAttribute( "width" , this.width + "px" );
        this.objCanvasHtml.setAttribute( "height" , this.height + "px" );
        this.objCanvasHtml.setAttribute( "onmousemove",  'CanvasBox.Static.getCanvasBoxById(' + this.id + ').onMouseMove( event )' );
        this.objCanvasHtml.setAttribute( "onclick",  'CanvasBox.Static.getCanvasBoxById(' + this.id + ').onClick( event )' );
        this.objCanvasHtml.setAttribute( "ondblclick",  'CanvasBox.Static.getCanvasBoxById(' + this.id + ').onDblClick( event )' );
        this.objCanvasHtml.setAttribute( "onmouseup",  'CanvasBox.Static.getCanvasBoxById(' + this.id + ').onMouseUp( event )' );
        this.objCanvasHtml.setAttribute( "onmousedown",  'CanvasBox.Static.getCanvasBoxById(' + this.id + ').onMouseDown( event )' );
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
        //document.title = ( this.objCanvasHtml.id );
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

        for( var i = 0, l = this.arrElements.length; i < l; ++i )
        {
            var objElement = this.arrElements[ i ];
            objElement.draw();
        }
        this.booOnDraw = false;
    },

    /**
     * Draw all the elements into the CanvasBox
     */
    onTimerElements: function onTimerElements()
    {
        for( var i = 0, l = this.arrElements.length; i < l; ++i )
        {
            var objElement = this.arrElements[ i ];
            objElement.onTimer();
        }
    },

    /**
     * Active the auto refresh timer
     */
    play: function play()
    {
        this.booActive = true;
        setTimeout( 'CanvasBox.Static.getCanvasBoxById(' + this.id + ').onTimer()' , this.intIntervalTimer );
        setTimeout( 'CanvasBox.Static.getCanvasBoxById(' + this.id + ').onDraw()' , this.intIntervalDraw );
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
        this.onTimerElements();
        setTimeout( 'CanvasBox.Static.getCanvasBoxById(' + this.id + ').onTimer()' , this.intIntervalTimer );
        return true;
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
        setTimeout( 'CanvasBox.Static.getCanvasBoxById(' + this.id + ').onDraw()' , this.intIntervalDraw );
        if( !this.booOnDraw )
        {
            this.draw();
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
      this.mouseX = event.clientX ;//- this.objCanvasHtml.offset().left;
      this.mouseY = event.clientY ;//- this.objCanvasHtml.offset().top;
    },

    onClick: function onClick( event )
    {
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
        this.objElementSelected = this.objElementOver;
    },

    onClick: function onClick( event )
    {
        if( this.objElementOver != null )
        {
            this.objElementOver.onClick( event );
        }
    },
    
    onDblClick: function onDblClick( event )
    {
        if( this.objElementOver != null )
        {
            this.objElementOver.onDblClick( event );
        }        
    }
};