var CanvasBoxLine = Class.create();
Object.extend( CanvasBoxLine.prototype, CanvasBoxConnector.prototype);
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

    borderWidth: 1,
    
    objBehavior: null,

    objContext: null,

    intMass: 1,

    intMagnetism: 0.2,

    intWallRepelsForce: 1,

    strClassName: "CanvasBoxLine",
    
    initialize: function initialize( objElementFrom , objElementTo )
    {
        this.objElementFrom = objElementFrom;
        this.objElementTo = objElementTo;
        this.objBehavior = new CanvasBoxDefaultBehavior( this );
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
        this.objContext.restore();
        this.objContext.moveTo( objPointer.x , objPointer.y );
        this.objContext.save();
        this.objContext.translate( objPointer.x , objPointer.y );
        this.objContext.rotate( dblReverseAngle );
        this.objContext.translate(  
            0
            , 
            intDistance
        );
        this.drawConnectorFrom( objPointer, intSide );
        this.objContext.restore();
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
        this.objContext.moveTo(-10, 15);
        this.objContext.lineTo(10, 15);
        this.objContext.lineTo(0, 0);
        this.objContext.lineTo(-10, 15);
        this.objContext.fill();
        this.objContext.strokeStyle = "rgb( 70, 70, 70)";
        this.objContext.moveTo(-10, 15);
        this.objContext.lineTo(10, 15);
        this.objContext.lineTo(0, 0);
        this.objContext.lineTo(-10, 15);
        this.objContext.stroke();
        this.objContext.strokeText( objPointer.degree, 20 , 20 );
    },
    
    createConnectorTo: function createConnectorTo()
    {
        var intSide = 10;

        var objPointer = this.findArrow( this.objElementTo , intSide );
        var dblAngle = objPointer.degree * 2 * Math.PI / 360;
        var dblReverseAngle = Math.PI * 2 - dblAngle;
        var intDistance = Math.abs( Math.cos( dblAngle ) ) * this.objElementTo.height / 2 ;
        intDistance += Math.abs( Math.sin( dblAngle ) ) * this.objElementTo.width / 2 ;
        this.objContext.restore();
        this.objContext.moveTo( objPointer.x , objPointer.y );
        this.objContext.save();
        this.objContext.translate( objPointer.x , objPointer.y );
        this.objContext.rotate( dblReverseAngle );
        this.objContext.translate(  
            0
            , 
            intDistance
        );
        this.drawConnectorTo( objPointer, intSide );
        this.objContext.restore();
    },

    drawConnectorTo: function drawConnectorTo( objPointer , intSide )
    {
        this.objContext.fillStyle = this.objBox.backgroundColor;
        this.objContext.beginPath();
        this.objContext.arc( 0 , 0 , intSide * 2 , 0 ,  Math.PI , true );
        this.objContext.fill();
        this.objContext.moveTo(  - intSide / 2  , - intSide / 2 );
        this.objContext.fillRect( - intSide / 2  , - intSide / 2 , intSide , intSide );
        this.objContext.strokeText( objPointer.degree, 20 , 20 );
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

    draw: function draw()
    {
        this.refresh();
        this.objContext.save();
        
            this.objContext.fillStyle = this.color;
            this.objContext.moveTo( this.x , this.y );
            
            this.objContext.beginPath();
            this.objContext.arc( this.x , this.y , this.side , 0 ,  Math.PI * 2 , true );
            this.objContext.fill();
            
            if( this.mouseOver || this.objBox.objElementClicked == this )
            {
                this.objContext.strokeStyle = this.borderColor;
                this.objContext.arc( this.x , this.y , this.side * 2 , 0 ,  Math.PI * 2 , true );
                this.objContext.stroke();
            }
            
            this.objContext.strokeStyle = this.borderColor;
            this.objContext.lineWidth = this.borderWidth;
            this.objContext.moveTo( this.x , this.y );
            this.objContext.lineTo( this.objElementFrom.x , this.objElementFrom.y );
            this.objContext.moveTo( this.x , this.y );
            this.objContext.lineTo( this.objElementTo.x , this.objElementTo.y );
            this.objContext.stroke();
        this.objContext.restore();
        this.objContext.save();
        
            this.objContext.fillStyle = this.color;
            this.objContext.moveTo( this.x , this.y );
            
            this.objContext.beginPath();
            this.objContext.arc( this.x , this.y , this.side , 0 ,  Math.PI * 2 , true );
            this.objContext.fill();

        this.z = 1;
        
        if( this.objElementFrom.strClassName == "CanvasBoxClass" )
        {
            this.createConnectorFrom();
            this.objContext.fillStyle = this.color;
            this.z = 2;
        }
        
        if( this.objElementTo.strClassName == "CanvasBoxClass" )
        {
            this.createConnectorTo();
            this.objContext.fillStyle = this.color;
            this.z = 2;
        }
        
        this.objContext.restore();
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

    cloneLine: function cloneLine()
    {
        var objLine = new CanvasBoxLine( this , this.objElementTo );
        this.cloneConnector( objLine );
        return objLine;
    },

    clone: function clone( objConnector )
    {
        return this.cloneLine( objConnector );
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
