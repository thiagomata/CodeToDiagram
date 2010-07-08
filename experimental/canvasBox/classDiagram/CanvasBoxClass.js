var CanvasBoxClass = Class.create();
Object.extend( CanvasBoxClass.prototype, CanvasBoxElement.prototype);
CanvasBoxClass.Static = new Object();
CanvasBoxClass.Static.createRelation =  function createRelation( objElement , booFrom, strLineClass )
{
	var objNewElement = new CanvasBoxClass();
	objNewElement.objBehavior = new window[ objElement.objBehavior.strClassName ]( objNewElement );
	objNewElement.x = objElement.objBox.mouseX + 100;
	objNewElement.y = objElement.objBox.mouseY + 100;
	objElement.objBox.addElement( objNewElement );

	var objFrom;
	var objTo;

	if( booFrom )
	{
		objFrom = objElement;
		objTo = objNewElement;
	}
	else
	{
		objTo= objElement;
	    objFrom = objNewElement;
	}

	var objLine = new window[ strLineClass ]( objFrom , objTo );
	switch( objElement.objBehavior.strClassName )
	{
		case "CanvasBoxMagneticBehavior":
		{
			objLine.objBehavior = new CanvasBoxMagneticConnectorBehavior( objLine );
			break;
		}
		case "CanvasBoxDefaultBehavior":
		default:
		{
			objLine.objBehavior = new CanvasBoxDefaultConnectorBehavior( objLine );
			break;
		}

	}
	objLine.x =  ( objFrom.x + objTo.x  ) / 2;
	objLine.y =  ( objFrom.y + objTo.y  ) / 2;
	objElement.objBox.addElement( objLine );
        return objNewElement;
};

Object.extend( CanvasBoxClass.prototype,
{
    width: 150,

    height: 150,

    x0: 0,

    x1: 0,

    dx: 0,

    y0: 0,

    y1: 0,

    dy: 0,

    z: 3,

    headerColor: "rgb( 202 , 229, 251 )",

    borderColor: "rgb(10,10,10)",

    borderWidth: "0.5",

    objBehavior: null,

    /**
     * Canvas 2D Context from the Canvas Box Container
     * @type CanvasRenderingContext2D
     */
    objContext: null,

    intMass: 2,

    intMagnetism: 20,

    strClassElementName: "noop",

    arrAttributes: Array( "#strName: string","#intAge: integer"),

    arrMethods: Array( "getName(): string","setName( string strName )"),

    fillColor: "rgb( 232 , 232, 255 )",

    fixedColor: "rgb( 200, 100 ,100 )",

    overColor: "rgb( 100 , 200 , 100 )",

    dragColor: "rgb( 200 , 200 , 250 )",

    intWallRepelsForce: 0.2,

    strClassName: "CanvasBoxClass",

    objMenu: null,

    booMenu: false,

    booMouseOver: false,

    arrButtons: Array(),
    
    defineMenu: function defineMenu()
    {
        this.arrButtons = Array();
        this.objMenu = new CanvasBoxMenu();
        this.objMenu.objParent = this;
        this.objMenu.arrMenuItens = (
        {
            0:
            {
                name: "create class >",
                event: function( objElement , me , objMenu )
                {
                    objMenu.createChildMenu( me ,
                    {
                        0:
                        {
                            name: "create parent class",
                            event: function( objElement )
                            {
                                CanvasBoxClass.Static.createRelation( objElement, false, "CanvasBoxGeneralization" );
                            }
                        },
                        1:
                        {
                            name: "create child class",
                            event: function( objElement )
                            {
                                CanvasBoxClass.Static.createRelation( objElement, true, "CanvasBoxGeneralization" );
                            }
                        },
                        2:
                        {
                            name: "create association class",
                            event: function( objElement )
                            {
                                CanvasBoxClass.Static.createRelation( objElement, true, "CanvasBoxAssociation" );
                            }
                        },
                        3:
                        {
                            name: "create aggregation class",
                            event: function( objElement )
                            {
                                CanvasBoxClass.Static.createRelation( objElement, true, "CanvasBoxAggregation" );
                            }
                        },
                        4:
                        {
                            name: "create composition class",
                            event: function( objElement )
                            {
                                CanvasBoxClass.Static.createRelation( objElement, true, "CanvasBoxComposition" );
                            }
                        },
                        5:
                        {
                            name: "create dependecy class",
                            event: function( objElement )
                            {
                                CanvasBoxClass.Static.createRelation( objElement, true, "CanvasBoxDependency" );
                            }
                        }
                    });
                    return true;
                }
            },
            1:
            {
                name: "attributes >",
                event: function( objElement , me , objMenu )
                {
                    objMenu.createChildMenu( me ,
                    {
                        0:
                        {
                            name: "add attribute",
                            event: function( objElement )
                            {
                                var strNewAttribute = prompt( "Inform the new attribute." );
                                objElement.arrAttributes.push( strNewAttribute );
                            }
                        },
                        1:
                        {
                            name: "remove attribute >",
                            event: function( objElement , me , objMenu )
                            {
                                var arrAttributesRemoveMenu = new Object();
                                for( var intAttribute = 0 ; intAttribute < objElement.arrAttributes.length ; ++intAttribute )
                                {
                                    arrAttributesRemoveMenu[ intAttribute ] =
                                    {
                                            name: objElement.arrAttributes[ intAttribute ],
                                            intPosition: intAttribute,
                                            event: function( objElement , me )
                                            {
                                                objElement.arrAttributes.splice( me.intPosition  , 1 );
                                            }
                                    };
                                }
                                objMenu.createChildMenu( me , arrAttributesRemoveMenu );
                                return ( objElement.arrAttributes.length > 0 );
                            }
                        }
                    });
                    return true;
                }
            },
            2:
            {
                name: "methods >",
                event: function( objElement , me , objMenu )
                {
                    objMenu.createChildMenu( me ,
                    {
                        0:
                        {
                            name: "add method",
                            event: function( objElement )
                            {
                                var strNewAttribute = prompt( "Inform the new attribute." );
                                objElement.arrAttributes.push( strNewAttribute );
                            }
                        },
                        1:
                        {
                            name: "remove method >",
                            event: function( objElement , me , objMenu )
                            {
                                var arrMethodsRemoveMenu = new Object();
                                for( var intMethod = 0 ; intMethod < objElement.arrMethods.length ; ++intMethod )
                                {
                                    arrMethodsRemoveMenu[ intMethod ] =
                                    {
                                            name: objElement.arrMethods[ intMethod ],
                                            intPosition: intMethod,
                                            event: function( objElement , me )
                                            {
                                                objElement.arrMethods.splice( me.intPosition  , 1 );
                                            }
                                    };
                                }
                                objMenu.createChildMenu( me , arrMethodsRemoveMenu );
                                return ( objElement.arrAttributes.length > 0 );
                            }
                        }
                    });
                    return true;
                }
            }
        });        
    },

    addButton: function addButton( objButton )
    {
        if( this.arrButtons.length > 0 )
        {
            var objLast = this.arrButtons[ this.arrButtons.length - 1 ];
            objButton.objPreviousButton = objLast;
        }
        this.arrButtons.push( objButton );
    },

    initialize: function initialize()
    {
        this.objBehavior = new CanvasBoxDefaultBehavior( this );
        this.defineMenu();
        this.addButton( new CanvasBoxAggregationButton( this ) );
        this.addButton( new CanvasBoxCompositionButton( this ) );
        this.addButton( new CanvasBoxAssociationButton( this ) );
        this.addButton( new CanvasBoxChildButton( this ) );
    },

    toSerialize: function toSerialize()
    {
        var objResult = new Object();
        objResult.x = Math.round( this.x );
        objResult.y = Math.round( this.y );
        objResult.width = this.width;
        objResult.height = this.height;
        objResult.headerColor = this.headerColor;
        objResult.borderColor = this.borderColor;
        objResult.borderWidth = this.borderWidth;
        objResult.intMass = this.intMass;
        objResult.intMagnetism = this.intMagnetism;
        objResult.strClassName = this.strClassName;
        objResult.arrAttributes = this.arrAttributes;
        objResult.arrMethods = this.arrMethods;
        objResult.fillColor = this.fillColor;
        objResult.fixedColor = this.fixedColor;
        objResult.overColor = this.overColor;
        objResult.dragColor = this.dragColor;
        objResult.intWallRepelsForce = this.intWallRepelsForce;
        objResult.strClassName = this.strClassName;
        return objResult;
    },

    refresh: function refresh()
    {
        this.x0 = this.x - ( this.width / 2 );
        this.x1 = this.x + ( this.width / 2 );
        this.y0 = this.y - ( this.height / 2 );
        this.y1 = this.y + ( this.height / 2 );

    },

    draw: function draw()
    {
        var intHeaderHeigth = 18;
        var i;

        this.refresh();

        if( this.booMouseOver || this.objBox.objElementClicked == this )
        {
            /**
             * Draw External Border
             */
            this.objContext.strokeStyle = 'rgb( 200 , 200 , 250 )';
            this.objContext.lineWidth = 1;
            this.objContext.strokeRect( Math.round( this.x0 ) - 10 , Math.round( this.y0 ) - 10,
                                  Math.round( this.width ) + 20 , Math.round( this.height ) + 20 );
        }

        /**
         * Class Big Rect
         */
        this.objContext.fillStyle = this.fillColor;
        this.objContext.fillRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , Math.round( this.height ) );

        /**
         * Class Header
         */
        this.objContext.fillStyle = this.headerColor;
        this.objContext.fillRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , intHeaderHeigth );
        this.objContext.strokeStyle = this.borderColor;
        this.objContext.lineWidth = 1;
        this.objContext.strokeRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , Math.round( intHeaderHeigth ) );

        this.objContext.fillStyle = this.fillColor;
        this.objContext.strokeStyle = this.borderColor;
        this.objContext.lineWidth = this.borderWidth;
        this.objContext.strokeRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , Math.round( this.height ) );

        this.objContext.strokeText( this.strClassElementName  , this.x0 + 10 , this.y0 + 10 );

        var intAttributesStart = intHeaderHeigth + 20;
        var intAttributesEnd = intAttributesStart + this.arrAttributes.length * 10;

        this.objContext.strokeRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , Math.round( intAttributesEnd ) );


        for( i = 0 ; i < this.arrAttributes.length; ++i )
        {
            this.objContext.lineWidth = 0.9;
            this.objContext.strokeText( this.arrAttributes[ i ], this.x0 + 10 , this.y0 + intAttributesStart + ( i ) * 10 );
        }

        var intMethodsStart = intAttributesEnd;

        this.objContext.strokeRect( Math.round( this.x0 ) , this.y0 + intMethodsStart ,
                                  Math.round( this.width ) , Math.round( this.height ) - intMethodsStart );

        for( i = 0 ; i < this.arrMethods.length; ++i )
        {
            this.objContext.strokeText( this.arrMethods[ i ], this.x0 + 10 ,  this.y0 + intMethodsStart + ( i ) * 10 + 20 );
        }

        for( i = 0 ; i <  this.arrButtons.length ; ++i )
        {
            var objButton = this.arrButtons[ i ];
            objButton.draw();
        }

    },

    drawMouseOver: function drawMouseOver( event )
    {
        if(!this.defaultHeaderColor)
        {
            this.defaultHeaderColor = this.headerColor;
        }
        this.headerColor = this.overColor;
        this.booMouseOver = true;
    },

    drawMouseOut: function drawMouseOut( event )
    {
        if( this.defaultHeaderColor )
        {
            this.headerColor = this.fixed ? this.fixedColor : this.defaultHeaderColor;
        }
        this.booMouseOver = false;
    },

    drawDrag: function drawDrag( event )
    {
        if(!this.defaultHeaderColor)
        {
            this.defaultHeaderColor = this.headerColor;
        }
        this.headerColor = this.dragColor;
    },

    drawDrop: function drawDrop( event )
    {
        if( this.defaultHeaderColor )
        {
            this.headerColor = this.fixed ? this.fixedColor : this.defaultHeaderColor;
        }
    },

    drawFixed: function drawFixed( boolFixed )
    {
        this.fixed = boolFixed;

        if( boolFixed )
        {
            this.headerColor = this.fixedColor;
        }
        else
        {
            this.headerColor = this.booMouseOver ? this.overColor : this.defaultHeaderColor;
        }
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
        return booResult;
    },

    onContextMenu: function onContextMenu( event )
    {
        this.objBox.booShowMenu = !this.objBox.booShowMenu;
        if( this.objBox.booShowMenu )
        {
            this.objMenu.intMenuX = this.objBox.mouseX;
            this.objMenu.intMenuY = this.objBox.mouseY;
            this.objMenu.objContext = this.objContext;
            this.objMenu.strActualMenuItem = null;
            this.objBox.objMenuSelected = this.objMenu;
        }
        return false;
    },

    onClick: function onClick( event )
    {
        for( var i = 0 ; i <  this.arrButtons.length ; ++i )
        {
            var objButton = this.arrButtons[ i ];
            if( objButton.booMouseOver )
            {
                return objButton.onClick( event );
            }
        }

       return this.objBehavior.onClick( event );
    },

    goUp: function goUp()
    {
        this.fixed = true;
        this.drawFixed( this.fixed );
        this.y -= 10;
    },

    goDown: function goDown()
    {
        this.fixed = true;
        this.drawFixed( this.fixed );
        this.y += 10;
    },

    goLeft: function goLeft()
    {
        this.fixed = true;
        this.drawFixed( this.fixed );
        this.x -= 10;
    },

    goRight: function goRight()
    {
        this.fixed = true;
        this.drawFixed( this.fixed );
        this.x += 10;
    },

    rename: function rename()
    {
        var strClassNewName = prompt( "Inform the new name of the class." );
        if ( strClassNewName !== null )
        {
            this.strClassElementName = strClassNewName;
        }
    },


    /**
     * On Drag Event
     * @param Event event
     * @return boolean
     */
    onDrag: function onDrag( event )
    {
        for( var i = 0 ; i <  this.arrButtons.length ; ++i )
        {
            var objButton = this.arrButtons[ i ];
            if( objButton.booMouseOver )
            {
                return objButton.onDrag( event );
            }
        }

        return this.objBehavior.onDrag( event );
    }
});
