var CanvasBoxStateLink = Class.create();
Object.extend( CanvasBoxStateLink.prototype, CanvasBoxLine.prototype);
Object.extend( CanvasBoxStateLink.prototype,
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

    drawArrowTo: function drawArrowTo( intSide )
    {
        this.objContext.moveTo(-10, 15);
        this.objContext.lineTo(0, 0);
        this.objContext.lineTo(10, 15);

    },


    drawConnectorTo: function drawConnectorTo( objPointer , intSide )
    {            
        this.drawBackgroundCircle( intSide );
        this.objContext.beginPath();
        this.objContext.strokeStyle = "rgb( 70, 70, 70)";
        this.drawArrowTo( intSide );
        this.objContext.stroke();
    }
        
});
