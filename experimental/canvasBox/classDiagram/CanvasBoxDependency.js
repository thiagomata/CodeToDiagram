var CanvasBoxDependency = Class.create();
Object.extend( CanvasBoxDependency.prototype, window.autoload.loadCanvasBoxLine().prototype);
Object.extend( CanvasBoxDependency.prototype,
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
        this.objBox.moveTo(-10, 15);
        this.objBox.lineTo(  0,  0);
        this.objBox.lineTo( 10, 15);

    },


    drawConnectorTo: function drawConnectorTo( objPointer , intSide )
    {            
        this.drawBackgroundCircle( intSide );
        this.objBox.beginPath();
        this.objBox.setStrokeStyle( "rgb( 70, 70, 70)" );
        this.drawArrowTo( intSide );
        this.objBox.stroke();
//        this.objBox.strokeText( objPointer.degree, 20 , 20 );
    }
        
});
