var CanvasBoxMenu = Class.create();
CanvasBoxMenu.prototype =
{
    menuBorderColor: "rgb( 100 , 100 , 200 )",

    menuBorderWidth: 1,

    menuFillColor: "rgba( 230, 230, 240 , 0.7 )",

    menuItemBorderColor: "rgb( 100 , 100 , 200 )",

    menuItemBorderWidth: 1,

    menuItemFillColor: "rgba( 230, 230, 240 , 0.7 )",

    menuItemTextColor: "blue",

    menuSelectedItemFillColor: "rgba( 230, 230, 140 , 0.7 )",

    intMenuX: 0,

    intMenuY: 0,

    intMenuItemXBorder: 3,

    intMenuItemHeight: 20,

    intMenuWidth: 110,

    arrMenuItens: Array(),

    strActualMenuItem: null,

    mouseX: 0,

    mouseY: 0,

    objBox: null,

    objParent: null,

    objOpenChildMenu: null,
    
    initialize: function initialize()
    {
    },

    draw: function draw()
    {
        this.strActualMenuItem = null;

        var arrMenuKeys = array_keys( this.arrMenuItens );
        this.intMenuHeight = this.intMenuItemHeight * ( arrMenuKeys.length - 1 );

        this.objBox.setStrokeStyle( this.menuBorderColor );
        this.objBox.setLineWidth( this.menuBorderWidth );
        this.objBox.strokeRect(
            this.intMenuX , this.intMenuY, this.intMenuWidth , this.intMenuHeight
        );

        this.objBox.setFillStyle( this.menuFillColor );
        this.objBox.fillRect(
            this.intMenuX , this.intMenuY, this.intMenuWidth , this.intMenuHeight
        );

        for( var i = 0 ; i < arrMenuKeys.length; ++i )
        {
            var intMenuItemX = this.intMenuX;
            var intMenuItemY = this.intMenuY + ( i ) * this.intMenuItemHeight;

            this.objBox.setStrokeStyle( this.menuItemBorderColor );
            this.objBox.setLineWidth( this.menuItemBorderWidth );
            this.objBox.strokeRect(
                intMenuItemX , intMenuItemY , this.intMenuWidth , this.intMenuItemHeight
            );

            if(
                ( this.mouseX > intMenuItemX )
                &&
                ( this.mouseX < ( intMenuItemX + this.intMenuWidth ) )
                &&
                ( this.mouseY > intMenuItemY )
                &&
                ( this.mouseY < ( intMenuItemY + this.intMenuItemHeight ) )
            )
            {
                this.objBox.setFillStyle( this.menuSelectedItemFillColor );
                this.strActualMenuItem = arrMenuKeys[ i ];
            }
            else
            {
                this.objBox.setFillStyle( this.menuItemFillColor );
            }

            this.objBox.fillRect(
                intMenuItemX , intMenuItemY, this.intMenuWidth , this.intMenuItemHeight
            );

            this.objBox.setFillStyle(
            this.arrMenuItens[ arrMenuKeys[ i ] ].backgroundColor ?
            this.arrMenuItens[ arrMenuKeys[ i ] ].backgroundColor :
            this.menuItemTextColor );
            this.objBox.setLineWidth( 0.9 );
            this.objBox.setFont( "10px Times New Roman" );
            this.objBox.fillText
            (
                this.arrMenuItens[ arrMenuKeys[ i ] ].name ,
                this.intMenuItemXBorder +  intMenuItemX ,
                Math.round( intMenuItemY +   this.intMenuItemHeight / 2 )
            );

        }

        if( this.objOpenChildMenu != null )
        {
            this.objOpenChildMenu.mouseX = this.mouseX;
            this.objOpenChildMenu.mouseY = this.mouseY;
            this.objOpenChildMenu.draw();
        }
    },

    onClick: function onClick( event )
    {
        var booReturn = false;
        if( this.strActualMenuItem != null )
        {
            var funcEvent = this.arrMenuItens[ this.strActualMenuItem ].event;
            if( ! Object.isUndefined( funcEvent ) && Object.isFunction( funcEvent ) )
            {
                this.arrMenuItens[ this.strActualMenuItem ].key = this.strActualMenuItem;
                booReturn = funcEvent( this.objParent  , this.arrMenuItens[ this.strActualMenuItem ] , this );
            }
        }

        if( booReturn == false && this.objOpenChildMenu != null )
        {
            this.objOpenChildMenu.mouseX = this.mouseX;
            this.objOpenChildMenu.mouseY = this.mouseY;
            booReturn = this.objOpenChildMenu.onClick( event );
        }

        if( booReturn != true )
        {
            this.strActualMenuItem = null;
            this.objOpenChildMenu = null;
        }
        
        return booReturn;
    },

    createChildMenu: function createChildMenu( objMenuItem , arrMenuItens )
    {
        var objChildMenu = new CanvasBoxMenu();
        objChildMenu.objBox = this.objBox;
        objChildMenu.intMenuWidth = this.intMenuWidth;
        objChildMenu.intMenuX = this.intMenuX + this.intMenuWidth + 1;
        objChildMenu.intMenuY = this.intMenuY + this.intMenuItemHeight * objMenuItem.key;
		objChildMenu.intMenuItemXBorder = this.intMenuItemXBorder;
        objChildMenu.arrMenuItens = arrMenuItens;
		objChildMenu.intMenuItemHeight = this.intMenuItemHeight;
        objChildMenu.objParent = this.objParent;
        this.objOpenChildMenu = objChildMenu;
        return true;
    }
}

