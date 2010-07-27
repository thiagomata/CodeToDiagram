var CanvasBoxMagneticBehavior = Class.create();
Object.extend( CanvasBoxMagneticBehavior.prototype, CanvasBoxDefaultBehavior.prototype);
Object.extend( CanvasBoxMagneticBehavior.prototype,
{
  
    intDirectionChangeLoss: 100,
    
    intMargin: 20,
    
    intEscapeForce: 10,
    
    dblCollisionForce: 1.5,
    
    strClassName: "CanvasBoxMagneticBehavior",

    toSerialize: function toSerialize()
    {
        var objResult = Array();
        objResult.dragdrop = this.dragdrop;
        objResult.intMargin = this.intMargin;
        objResult.intEscapeForce = this.intEscapeForce;
        objResult.dblCollisionForce = this.dblCollisionForce;
        objResult.strClassName = this.strClassName;
        
        return objResult;
    },
    
    initialize: function initialize( objBoxElement )
    {
        this.objBoxElement = objBoxElement;
        if( !this.objBoxElement.intMass )
        {
            this.objBoxElement.intMass = 1;
        }
        if( !this.objBoxElement.intMagnetism )
        {
            this.objBoxElement.intMagnetism = 1;
        }
        this.refresh();
    },

    repelsWalls: function repelsWalls( arrVectors )
    {
        var objVector;
        objVector = Array();

        objVector[ "dx" ] = -1 * ( this.objBoxElement.x0 ) * this.objBoxElement.intWallRepelsForce;
        objVector[ "dy" ] = 0;
        arrVectors.push( objVector );

        objVector = Array();
        objVector[ "dx" ] = 1 * ( this.objBoxElement.objBox.width - this.objBoxElement.x1 ) * this.objBoxElement.intWallRepelsForce;
        objVector[ "dy" ] = 0;
        arrVectors.push( objVector );

        objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = -1 * ( this.objBoxElement.y0 ) * this.objBoxElement.intWallRepelsForce;
        arrVectors.push( objVector );

        objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = 1 * ( this.objBoxElement.objBox.height - this.objBoxElement.y1 ) * this.objBoxElement.intWallRepelsForce;
        arrVectors.push( objVector );

        return arrVectors;

    },

    repelsElements: function repelsElements( arrVectors )
    {
        var arrElements = this.objBoxElement.objBox.arrElements;
        var intQtdElements = arrElements.length;
        for( var intElement = 0; intElement < intQtdElements ; ++intElement )
        {
            var objElement = arrElements[ intElement ];
            if( objElement != this.objBoxElement )
            {
                var objVector = Array();
                objVector = objElement.getForce( this.objBoxElement );
                if( objVector !=  null )
                {
                    arrVectors.push( objVector );
                }
            }
        }
        return arrVectors;
    },

    keepOnLimits: function keepOnLimits( arrVectors )
    {
        var objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = 0;


        if( this.objBoxElement.x0 < this.intMargin )
        {
            this.objBoxElement.x = (this.objBoxElement.width / 2);
            objVector[ "dx" ] = this.intEscapeForce;
        }
        if( this.objBoxElement.x1 + this.intMargin > this.objBoxElement.objBox.width )
        {
            this.objBoxElement.x = this.objBoxElement.objBox.width - ( this.objBoxElement.width / 2 );
            objVector[ "dx" ] = -this.intEscapeForce;
        }
        if( this.objBoxElement.y0 < this.intMargin )
        {
            this.objBoxElement.y = (this.objBoxElement.height / 2);
            objVector[ "dy" ] = this.intEscapeForce;
        }
        if( this.objBoxElement.y1 + this.intMargin > this.objBoxElement.objBox.height )
        {
            this.objBoxElement.y = this.objBoxElement.objBox.height - ( this.objBoxElement.height / 2 );
            objVector[ "dy" ] = -this.intEscapeForce;
        }

        if( ( objVector[ "dx" ] != 0 ) || ( objVector[ "dy" ] != 0 ) )
        {
            arrVectors.push( objVector );
        }
        return arrVectors;
    },

    move: function move()
    {
        this.refresh();
        if( this.objBoxElement.fixed || this.objBoxElement.dragdrop )
        { 
            return;
        }
        
        var arrVectors = Array();
        arrVectors = this.repelsWalls( arrVectors );
        arrVectors = this.repelsElements( arrVectors );
        arrVectors = this.keepOnLimits( arrVectors );

        this.getVectors( arrVectors );

        if(
            Math.round(this.objBoxElement.dx) !== 0 && 
            Math.round(this.objBoxElement.dy) !== 0)
        {
            this.objBoxElement.objBox.booChanged = true;
            this.objBoxElement.x += this.objBoxElement.dx;
            this.objBoxElement.y += this.objBoxElement.dy;
        }
       this.refresh();
    },

    onTimer: function onTimer()
    {
        this.move();
    },

    onMouseOver: function onMouseOver( event )
    {
        if( this.objBoxElement.drawMouseOver )
        {
            this.objBoxElement.drawMouseOver( event );
        }
    },

    onMouseOut: function onMouseOut( event )
    {
        if( this.objBoxElement.drawMouseOut )
        {
            this.objBoxElement.drawMouseOut( event );
        }
    },

    onDblClick: function onDblClick( event )
    {
        this.objBoxElement.fixed = !this.objBoxElement.fixed;
        if( this.objBoxElement.drawFixed )
        {
            this.objBoxElement.drawFixed( this.objBoxElement.fixed );
        }
    },

    onDrag: function onDrag( event )
    {
        this.objBoxElement.dragdrop = true;
        this.objBoxElement.dx = this.objBoxElement.objBox.mouseX - this.objBoxElement.x;
        this.objBoxElement.dy = this.objBoxElement.objBox.mouseY - this.objBoxElement.y;
        this.objBoxElement.x = this.objBoxElement.objBox.mouseX;
        this.objBoxElement.y = this.objBoxElement.objBox.mouseY;

        if( this.objBoxElement.drawDrag )
        {
                this.objBoxElement.drawDrag();
        }
    },

    onDrop: function onDrop( event )
    {
        this.objBoxElement.dragdrop = false;

        if( this.objBoxElement.drawDrop )
        {
            this.objBoxElement.drawDrop();
        }
    },

    getVectors: function getVectors( arrVectors )
    {
    	var intQtdVectors = arrVectors.length;
        var dblX = 0;
        var dblY = 0;
        for( var i = 0; i < intQtdVectors; ++i )
        {
            var objVector = arrVectors[ i ];
            dblX += objVector.dx;
            dblY += objVector.dy;
        }
        var dx = dblX / intQtdVectors;
        var dy  = dblY / intQtdVectors;
        this.objBoxElement.dx = dx;
        this.objBoxElement.dy = dy;
        this.refresh();
    },

    getForce: function getForce( objElement )
    {
        var objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = 0;
        
        var intDirectionX = ( objElement.x < this.objBoxElement.x ) ? -1 : 1;
        var intDirectionY = ( objElement.y < this.objBoxElement.y ) ? -1 : 1;

        var intDifX ;
        var intDifY ;

        intDifX = objElement.x - this.objBoxElement.x;
        intDifY = objElement.y - this.objBoxElement.y;

        var dblDist = Math.sqrt( ( intDifX * intDifX ) + ( intDifY * intDifY ) );

        var dblForceX = this.objBoxElement.objBox.width / ( dblDist );
        var dblForceY = this.objBoxElement.objBox.height / ( dblDist );

        if (
            (
                ( objElement.x1 ) && ( objElement.x0 ) && ( objElement.y1 ) && ( objElement.y0 )
                &&
                ( this.objBoxElement.x1 ) && ( this.objBoxElement.x0 ) && ( this.objBoxElement.y1 ) && ( this.objBoxElement.y0 )
            )
            &&
            ( objElement.x0 >= this.objBoxElement.x0 )
            &&
            ( objElement.x0 <= this.objBoxElement.x1 )
            &&
            ( objElement.y0 >= this.objBoxElement.y0 )
            &&
            ( objElement.y0 <= this.objBoxElement.y1 )
        )
        {
            objVector[ "dx" ] -= Math.round( ( this.objBoxElement.x1 - objElement.x0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            objVector[ "dy" ] -= Math.round( ( this.objBoxElement.y1 - objElement.y0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
        }
        else if (
            (
                ( objElement.x1 ) && ( objElement.x0 ) && ( objElement.y1 ) && ( objElement.y0 )
                &&
                ( this.objBoxElement.x1 ) && ( this.objBoxElement.x0 ) && ( this.objBoxElement.y1 ) && ( this.objBoxElement.y0 )
            )
            &&
            ( objElement.x0 <= this.objBoxElement.x1 )
            &&
            ( objElement.x0 >= this.objBoxElement.x0 )
            &&
            ( objElement.y1 <= this.objBoxElement.y1 )
            &&
            ( objElement.y1 >= this.objBoxElement.y0 )
        )
        {
            objVector[ "dx" ] -= Math.round( (this.objBoxElement.x1 - objElement.x0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            objVector[ "dy" ] -= Math.round( (objElement.y1 - this.objBoxElement.y0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
        }
        else if (
            (
                ( objElement.x1 ) && ( objElement.x0 ) && ( objElement.y1 ) && ( objElement.y0 )
                &&
                ( this.objBoxElement.x1 ) && ( this.objBoxElement.x0 ) && ( this.objBoxElement.y1 ) && ( this.objBoxElement.y0 )
            )
            &&
            ( objElement.x1 <= this.objBoxElement.x1 )
            &&
            ( objElement.x1 >= this.objBoxElement.x0 )
            &&
            ( objElement.y0 <= this.objBoxElement.y1 )
            &&
            ( objElement.y0 >= this.objBoxElement.y0 )
        )
        {
            objVector[ "dx" ] += Math.round( (objElement.x1 - this.objBoxElement.x0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            objVector[ "dy" ] -= Math.round( (this.objBoxElement.y0 - objElement.y0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
        }
        else if (
            (
                ( objElement.x1 ) && ( objElement.x0 ) && ( objElement.y1 ) && ( objElement.y0 )
                &&
                ( this.objBoxElement.x1 ) && ( this.objBoxElement.x0 ) && ( this.objBoxElement.y1 ) && ( this.objBoxElement.y0 )
            )
            &&
            ( objElement.x1 >= this.objBoxElement.x1 )
            &&
            ( objElement.x1 <= this.objBoxElement.x0 )
            &&
            ( objElement.y1 >= this.objBoxElement.y0 )
            &&
            ( objElement.y1 <= this.objBoxElement.y1 )
        )
        {
            objVector[ "dx" ] += Math.round( (objElement.x1 - this.objBoxElement.x0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            objVector[ "dy" ] += Math.round( (objElement.y1 - this.objBoxElement.y0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
        }
        
        objVector[ "dx" ] +=  this.objBoxElement.intMagnetism * intDirectionX * dblForceX * objElement.intMass / this.objBoxElement.intMass;
        objVector[ "dy" ] +=  this.objBoxElement.intMagnetism * intDirectionY * dblForceY * objElement.intMass / this.objBoxElement.intMass;
         
        var dblDirectionChange = objVector[ "dx" ] + objVector[ "dy" ];
         
        objVector[ "dx" ] += ( Math.random( dblDirectionChange ) - ( dblDirectionChange / 2 ) ) / this.intDirectionChangeLoss;
        objVector[ "dy" ] += ( Math.random( dblDirectionChange ) - ( dblDirectionChange / 2 ) ) / this.intDirectionChangeLoss;
         
        return objVector;
    }
});
