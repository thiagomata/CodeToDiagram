var CanvasBoxMagneticBehavior = Class.create();
Object.extend( CanvasBoxMagneticBehavior.prototype, window.autoload.loadCanvasBoxDefaultBehavior().prototype);
Object.extend( CanvasBoxMagneticBehavior.prototype,
{
    intMagnetism: 1,

    intWallRepelsForce: 0.01 ,
  
    intDirectionChangeLoss: 5,
    
    intMaxForce: 10,
    
    intMargin: 20,
    
    intRepelling: 10,

    intEscapeForce: 10,
    
    dblCollisionForce: 1,
    
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
        if( !this.objBoxElement.intMass  )
        {
            this.objBoxElement.intMass = 1;
        }
        if( !this.intMagnetism )
        {
            this.intMagnetism = 1;
        }
        this.refresh();
    },

    repelsWalls: function repelsWalls( arrVectors )
    {
        var objVector;
        var dblZoom;
        if( this.objBoxElement && this.objBoxElement.objBox )
        {
            dblZoom = this.objBoxElement.objBox.dblZoom;
        }
        else
        {
            dblZoom = 1;
        }
        var dblWallForce = this.intWallRepelsForce * this.objBoxElement.objBox.arrElements.length * dblZoom;
        objVector = Array();

        objVector[ "dx" ] = -1 * ( this.objBoxElement.x ) * dblWallForce;
        objVector[ "dy" ] = 0;
        arrVectors.push( objVector );

        objVector = Array();
        objVector[ "dx" ] = 1 * ( this.objBoxElement.objBox.width - this.objBoxElement.x ) * dblWallForce;
        objVector[ "dy" ] = 0;
        arrVectors.push( objVector );

        objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = -1 * ( this.objBoxElement.y ) * dblWallForce;
        arrVectors.push( objVector );

        objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = 1 * ( this.objBoxElement.objBox.height - this.objBoxElement.y ) * dblWallForce;

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


//        if( this.objBoxElement.x <= this.intMargin )
        {
//            this.objBoxElement.x = (this.objBoxElement.width / 2) + 50;
            objVector[ "dx" ] += 1 * Math.abs( this.intEscapeForce + ( this.objBoxElement.objBox.width - this.objBoxElement.x ) );
        }
//       if( this.objBoxElement.x1 + this.intMargin >= this.objBoxElement.objBox.width )
        {
//            this.objBoxElement.x = this.objBoxElement.objBox.width - ( this.objBoxElement.width / 2 ) - 50;
            objVector[ "dx" ] += -1 * Math.abs( this.intEscapeForce + ( this.objBoxElement.x ) );
        }
//        if( this.objBoxElement.y <= this.intMargin )
        {
//            this.objBoxElement.y = (this.objBoxElement.height / 2) + 50;
            objVector[ "dy" ] += 1 * Math.abs( this.intEscapeForce + ( this.objBoxElement.objBox.height - this.objBoxElement.y ) );
        }
//        if( this.objBoxElement.y1 + this.intMargin >= this.objBoxElement.objBox.height )
        {
//            this.objBoxElement.y = this.objBoxElement.objBox.height - ( this.objBoxElement.height / 2 ) - 50;
            objVector[ "dy" ] += -1 * Math.abs( this.intEscapeForce + ( this.objBoxElement.y ) );
        }

        if( ( objVector[ "dx" ] != 0 ) || ( objVector[ "dy" ] != 0 ) )
        {
            arrVectors.push( objVector );
        }
        return arrVectors;
    },


    keepOnLimits2: function keepOnLimits2()
    {
        var booChanged = false;

        if( this.objBoxElement.x < this.intMargin )
        {
            this.objBoxElement.x = this.intMargin;
//            this.objBoxElement.dx += this.intEscapeForce;
            booChanged = true;
        }
        if( this.objBoxElement.x + this.intMargin > this.objBoxElement.objBox.width )
        {
            this.objBoxElement.x = Math.round( this.objBoxElement.objBox.width - (  this.intMargin  ) );
//            this.objBoxElement.dx -= this.intEscapeForce;
            booChanged = true;
        }
        if( this.objBoxElement.y < this.intMargin )
        {
            this.objBoxElement.y = this.intMargin;
//            this.objBoxElement.dy += this.intEscapeForce;
            booChanged = true;
        }
        if( this.objBoxElement.y + this.intMargin > this.objBoxElement.objBox.height )
        {
            this.objBoxElement.y = Math.round( this.objBoxElement.objBox.height - ( this.intMargin ) );
//            this.objBoxElement.dy -= this.intEscapeForce;
            booChanged = true;
        }

        return booChanged;
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


        this.objBoxElement.dx = Math.round( this.objBoxElement.dx );
        this.objBoxElement.dy = Math.round( this.objBoxElement.dy );

        if( isNaN( this.objBoxElement.dx ) )
        {
            this.objBoxElement.dx = 0;
        }

        if( isNaN( this.objBoxElement.dy ) )
        {
            this.objBoxElement.dy = 0;
        }

        this.getVectors( arrVectors );
        if( true )
        {
            if(
                Math.round(this.objBoxElement.dx) !== 0 ||
                Math.round(this.objBoxElement.dy) !== 0)
            {
                this.objBoxElement.objBox.booChanged = true;
                this.objBoxElement.x = Math.round( this.objBoxElement.x + this.objBoxElement.dx );
                this.objBoxElement.y = Math.round( this.objBoxElement.y + this.objBoxElement.dy );
            }
        }
        this.keepOnLimits2();
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
        if( arrVectors.length == 0 )
        {
            this.objBoxElement.dx = 0;
            this.objBoxElement.dy = 0;
            this.refresh();
            return;
        }
        var dblX = 0;
        var dblY = 0;
        for( var i = 0; i < intQtdVectors; ++i )
        {
            var objVector = arrVectors[ i ];
            dblX += objVector.dx;
            dblY += objVector.dy;
        }
        var dx = Math.round( dblX / intQtdVectors );
        var dy  = Math.round( dblY / intQtdVectors );
        if( dx > this.intMaxForce ) dx = this.intMaxForce; 
        if( dx < -this.intMaxForce  ) dx = -this.intMaxForce;
        if( dy > this.intMaxForce ) dy = this.intMaxForce;
        if( dy < -this.intMaxForce ) dy = -this.intMaxForce;
        this.objBoxElement.dx = dx;
        this.objBoxElement.dy = dy;
        this.refresh();
    },

    getForce: function getForce( objElement )
    {
        var objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = 0;

        var booCollision = false;
        
        if( this.objBoxElement.intMass == 0 )
        {
            return objVector;
        }
        
        var intDirectionX = ( objElement.x < this.objBoxElement.x ) ? -1 : 1;
        var intDirectionY = ( objElement.y < this.objBoxElement.y ) ? -1 : 1;

        var intDifX ;
        var intDifY ;

        intDifX = objElement.x - this.objBoxElement.x;
        intDifY = objElement.y - this.objBoxElement.y;

        var dblDist = Math.sqrt( ( intDifX * intDifX ) + ( intDifY * intDifY ) );

        var dblForceX;
        var dblForceY;

        if( dblDist > 1 )
        {
            dblForceX = this.objBoxElement.objBox.width / ( dblDist );
            dblForceY = this.objBoxElement.objBox.height / ( dblDist );
        }
        else
        {
            dblForceX = 0;
            dblForceY = 0;
        }

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
            objVector[ "dx" ] -= this.intRepelling + Math.round( ( this.objBoxElement.x1 - objElement.x0 ) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            objVector[ "dy" ] -= this.intRepelling + Math.round( ( this.objBoxElement.y1 - objElement.y0 ) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            booCollision = true;
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
            objVector[ "dx" ] -= this.intRepelling + Math.round( (this.objBoxElement.x1 - objElement.x0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            objVector[ "dy" ] -= this.intRepelling + Math.round( (objElement.y1 - this.objBoxElement.y0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            booCollision = true;
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
            objVector[ "dx" ] += this.intRepelling + Math.round( (objElement.x1 - this.objBoxElement.x0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            objVector[ "dy" ] -= this.intRepelling + Math.round( (this.objBoxElement.y0 - objElement.y0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            booCollision = true;
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
            objVector[ "dx" ] += this.intRepelling + Math.round( (objElement.x1 - this.objBoxElement.x0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            objVector[ "dy" ] += this.intRepelling + Math.round( (objElement.y1 - this.objBoxElement.y0) * ( objElement.intMass / this.objBoxElement.intMass ) * this.dblCollisionForce );
            booCollision = true;
        }
        
        objVector[ "dx" ] +=  this.intMagnetism * intDirectionX * dblForceX * objElement.intMass / this.objBoxElement.intMass;
        objVector[ "dy" ] +=  this.intMagnetism * intDirectionY * dblForceY * objElement.intMass / this.objBoxElement.intMass;
         
        var dblDirectionChange = objVector[ "dx" ] + objVector[ "dy" ];
         
        objVector[ "dx" ] += this.intRepelling + ( Math.random( dblDirectionChange ) - ( dblDirectionChange / 2 ) ) / this.intDirectionChangeLoss;
        objVector[ "dy" ] += this.intRepelling + ( Math.random( dblDirectionChange ) - ( dblDirectionChange / 2 ) ) / this.intDirectionChangeLoss;

        if( booCollision )
        {
            objVector[ "dx" ] += ( Math.random( dblDirectionChange ) - ( dblDirectionChange / 2 ) ) / this.intDirectionChangeLoss;
            objVector[ "dy" ] += ( Math.random( dblDirectionChange ) - ( dblDirectionChange / 2 ) ) / this.intDirectionChangeLoss;
            objVector[ "dx" ] += ( Math.random( dblDirectionChange ) - ( dblDirectionChange / 2 ) ) / this.intDirectionChangeLoss;
            objVector[ "dy" ] += ( Math.random( dblDirectionChange ) - ( dblDirectionChange / 2 ) ) / this.intDirectionChangeLoss;
        }

        return objVector;
    }
});
