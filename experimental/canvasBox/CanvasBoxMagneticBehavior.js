var CanvasBoxMagneticBehavior = Class.create();
Object.extend( CanvasBoxMagneticBehavior.prototype, CanvasBoxDefaultBehavior.prototype);
Object.extend( CanvasBoxMagneticBehavior.prototype,
{
    fixed: false,
    
    dragdrop: false,
    
    initialize: function initialize( objBoxElement )
    {
        this.objBoxElement = objBoxElement;
        this.refresh();
    },

    move: function move()
    {
        this.refresh();
        if( this.fixed || this.dragdrop )
        { 
            return;
        }
        
        var arrVectors = Array();
        var objVector;

        objVector = Array();
        objVector[ "dx" ] = -1 * ( this.objBoxElement.x );
        objVector[ "dy" ] = 0;
        arrVectors.push( objVector );
        
        objVector = Array();
        objVector[ "dx" ] = 1 * ( this.objBoxElement.objBox.width - this.objBoxElement.x );
        objVector[ "dy" ] = 0;
        arrVectors.push( objVector );
        
        objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = -1 * ( this.objBoxElement.y );
        arrVectors.push( objVector );
        
        objVector = Array();
        objVector[ "dx" ] = 0;
        objVector[ "dy" ] = 1 * ( this.objBoxElement.objBox.height - this.objBoxElement.y );
        arrVectors.push( objVector );        

        var arrElements = this.objBoxElement.objBox.arrElements;
        var intQtdElements = arrElements.length;
        for( var intElement = 0; intElement < intQtdElements ; ++intElement )
        {
            var objElement = arrElements[ intElement ];
            if( objElement != this.objBoxElement )
            {
                objVector = Array();
                var intDirectionX = ( objElement.x < this.objBoxElement.x ) ? 1 : -1;
                var intDirectionY = ( objElement.y < this.objBoxElement.y ) ? 1 : -1;
                var intDifX = objElement.x - this.objBoxElement.x;
                var intDifY = objElement.y - this.objBoxElement.y;
                var dblDist = Math.sqrt( ( intDifX * intDifX ) + ( intDifY * intDifY ) );
                var dblForceX = this.objBoxElement.objBox.width / ( dblDist );
                var dblForceY = this.objBoxElement.objBox.height / ( dblDist );
                objVector[ "dx" ] =  objElement.intMagnetism * intDirectionX * dblForceX / objElement.intMass;
                objVector[ "dy" ] =  objElement.intMagnetism * intDirectionY * dblForceY / objElement.intMass;
                arrVectors.push( objVector );
            }
        }
        this.getVectors( arrVectors );    
        
        this.objBoxElement.x += this.objBoxElement.dx;
        this.objBoxElement.y += this.objBoxElement.dy;    
        
        if( this.objBoxElement.x0 < 0 )
        {
            this.objBoxElement.x = (this.objBoxElement.width / 2);
            this.objBoxElement.dx = 0;
        }
        if( this.objBoxElement.x1 > this.objBoxElement.objBox.width )
        {
            this.objBoxElement.x = this.objBoxElement.objBox.width - ( this.objBoxElement.width / 2 );
            this.objBoxElement.dx = 0;
        }
        if( this.objBoxElement.y0 < 0 )
        {
            this.objBoxElement.y = (this.objBoxElement.height / 2);
            this.objBoxElement.dy = 0;
        }
        if( this.objBoxElement.y1 > this.objBoxElement.objBox.height )
        {
            this.objBoxElement.y = this.objBoxElement.objBox.height - ( this.objBoxElement.height / 2 );
            this.objBoxElement.dy = 0;
        }
       this.refresh();
    },

    onTimer: function onTimer()
    {
        this.move();
    },

    onMouseOver: function onMouseOver( event )
    {
    },

    onMouseOut: function onMouseOut( event )
    {
    },

    onDblClick: function onDblClick( event )
    {
        this.fixed = !this.fixed;
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
    }        
});