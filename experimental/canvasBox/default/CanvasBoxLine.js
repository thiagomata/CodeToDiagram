var CanvasBoxLine = Class.create();
Object.extend( CanvasBoxLine.prototype, window.autoload.loadCanvasBoxConnector().prototype);
Object.extend( CanvasBoxLine.prototype,
{
    side: 3,

    x0: 0,

    x1: 0,

    dx: 0,

    y0: 0,

    y1: 0,

    dy: 0,

    width: 0,

    height: 0,

    color: "rgb( 200, 200, 220 )",

    borderColor: "rgb( 200, 200, 220 )",

    lineStyle: "rgb( 200, 200, 220 )",
    
    borderWidth: 1,
    
    objBehavior: null,

    objContext: null,

    intMass: 1,

    intMagnetism: 0.2,

    intWallRepelsForce: 1,

    strClassName: "CanvasBoxLine",

    intCloneCount: false,

    initialize: function initialize( objElementFrom , objElementTo )
    {
        this.objElementFrom = objElementFrom;
        this.objElementTo = objElementTo;
        this.objBehavior = new autoload.newCanvasBoxDefaultBehavior( this );
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

    createConnectorFrom: function createConnectorFrom()
    {
        var intSide = 10;

        var objPointer = this.findArrow( this.objElementFrom , intSide );
        var dblAngle = objPointer.degree * 2 * Math.PI / 360;
        var dblReverseAngle = Math.PI * 2 - dblAngle;
        var intDistance = Math.abs( Math.cos( dblAngle ) ) * this.objElementFrom.height / 2 ;
        intDistance += Math.abs( Math.sin( dblAngle ) ) * this.objElementFrom.width / 2 ;
        this.objBox.restoreContext();
        this.objBox.moveTo( objPointer.x , objPointer.y );
        this.objBox.saveContext();
        this.objBox.translate( objPointer.x , objPointer.y );
        this.objBox.rotate( dblReverseAngle );
        this.objBox.translate(
            0
            , 
            intDistance
        );
        this.drawConnectorFrom( objPointer, intSide );
        this.objBox.restoreContext();
    },

    drawConnectorFrom: function drawConnectorFrom( objPointer , intSide )
    {
        this.drawBackgroundCircle( intSide );
    },
    
    drawBackgroundCircle: function drawBackgroundCircle( intSide )
    {
    },
    
    createConnectorTo: function createConnectorTo()
    {
        var intSide = 10;

        var objPointer = this.findArrow( this.objElementTo , intSide );
        var dblAngle = objPointer.degree * 2 * Math.PI / 360;
        var dblReverseAngle = Math.PI * 2 - dblAngle;
        var intDistance = Math.abs( Math.cos( dblAngle ) ) * this.objElementTo.height / 2 ;
        intDistance += Math.abs( Math.sin( dblAngle ) ) * this.objElementTo.width / 2 ;
        this.objBox.restoreContext();
        this.objBox.moveTo( objPointer.x , objPointer.y );
        this.objBox.saveContext();
        this.objBox.translate( objPointer.x , objPointer.y );
        this.objBox.rotate( dblReverseAngle );
        this.objBox.translate(
            0
            , 
            intDistance
        );
        this.drawConnectorTo( objPointer, intSide );
        this.objBox.restoreContext();
    },

    drawConnectorTo: function drawConnectorTo( objPointer , intSide )
    {
        this.drawBackgroundCircle( intSide );
    },
    
    refresh: function refresh()
    {
        this.x0 = this.x - ( this.side / 2 );
        this.x1 = this.x + ( this.side / 2 );
        this.y0 = this.y - ( this.side / 2 );
        this.y1 = this.y + ( this.side / 2 );
        if( this.x0 < 0 )
        {
            this.x += this.side;
            return this.refresh();
        }
        if( this.y0 < 0 )
        {
            this.y += this.side;
            return this.refresh();
        }
        this.width = this.side;
        this.height = this.side;
    },

    drawLine: function drawLine( intXfrom, intYfrom, intXto, intYto )
    {
            this.objBox.moveTo( intXfrom , intYfrom );
            this.objBox.lineTo( intXto , intYto );
    },
    
    draw: function draw()
    {
        this.refresh();
        this.objBox.saveContext();
        
            this.objBox.setFillStyle( this.color );
            this.objBox.moveTo( this.x , this.y );
            
            this.objBox.beginPath();
            this.objBox.arc( this.x , this.y , this.side , 0 ,  Math.PI * 2 , true );
            this.objBox.fill();
            
            if( this.mouseOver || this.objBox.objElementClicked == this )
            {
                this.objBox.strokeStyle = this.borderColor;
                this.objBox.arc( this.x , this.y , this.side * 2 , 0 ,  Math.PI * 2 , true );
                this.objBox.stroke();
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

    findArrow: function findArrow( objBoxElement , intSide )
    {
        var objPointer = new Object();

        var intDegree = Math.round( 180 + 180 * Math.atan2( objBoxElement.x - this.x , objBoxElement.y - this.y ) / Math.PI );
        objPointer.degree = intDegree;
        objPointer.x = objBoxElement.x;
        objPointer.y = objBoxElement.y;
        return objPointer;
    },

    isInside: function isInside( mouseX , mouseY )
    {
        this.refresh();
        if  (
                ( mouseX >= this.x0 )
                &&
                ( mouseX <= this.x1 )
                &&
                ( mouseY >= this.y0 )
                &&
                ( mouseY <= this.y1 )
            )
        {
            return true;
        }
        else
        {
            return false;
        }
    },

    drawMouseOver: function drawMouseOver( event )
    {
        if( !this.defaultSide )
        {
            this.defaultSide = this.side;
        }
        this.side = 6;
    },

    drawFixed: function drawFixed( boolFixed )
    {
        if( !this.defaultColor )
        {
                this.defaultColor = this.color;
            }
            
            if( boolFixed )
            {
            this.color = "rgb( 100 , 100 , 200 )";
            this.borderWidth *= 3;
            this.side = this.defaultSide;
        }
        else
        {
            this.color = this.defaultColor;
            this.borderWidth /= 3;
            this.side = this.defaultSide;
        }
    },

    drawMouseOut: function drawMouseOut( event )
    {
        this.side = this.defaultSide;
    }

});
