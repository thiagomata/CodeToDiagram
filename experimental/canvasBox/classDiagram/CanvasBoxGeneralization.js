var CanvasBoxGeneralization = Class.create();
Object.extend( CanvasBoxGeneralization.prototype, CanvasBoxLine.prototype);
Object.extend( CanvasBoxGeneralization.prototype,
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

    drawArrowFrom: function drawArrowFrom( intSide )
    {
        this.objContext.moveTo(-10, 15);
        this.objContext.lineTo(10, 15);
        this.objContext.lineTo(0, 0);
        this.objContext.lineTo(-10, 15);

    },


    drawConnectorFrom: function drawConnectorFrom( objPointer , intSide )
    {
        this.objContext.beginPath();
        this.objContext.fillStyle = this.objBox.backgroundColor;
        this.objContext.strokeStyle = 0;
        this.objContext.arc( 0 , 0 , intSide * 2 , 0 ,  Math.PI  , true );
        this.objContext.fill();
        this.objContext.fillStyle = "rgb( 230, 230, 250) ";
        this.objContext.beginPath();
        this.drawArrowFrom( intSide );
        this.objContext.fill();
        this.objContext.strokeStyle = "rgb( 70, 70, 70)";
        this.drawArrowFrom( intSide );
        this.objContext.stroke();
        this.objContext.strokeText( objPointer.degree, 20 , 20 );
    } 
});
