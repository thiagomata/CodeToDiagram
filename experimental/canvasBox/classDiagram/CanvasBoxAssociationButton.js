/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var CanvasBoxAssociationButton = Class.create();
Object.extend( CanvasBoxAssociationButton.prototype, CanvasBoxButton.prototype);
Object.extend( CanvasBoxAssociationButton.prototype,
{
    width: 25,

    height: 25,
    
    drawIcon: function drawIcon()
    {
        this.objElement.objContext.beginPath();
        this.objElement.objContext.save();
        this.objElement.objContext.strokeStyle = "rgb( 20, 20, 20)";
        this.objElement.objContext.fillStyle = this.booMouseOver ? "rgb( 250, 250, 250)" : "rgb( 220, 220, 220)" ;
        this.objElement.objContext.moveTo( this.x  , this.y + this.height  );
        this.objElement.objContext.lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.objContext.lineTo( this.x + 30 , this.y + this.height - 16 );
        this.objElement.objContext.lineTo( this.x + 30 , this.y + this.height - 30 );
        this.objElement.objContext.lineTo( this.x + 16 , this.y + this.height - 30 );
        this.objElement.objContext.lineTo( this.x + 16 , this.y + this.height - 16 );
        this.objElement.objContext.lineTo( this.x , this.y + this.height );
        this.objElement.objContext.stroke();
        this.objElement.objContext.fill();
        this.objElement.objContext.restore();
        this.objElement.objContext.closePath();
    },

    onClick: function onClick( event )
    {
        return CanvasBoxClass.Static.createRelation( this.objElement , true, "CanvasBoxAssociation" );
    },

    onDrag: function onDrag( event )
    {
        var objElement = this.onClick( event );
        objElement.select();
        return objElement;
    }
});
