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

    objContext: null,

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

        this.objContext.strokeStyle = this.menuBorderColor;
        this.objContext.lineWidth = this.menuBorderWidth;
        this.objContext.strokeRect(
            this.intMenuX , this.intMenuY, this.intMenuWidth , this.intMenuHeight
        );

        this.objContext.fillStyle = this.menuFillColor;
        this.objContext.fillRect(
            this.intMenuX , this.intMenuY, this.intMenuWidth , this.intMenuHeight
        );

        for( var i = 0 ; i < arrMenuKeys.length; ++i )
        {
            var intMenuItemX = this.intMenuX;
            var intMenuItemY = this.intMenuY + ( i ) * this.intMenuItemHeight;

            this.objContext.strokeStyle = this.menuItemBorderColor;
            this.objContext.lineWidth = this.menuItemBorderWidth;
            this.objContext.strokeRect(
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
                this.objContext.fillStyle = this.menuSelectedItemFillColor;
                this.strActualMenuItem = arrMenuKeys[ i ];
            }
            else
            {
                this.objContext.fillStyle = this.menuItemFillColor;
            }

            this.objContext.fillRect(
                intMenuItemX , intMenuItemY, this.intMenuWidth , this.intMenuItemHeight
            );

            this.objContext.fillStyle = 
            this.arrMenuItens[ arrMenuKeys[ i ] ].backgroundColor ?
            this.arrMenuItens[ arrMenuKeys[ i ] ].backgroundColor :
            this.menuItemTextColor;
            this.objContext.lineWidth = 0.9;
            this.objContext.font = "10px Times New Roman";
            this.objContext.fillText
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
        objChildMenu.objContext = this.objContext;
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

