var CanvasBoxAssociation = Class.create();
Object.extend( CanvasBoxAssociation.prototype, CanvasBoxLine.prototype);
Object.extend( CanvasBoxAssociation.prototype,
{
    toSerialize: function toSerialize()
    {
        var objResult = new Object();
        objResult.x = Math.round( this.x );
        objResult.y = Math.round( this.y );
        objResult.side = this.side;
        objResult.color = this.color;
        objResult.borderColor = this.borderColor;
        objResult.borderWidth = this.borderWidth;
        objResult.intMass = this.intMass;
        objResult.intMagnetism = this.intMagnetism;
        objResult.intWallRepelsForce = this.intWallRepelsForce;
        objResult.strClassName = this.strClassName;
        
        return objResult;
    },

    drawConnectorFrom: function drawConnectorFrom( objPointer , intSide )
    {
    },
    
    drawConnectorTo: function drawConnectorTo( objPointer , intSide )
    {
    }
});
