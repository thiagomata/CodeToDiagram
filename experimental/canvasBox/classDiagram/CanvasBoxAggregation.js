var CanvasBoxAggregation = Class.create();
Object.extend( CanvasBoxAggregation.prototype, window.autoload.loadCanvasBoxLine().prototype);
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
        this.objBox.moveTo(-10, 15);
        this.objBox.lineTo(0, 30);
        this.objBox.lineTo(10, 15);
        this.objBox.lineTo(0, 0);
        this.objBox.lineTo(-10, 15);

    },

    drawConnectorFrom: function drawConnectorFrom( objPointer , intSide )
    {
        this.objBox.beginPath();
        this.objBox.setFillStyle( this.objBox.backgroundColor );
        this.objBox.setStrokeStyle( "rgb( 0 , 0, 0 )");
        this.objBox.arc( 0 , 0 , intSide * 2 , 0 ,  Math.PI  , true );
        this.objBox.fill();
        this.objBox.setFillStyle( "rgb( 230, 230, 250)" );
        this.objBox.beginPath();
        this.drawAggregationFrom( intSide );
        this.objBox.fill();
        this.objBox.setStrokeStyle( "rgb( 70, 70, 70)" );
        this.drawAggregationFrom( intSide );
        this.objBox.stroke();
        //this.objBox.strokeText( objPointer.degree, 20 , 20 );
    }
});
