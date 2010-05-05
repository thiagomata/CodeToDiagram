var CanvasBoxAggregation = Class.create();
Object.extend( CanvasBoxAggregation.prototype, CanvasBoxLine.prototype);
Object.extend( CanvasBoxAggregation.prototype,
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

    drawAggregationFrom: function drawAggregationFrom( intSide )
    {
        this.objContext.moveTo(-10, 15);
        this.objContext.lineTo(0, 30);
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
        this.drawAggregationFrom( intSide );
        this.objContext.fill();
        this.objContext.strokeStyle = "rgb( 70, 70, 70)";
        this.drawAggregationFrom( intSide );
        this.objContext.stroke();
        this.objContext.strokeText( objPointer.degree, 20 , 20 );
    },
    
    drawConnectorTo: function drawConnectorTo( objPointer , intSide )
    {
        this.objContext.fillStyle = this.objBox.backgroundColor;
        this.objContext.beginPath();
        this.objContext.arc( 0 , 0 , intSide * 2 , 0 ,  Math.PI , true );
        this.objContext.fill();
        this.objContext.moveTo(  - intSide / 2  , - intSide / 2 );
        this.objContext.fillStyle = "orange";
        this.objContext.fillRect( - intSide / 2  , - intSide / 2 , intSide , intSide );
        this.objContext.strokeText( objPointer.degree, 20 , 20 );
    }
});
