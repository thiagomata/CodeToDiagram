var CanvasBoxMagneticBehavior = Class.create();
Object.extend( CanvasBoxMagneticBehavior.prototype, CanvasBoxDefaultBehavior.prototype);
Object.extend( CanvasBoxMagneticBehavior.prototype,
{
    fixed: false,
    
    dragdrop: false,
    
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
        objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = 0;


        if( this.objBoxElement.x0 < 10 )
        {
            this.objBoxElement.x = (this.objBoxElement.width / 2);
            objVector[ "dx" ] = 10;
        }
        if( this.objBoxElement.x1 + 30 > this.objBoxElement.objBox.width )
        {
            this.objBoxElement.x = this.objBoxElement.objBox.width - ( this.objBoxElement.width / 2 );
            objVector[ "dx" ] = -10;
        }
        if( this.objBoxElement.y0 < 30 )
        {
            this.objBoxElement.y = (this.objBoxElement.height / 2);
            objVector[ "dy" ] = 10;
        }
        if( this.objBoxElement.y1 + 30 > this.objBoxElement.objBox.height )
        {
            this.objBoxElement.y = this.objBoxElement.objBox.height - ( this.objBoxElement.height / 2 );
            objVector[ "dy" ] = -10;
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
        if( this.fixed || this.dragdrop )
        { 
            return;
        }
        
        var arrVectors = Array();
        arrVectors = this.repelsWalls( arrVectors );
        arrVectors = this.repelsElements( arrVectors );
        arrVectors = this.keepOnLimits( arrVectors );

        this.getVectors( arrVectors );

        this.objBoxElement.x += this.objBoxElement.dx;
        this.objBoxElement.y += this.objBoxElement.dy;
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
        this.fixed = !this.fixed;
        if( this.objBoxElement.drawFixed )
        {
            this.objBoxElement.drawFixed( this.fixed );
        }
    },

    onDrag: function onDrag( event )
    {
        this.dragdrop = true;
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
        this.dragdrop = false;

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
            objVector[ "dx" ] -= Math.round( (this.objBoxElement.x1 - objElement.x0)*objElement.intMass / this.objBoxElement.intMass );//; 
            objVector[ "dy" ] -= Math.round( (this.objBoxElement.y1 - objElement.y0)*objElement.intMass / this.objBoxElement.intMass ) ;//; 
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
            objVector[ "dx" ] -= Math.round( (this.objBoxElement.x1 - objElement.x0)*objElement.intMass / this.objBoxElement.intMass );//; 
            objVector[ "dy" ] -= Math.round( (objElement.y1 - this.objBoxElement.y0)*objElement.intMass / this.objBoxElement.intMass );//; 
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
            objVector[ "dx" ] += Math.round( (objElement.x1 - this.objBoxElement.x0)*objElement.intMass / this.objBoxElement.intMass);//; 
            objVector[ "dy" ] -= Math.round( (this.objBoxElement.y0 - objElement.y0)*objElement.intMass / this.objBoxElement.intMass);//; 
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
            objVector[ "dx" ] += Math.round( (objElement.x1 - this.objBoxElement.x0)*objElement.intMass / this.objBoxElement.intMass);//; 
            objVector[ "dy" ] += Math.round( (objElement.y1 - this.objBoxElement.y0)*objElement.intMass / this.objBoxElement.intMass);//; 
        }
        
        objVector[ "dx" ] +=  this.objBoxElement.intMagnetism * intDirectionX * dblForceX * objElement.intMass  / this.objBoxElement.intMass;
        objVector[ "dy" ] +=  this.objBoxElement.intMagnetism * intDirectionY * dblForceY * objElement.intMass  / this.objBoxElement.intMass;
         
        return objVector;
    }
});
