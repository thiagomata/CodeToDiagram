var CanvasBoxStateLink = Class.create();
Object.extend( CanvasBoxStateLink.prototype, window.autoload.loadCanvasBoxLine().prototype);
Object.extend( CanvasBoxStateLink.prototype,
{
    strClassName: "CanvasBoxStateLink",

    strName: null,
    
    strTitle: null,

    draw: function draw()
    {
        this.refresh();
        this.objBox.saveContext();

            this.objBox.setFillStyle( this.color );
            this.objBox.moveTo( this.x , this.y );

            this.objBox.beginPath();
            this.objBox.arc( this.x , this.y , this.side , 0 ,  Math.PI * 2 , true );
            this.objBox.fill();

            this.objBox.setTextAlign( "left" );
            
            if( this.mouseOver || this.objBox.objElementClicked == this )
            {
                this.objBox.strokeStyle = this.borderColor;
                this.objBox.arc( this.x, this.y, this.side , 0 ,  Math.PI * 2 , true );
                this.objBox.stroke();
            }

            if( this.strName )
            {
                this.objBox.strokeText( this.strName , this.x + 10 , this.y - 10 );
            }

            this.objBox.setStrokeStyle( this.lineStyle );
            this.objBox.setLineWidth( this.borderWidth );
            this.drawLine( this.x , this.y , this.objElementFrom.x , this.objElementFrom.y );
            this.drawLine( this.x , this.y , this.objElementTo.x , this.objElementTo.y );
            this.objBox.stroke();
            this.objBox.closePath();
            this.objBox.restoreContext();
            this.objBox.saveContext();

            this.objBox.setFillStyle( this.color );
            this.objBox.moveTo( this.x , this.y );

            this.objBox.beginPath();
            this.objBox.arc( this.x , this.y , this.side , 0 ,  Math.PI * 2 , true );
            this.objBox.fill();
            this.objBox.closePath();

        this.z = 1;

        if( this.objElementFrom.strClassName != this.strClassName )
        {
            this.createConnectorFrom();
            this.objBox.setFillStyle( this.color );
            this.z = 2;
        }

        if( this.objElementTo.strClassName != this.strClassName )
        {
            this.createConnectorTo();
            this.objBox.setFillStyle( this.color );
            this.z = 2;
        }

        this.objBox.restoreContext();
    },

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
