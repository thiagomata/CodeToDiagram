var CanvasBoxChildButton = Class.create();
Object.extend( CanvasBoxChildButton.prototype, window.autoload.loadCanvasBoxButton().prototype);
Object.extend( CanvasBoxChildButton.prototype,
{
    width: 25,

    height: 25,

    strTitle: "Generalization",

    drawIcon: function drawIcon()
    {
        this.objElement.objBox.beginPath();
        this.objElement.objBox.saveContext();
        this.objElement.objBox.setStrokeStyle( "rgb( 20, 20, 20)" );
        this.objElement.objBox.setFillStyle( this.booMouseOver ? "rgb( 250, 250, 250)" : "rgb( 220, 220, 220)" );
        this.objElement.objBox.moveTo( this.x  , this.y + this.height  );
        this.objElement.objBox.lineTo( this.x + 9 , this.y + this.height - 3 );
        this.objElement.objBox.lineTo( this.x + 6 , this.y + this.height - 6 );
        this.objElement.objBox.lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.objBox.lineTo( this.x + 30 , this.y + this.height - 16 );
        this.objElement.objBox.lineTo( this.x + 30 , this.y + this.height - 30 );
        this.objElement.objBox.lineTo( this.x + 16 , this.y + this.height - 30 );
        this.objElement.objBox.lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.objBox.lineTo( this.x + 6 , this.y + this.height - 6 );
        this.objElement.objBox.lineTo( this.x + 3 , this.y + this.height - 9 );
        this.objElement.objBox.lineTo( this.x , this.y + this.height );
        this.objElement.objBox.stroke();
        this.objElement.objBox.fill();
        this.objElement.objBox.restoreContext();
        this.objElement.objBox.closePath();
    },

    onClick: function onClick( event )
    {
        return CanvasBoxClass.Static.createRelation( this.objElement, true, "CanvasBoxGeneralization" );
    }
});
