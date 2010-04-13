var CanvasBoxMagneticConnectorBehavior = Class.create();
Object.extend( CanvasBoxMagneticConnectorBehavior.prototype, CanvasBoxDefaultConnectorBehavior.prototype);
Object.extend( CanvasBoxMagneticConnectorBehavior.prototype,
{
    fixed: false,

    dragdrop: false,

    connectorForce: 1500,

    connectorPullForce: 1500,

    connectorInteraction: 0.01,

    intMaxForce: 13,
    
    initialize: function initialize( objBoxElement )
    {
        this.objBoxElement = objBoxElement;
        this.refresh();
    },

    repelsWalls: function repelsWalls( arrVectors )
    {
        return arrVectors;
        var objVector;
        objVector = Array();

        objVector[ "dx" ] = -1 * this.connectorInteraction *  ( this.objBoxElement.x ) * this.objBoxElement.intWallRepelsForce;
        objVector[ "dy" ] = 0;
        arrVectors.push( objVector );

        objVector = Array();
        objVector[ "dx" ] = 1 * this.connectorInteraction *  ( this.objBoxElement.objBox.width - this.objBoxElement.x ) * this.objBoxElement.intWallRepelsForce;
        objVector[ "dy" ] = 0;
        arrVectors.push( objVector );

        objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = -1 * this.connectorInteraction *  ( this.objBoxElement.y ) * this.objBoxElement.intWallRepelsForce;
        arrVectors.push( objVector );

        objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = 1 * this.connectorInteraction * ( this.objBoxElement.objBox.height - this.objBoxElement.y ) * this.objBoxElement.intWallRepelsForce;
        arrVectors.push( objVector );

        return arrVectors;

    },

    followElements: function followElements( arrVectors )
    {
        var objVector;
        objVector = Array();

        var intMetaX = ( this.objBoxElement.objElementFrom.x + this.objBoxElement.objElementTo.x ) / 2;
        var intMetaY = ( this.objBoxElement.objElementFrom.y + this.objBoxElement.objElementTo.y ) / 2;

        var intDirectionX = ( this.objBoxElement.x == intMetaX ) ? 0 : ( intMetaX < this.objBoxElement.x ) ? -1 : 1;
        var intDirectionY = ( this.objBoxElement.y == intMetaY ) ? 0 : ( intMetaY < this.objBoxElement.y ) ? -1 : 1;

        var intDifX = intMetaX - this.objBoxElement.x;
        var intDifY = intMetaY - this.objBoxElement.y;

        var dblDist = Math.sqrt( ( intDifX * intDifX ) + ( intDifY * intDifY ) );

        var dblForceX = this.objBoxElement.objBox.width / ( dblDist );
        var dblForceY = this.objBoxElement.objBox.height / ( dblDist );

        objVector[ "dx" ] =  this.connectorForce * (intDirectionX / dblForceX) / this.objBoxElement.intMass * this.objBoxElement.intMagnetism;
        objVector[ "dy" ] =  this.connectorForce  * (intDirectionY / dblForceY) / this.objBoxElement.intMass * this.objBoxElement.intMagnetism;
        arrVectors.push( objVector );

        return arrVectors;

    },

    repelsElements: function repelsElements( arrVectors )
    {
        var objVector;
        var arrElements = this.objBoxElement.objBox.arrElements;
        var intQtdElements = arrElements.length;
        for( var intElement = 0; intElement < intQtdElements ; ++intElement )
        {
            var objElement = arrElements[ intElement ];
            if( objElement != this.objBoxElement )
            {
                objVector = Array();
                objVector = objElement.getForce( this.objBoxElement );
                objVector.dx *= this.connectorInteraction;
                objVector.dy *= this.connectorInteraction;
                arrVectors.push( objVector );
            }
        }
        return arrVectors;
    },

    keepOnLimits: function keepOnLimits()
    {
        this.objBoxElement.x += this.objBoxElement.dx;
        this.objBoxElement.y += this.objBoxElement.dy;

        if( this.objBoxElement.x0 < 0 )
        {
            this.objBoxElement.x = (this.objBoxElement.width / 2);
            this.objBoxElement.dx = 100;
        }
        if( this.objBoxElement.x1 > this.objBoxElement.objBox.width )
        {
            this.objBoxElement.x = this.objBoxElement.objBox.width - ( this.objBoxElement.width / 2 );
            this.objBoxElement.dx = -100;
        }
        if( this.objBoxElement.y0 < 0 )
        {
            this.objBoxElement.y = (this.objBoxElement.height / 2);
            this.objBoxElement.dy = 100;
        }
        if( this.objBoxElement.y1 > this.objBoxElement.objBox.height )
        {
            this.objBoxElement.y = this.objBoxElement.objBox.height - ( this.objBoxElement.height / 2 );
            this.objBoxElement.dy = -100;
        }
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
        arrVectors = this.followElements( arrVectors );
        arrVectors = this.repelsElements( arrVectors );

        this.getVectors( arrVectors );
        this.keepOnLimits();
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
    },

    onDrop: function onDrop( event )
    {
        this.dragdrop = false;
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
        var objElementFrom;
        var objElementTo;
        var objConnector;
        var objVector = Array();
        var intDirectionX;
        var intDirectionY;
        var intDifX;
        var intDifY;
        var dblDist;
        var dblForceX;
        var dblForceY;

        objElementFrom = this.objBoxElement.objElementFrom;
        objElementTo =  this.objBoxElement.objElementTo;

        if( ( objElement == objElementFrom ) || ( objElement == objElementTo ) )
        {

            objConnector = this.objBoxElement;
            intDirectionX = ( objConnector.x < objElement.x ) ? -1 : 1;
            intDirectionY = ( objConnector.y < objElement.y ) ? -1 : 1;

            intDifX = objConnector.x - objElement.x;
            intDifY = objConnector.y - objElement.y;

            dblDist = Math.sqrt( ( intDifX * intDifX ) + ( intDifY * intDifY ) );
            var dblDistX = Math.sqrt( ( intDifX * intDifX ) );
            var dblDistY = Math.sqrt( ( intDifY * intDifY ) );

            dblForceX = ( dblDistX ) / objElement.objBox.width;
            dblForceY = ( dblDistY ) / objElement.objBox.height;

            if( dblForceX < 0.02 )
            {
                dblForceX *= 10;
                intDirectionX *= -1;
            }
            if( dblForceY < 0.02 )
            {
                dblForceY *= 10;
                intDirectionY *= -1;
            }

            objVector[ "dx" ] =  this.connectorPullForce * dblForceX * dblForceX * intDirectionX ;
            objVector[ "dy" ] =  this.connectorPullForce * dblForceY * dblForceY *intDirectionY;
        }
        else
        {
            objVector = Array();

            intDirectionX = ( objElement.x < this.objBoxElement.x ) ? -1 : 1;
            intDirectionY = ( objElement.y < this.objBoxElement.y ) ? -1 : 1;

            intDifX = objElement.x - this.objBoxElement.x;
            intDifY = objElement.y - this.objBoxElement.y;
            dblDist = Math.sqrt( ( intDifX * intDifX ) + ( intDifY * intDifY ) );

            dblForceX = this.objBoxElement.objBox.width / ( dblDist );
            dblForceY = this.objBoxElement.objBox.height / ( dblDist );

            objVector[ "dx" ] =  this.objBoxElement.intMagnetism * intDirectionX * dblForceX / this.objBoxElement.intMass;
            objVector[ "dy" ] =  this.objBoxElement.intMagnetism * intDirectionY * dblForceY / this.objBoxElement.intMass;
        }

        this.cloneCheck( objVector );

        return objVector;
    },

    cloneCheck: function cloneCheck( objVector )
    {
        var objElementFrom = this.objBoxElement.objElementFrom;
        var objElementTo =  this.objBoxElement.objElementTo;
        var intDifX;
        var intDifY;
        

        intDifX = objElementTo.x - this.objBoxElement.x;
        intDifY = objElementTo.y - this.objBoxElement.y;
        var dblDistTo = Math.sqrt( ( intDifX * intDifX ) + ( intDifY * intDifY ) );

        intDifX = objElementFrom.x - this.objBoxElement.x;
        intDifY = objElementFrom.y - this.objBoxElement.y;
        
        var dblDistFrom = Math.sqrt( ( intDifX * intDifX ) + ( intDifY * intDifY ) );

        var intMinDist = 70;

        if( ( dblDistFrom < intMinDist ) || ( dblDistTo < intMinDist ) )
        {
            return;
        }

        if( ( Math.round( this.objBoxElement.dx ) != 0 ) || ( Math.round( this.objBoxElement.dy ) != 0 ) )
        {
            return;
        }

        var dblForce = ( abs( objVector[ "dx" ] ) + abs( objVector[ "dy" ] ) ) / 2;
        var intMaxForce = this.intMaxForce;

        if( dblForce > intMaxForce )
        {
            this.objBoxElement.clone();
        }
    }
});
