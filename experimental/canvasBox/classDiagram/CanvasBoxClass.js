var CanvasBoxClass = Class.create();
Object.extend( CanvasBoxClass.prototype, window.autoload.loadCanvasBoxElement().prototype);
CanvasBoxClass.Static = new Object();
CanvasBoxClass.Static.createRelation =  function createRelation( objElement , booFrom, strLineClass )
{
	var objNewElement = new autoload.newCanvasBoxClass();
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

    var strAutoLoadClassName = "new" + strLineClass;
	var objLine = new window.autoload[ strAutoLoadClassName ]( objFrom , objTo );
	switch( objElement.objBehavior.strClassName )
	{
		case "CanvasBoxMagneticBehavior":
		{
			objLine.objBehavior = new autoload.newCanvasBoxMagneticConnectorBehavior( objLine );
			break;
		}
		case "CanvasBoxDefaultBehavior":
		default:
		{
			objLine.objBehavior = new autoload.newCanvasBoxDefaultConnectorBehavior( objLine );
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

    z: 3,
    
    headerColor: "rgb( 202 , 229, 251 )",

    borderColor: "rgb(10,10,10)",

    borderWidth: "0.5",

    /**
     * Canvas 2D Context from the Canvas Box Container
     * @type CanvasRenderingContext2D
     */
    objContext: null,

    intMagnetism: 15,

    strClassElementName: "noop",

    arrAttributes: null,

    arrMethods: null,

    fillColor: "rgb( 242 , 242, 255 )",

    fixedColor: "rgb( 200, 100 ,100 )",

    overColor: "rgb( 100 , 200 , 100 )",

    dragColor: "rgb( 200 , 200 , 250 )",

    strClassName: "CanvasBoxClass",

    defineMenu: function defineMenu()
    {
        this.arrButtons = Array();
        this.objMenu = new autoload.newCanvasBoxMenu();
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
    
    initialize: function initialize()
    {
        this.arrAttributes = Array( "#strName: string","#intAge: integer");
        this.arrMethods = Array( "getName(): string","setName( string strName )");
        this.arrButtons = Array();
        this.objBehavior = new window.autoload.newCanvasBoxDefaultBehavior( this );
        this.defineMenu();
        this.addButton( new autoload.newCanvasBoxAggregationButton( this ) );
        this.addButton( new autoload.newCanvasBoxCompositionButton( this ) );
        this.addButton( new autoload.newCanvasBoxAssociationButton( this ) );
        this.addButton( new autoload.newCanvasBoxChildButton( this ) );
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
            this.objBox.setStrokeStyle( 'rgb( 200 , 200 , 250 )' );
            this.objBox.setLineWidth( 1 );
            this.objBox.strokeRect( Math.round( this.x0 ) - 10 , Math.round( this.y0 ) - 10,
                                  Math.round( this.width ) + 20 , Math.round( this.height ) + 20 );
        }

        /**
         * Class Big Rect
         */
        this.objBox.setFillStyle( this.fillColor );
        this.objBox.fillRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                              Math.round( this.width ) , Math.round( this.height ) );

        /**
         * Class Header
         */
        this.objBox.setFillStyle( this.headerColor );
        this.objBox.fillRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , intHeaderHeigth );
        this.objBox.setStrokeStyle( this.borderColor );
        this.objBox.setLineWidth( 1 );
        this.objBox.strokeRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                  Math.round( this.width ) , Math.round( intHeaderHeigth ) );

        this.objBox.setFillStyle( this.fillColor );
        this.objBox.setStrokeStyle( this.borderColor );
        this.objBox.setLineWidth( this.borderWidth );
        this.objBox.strokeRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                Math.round( this.width ) , Math.round( this.height ) );


        this.objBox.setFont( "12px Times New Roman" );
        this.objBox.setFillStyle("rgb( 40 , 40, 40 )");
        this.objBox.fillText( this.strClassElementName, this.x0 + 10 , this.y0 + 10 );

        var intAttributesStart = intHeaderHeigth + 20;
        var intAttributesEnd = intAttributesStart + this.arrAttributes.length * 10;

        this.objBox.strokeRect( Math.round( this.x0 ) , Math.round( this.y0 ),
                                Math.round( this.width ) , Math.round( intAttributesEnd ) );


        for( i = 0 ; i < this.arrAttributes.length; ++i )
        {
            this.objBox.setFont( "10px Times New Roman" );
            this.objBox.setFillStyle("rgb( 40 , 40, 40 )");
            this.objBox.fillText( this.arrAttributes[ i ], this.x0 + 10 , this.y0 + intAttributesStart + ( i ) * 10 );
        }

        var intMethodsStart = intAttributesEnd;

        this.objBox.strokeRect( Math.round( this.x0 ) , this.y0 + intMethodsStart ,
                                Math.round( this.width ) , Math.round( this.height ) - intMethodsStart );

        for( i = 0 ; i < this.arrMethods.length; ++i )
        {
            this.objBox.setFont( "10px Times New Roman" );
            this.objBox.setFillStyle("rgb( 40 , 40, 40 )");
            this.objBox.fillText( this.arrMethods[ i ], this.x0 + 10 ,  this.y0 + intMethodsStart + ( i ) * 10 + 20 );
        }


        if( this.intMass !== 0 && ( this.objBox.objElementSelected == null || this.objBox.objElementSelected == this ) )
        {
            for( i = 0 ; i <  this.arrButtons.length ; ++i )
            {
                var objButton = this.arrButtons[ i ];
                objButton.draw();
            }
        }
    },

    drawMouseOver: function drawMouseOver( event )
    {
        if(!this.defaultHeaderColor)
        {
            this.defaultHeaderColor = this.headerColor;
        }
        this.headerColor = this.overColor;
    },

    drawMouseOut: function drawMouseOut( event )
    {
        if( this.defaultHeaderColor )
        {
            this.headerColor = this.fixed ? this.fixedColor : this.defaultHeaderColor;
        }
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
    
    rename: function rename()
    {
        var strClassNewName = prompt( "Inform the new name of the class." );
        if ( strClassNewName !== null )
        {
            this.strClassElementName = strClassNewName;
        }
    }
});
