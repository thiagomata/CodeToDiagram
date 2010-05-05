var CanvasBoxDependency = Class.create();
Object.extend( CanvasBoxDependency.prototype, CanvasBoxLine.prototype);
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
        this.objContext.moveTo(-10, 15);
        this.objContext.lineTo(0, 0);
        this.objContext.lineTo(10, 15);

    },


    drawConnectorTo: function drawConnectorTo( objPointer , intSide )
    {
        this.objContext.beginPath();
        this.objContext.strokeStyle = "rgb( 70, 70, 70)";
        this.drawArrowTo( intSide );
        this.objContext.stroke();
        this.objContext.strokeText( objPointer.degree, 20 , 20 );
    },
    
    drawLine: function drawLine( intXfrom, intYfrom, intXto, intYto )
    {
        var intDashedSize = 5;
        var dblDifX = ( intXfrom - intXto );
        var dblDifY = ( intYfrom - intYto );
        var dblSize = Math.sqrt( ( dblDifX * dblDifX ) + ( dblDifY * dblDifY ) ); 
        
        var dblPropX = dblDifX / dblSize ;
        var dblPropY = dblDifY / dblSize ;
        var booDraw = true;
        
        var intSteps = dblSize / intDashedSize;
        
        var dblXStep = dblDifX / intSteps;
        var dblYStep = dblDifY / intSteps;
        
        var intLineXFrom, intLineYFrom, intLineXTo, intLineYTo;
         
        for( intStep = 0; intStep < intSteps; intStep++ )
        {
            intLineXFrom = Math.round( intXfrom - ( intStep * dblXStep ) ); 
            intLineYFrom = Math.round( intYfrom - ( intStep * dblYStep ) ); 
            
            intLineXTo   = Math.round( 
                                            intXfrom - 
                                            ( ( intStep + 1 ) * dblXStep ) 
                                         ); 
            intLineYTo   = Math.round( 
                                            intYfrom - 
                                            ( ( intStep + 1 ) * dblYStep ) 
                                         );
            
            if( booDraw )
            { 
                this.objContext.moveTo( intLineXFrom , intLineYFrom );
                this.objContext.lineTo( intLineXTo , intLineYTo );
            }
            
            booDraw = !booDraw; 
        }
        
    }
        
});
