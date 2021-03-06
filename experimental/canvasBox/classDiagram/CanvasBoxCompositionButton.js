var CanvasBoxCompositionButton = Class.create();
Object.extend( CanvasBoxCompositionButton.prototype, window.autoload.loadCanvasBoxButton().prototype);
Object.extend( CanvasBoxCompositionButton.prototype,
{
    strTitle: "Composition",
    
    width: 25,

    height: 25,
    
    drawIcon: function drawIcon()
    {
        this.objElement.objBox.beginPath();
        this.objElement.objBox.saveContext();
        this.objElement.objBox.setStrokeStyle( "rgb( 20, 20, 20)" );
        this.objElement.objBox.setFillStyle( "rgb( 0, 0, 0)" );
        this.objElement.objBox.moveTo( this.x  , this.y + this.height  );
        this.objElement.objBox.lineTo( this.x + 6 , this.y + this.height - 2 );
        this.objElement.objBox.lineTo( this.x + 8 , this.y + this.height - 8 );
        this.objElement.objBox.lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.objBox.lineTo( this.x + 30 , this.y + this.height - 16 );
        this.objElement.objBox.lineTo( this.x + 30 , this.y + this.height - 30 );
        this.objElement.objBox.lineTo( this.x + 16 , this.y + this.height - 30 );
        this.objElement.objBox.lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.objBox.lineTo( this.x + 8 , this.y + this.height - 8 );
        this.objElement.objBox.lineTo( this.x + 2 , this.y + this.height - 6 );
        this.objElement.objBox.lineTo( this.x , this.y + this.height );
        this.objElement.objBox.stroke();
        this.objElement.objBox.fill();
        this.objElement.objBox.restoreContext();

        this.objElement.objBox.beginPath();
        this.objElement.objBox.saveContext();
        this.objElement.objBox.setFillStyle( this.booMouseOver ? "rgb( 250, 250, 250)" : "rgb( 220, 220, 220)" );
        this.objElement.objBox.moveTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.objBox.lineTo( this.x + 30 , this.y + this.height - 16 );
        this.objElement.objBox.lineTo( this.x + 30 , this.y + this.height - 30 );
        this.objElement.objBox.lineTo( this.x + 16 , this.y + this.height - 30 );
        this.objElement.objBox.lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.objBox.stroke();
        this.objElement.objBox.fill();

        this.objElement.objBox.restoreContext();
        this.objElement.objBox.closePath();
    },

    onClick: function onClick( event )
    {
        return CanvasBoxClass.Static.createRelation( this.objElement , true, "CanvasBoxComposition" );
    }
});
