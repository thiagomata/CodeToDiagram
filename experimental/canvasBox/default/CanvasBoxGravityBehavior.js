var CanvasBoxGravityBehavior = Class.create();
Object.extend( CanvasBoxGravityBehavior.prototype, window.autoload.loadCanvasBoxDefaultBehavior().prototype);
Object.extend( CanvasBoxGravityBehavior.prototype,
{
    fixed: false,
    
    dragdrop: false,

    intEscapeForce: 0,

    dblFriction: 0.8,

    dblGravityForce: 0.5,

    dblMaxForce: 10,
    
    dblMinimalGravityForce: 1,

    dblElasticityLoss: 0.99,

    initialize: function initialize( objBoxElement )
    {
        this.objBoxElement = objBoxElement;
        this.refresh();
    },

    move: function move()
    {
        this.refresh();
        if( this.objBoxElement.fixed || this.objBoxElement.booDrag )
        { 
            return;
        }
       var booLast = this.repelsElements( this.objBoxElement );

        this.objBoxElement.dy += this.dblGravityForce;
        
        if( booLast )
        {
            if( this.objBoxElement.dy > -1 && this.objBoxElement.dy < 1 )
            {
                this.objBoxElement.dy = this.dblMinimalGravityForce;
            }

        }
        else
        {
            this.objBoxElement.dy *= -this.dblFriction;

            if( Math.abs( this.objBoxElement.dy ) < 2 )
            {
                this.objBoxElement.dy = 0;
            }

        }

        if ( this.objBoxElement.dy > this.dblMaxForce )
        {
             this.objBoxElement.dy = this.dblMaxForce;
        }
        if ( this.objBoxElement.dy < -this.dblMaxForce )
        {
             this.objBoxElement.dy = -this.dblMaxForce;
        }
        if ( this.objBoxElement.dx > this.dblMaxForce )
        {
             this.objBoxElement.dx = this.dblMaxForce;
        }
        if ( this.objBoxElement.dx < -this.dblMaxForce )
        {
             this.objBoxElement.dx = -this.dblMaxForce;
        }

        if(
            ( Math.round( this.objBoxElement.dx ) !== 0 )
            ||
            ( Math.round( this.objBoxElement.dy ) !== 0 )
        )
        {
            this.objBoxElement.objBox.booChanged = true;
        }
        
        this.objBoxElement.x = Math.round( this.objBoxElement.x + this.objBoxElement.dx );
        this.objBoxElement.y = Math.round( this.objBoxElement.y + this.objBoxElement.dy );
        this.objBoxElement.dx *= this.dblElasticityLoss;
        this.objBoxElement.dy *= this.dblElasticityLoss;

        if( this.objBoxElement.x0 < 0 )
        {
            this.objBoxElement.x = (this.objBoxElement.width / 2);
            this.objBoxElement.dx = -this.objBoxElement.dx - 1;
        }
        if( this.objBoxElement.x1 > this.objBoxElement.objBox.width )
        {
            this.objBoxElement.x = this.objBoxElement.objBox.width - ( this.objBoxElement.width / 2 );
            this.objBoxElement.dx = -this.objBoxElement.dx + 1;
        }
        if( this.objBoxElement.y0 < 0 )
        {
            this.objBoxElement.y = (this.objBoxElement.height / 2);
            this.objBoxElement.dy = -this.objBoxElement.dy - 1;
        }
        if( this.objBoxElement.y1 > this.objBoxElement.objBox.height )
        {
            this.objBoxElement.y = Math.round( this.objBoxElement.objBox.height - ( this.objBoxElement.height / 2 ) );
            this.objBoxElement.dy = -Math.round( this.objBoxElement.dy * 0.8 * 10 ) / 10;
        }
       this.refresh();
    },

    repelsElements: function repelsElements( objActualElement )
    {
        var arrElements = this.objBoxElement.objBox.arrElements;
        var intQtdElements = arrElements.length;

//        objActualElement.objBox.strokeText( objActualElement.x + ' ' + objActualElement.y , objActualElement.x + 50 , objActualElement.y + 50);

        var intMyTop    = Math.round( objActualElement.y - ( objActualElement.height / 2 ) );
        var intMyBottom = Math.round( objActualElement.y + ( objActualElement.height / 2 ) );
        var intMyRight  = Math.round( objActualElement.x + ( objActualElement.width  / 2 ) );
        var intMyLeft   = Math.round( objActualElement.x - ( objActualElement.width  / 2 ) );

        var booLast = true;
        for( var intElement = 0; intElement < intQtdElements ; ++intElement )
        {
            var objElement = arrElements[ intElement ];
            if( !objElement.isConnector && objElement.getId() != objActualElement.getId() )
            {
                if  (
                        (
                            ( Math.round( objElement.x + ( objElement.width  / 2 ) ) >= intMyLeft   )
                            &&
                            ( Math.round( objElement.x + ( objElement.width  / 2 ) ) <= intMyRight  )
                            &&
                            ( Math.round( objElement.y + ( objElement.height / 2 ) ) >= intMyTop    )
                            &&
                            ( Math.round( objElement.y + ( objElement.height / 2 ) ) <= intMyBottom )
                        )
                        ||
                        (
                            ( Math.round( objElement.x - ( objElement.width  / 2 ) ) >= intMyLeft   )
                            &&
                            ( Math.round( objElement.x - ( objElement.width  / 2 ) ) <= intMyRight  )
                            &&
                            ( Math.round( objElement.y + ( objElement.height / 2 ) ) >= intMyTop    )
                            &&
                            ( Math.round( objElement.y + ( objElement.height / 2 ) ) <= intMyBottom )
                        )
                        ||
                        (
                            ( Math.round( objElement.x + ( objElement.width  / 2 ) ) >= intMyLeft   )
                            &&
                            ( Math.round( objElement.x + ( objElement.width  / 2 ) ) <= intMyRight  )
                            &&
                            ( Math.round( objElement.y - ( objElement.height / 2 ) ) >= intMyTop    )
                            &&
                            ( Math.round( objElement.y - ( objElement.height / 2 ) ) <= intMyBottom )
                        )
                        ||
                        (
                            ( Math.round( objElement.x - ( objElement.width  / 2 ) ) >= intMyLeft   )
                            &&
                            ( Math.round( objElement.x - ( objElement.width  / 2 ) ) <= intMyRight  )
                            &&
                            ( Math.round( objElement.y - ( objElement.height / 2 ) ) >= intMyTop    )
                            &&
                            ( Math.round( objElement.y - ( objElement.height / 2 ) ) <= intMyBottom )
                        )
                    )
                {

                    booLast = booLast && ( objActualElement.y >= objElement.y );

                }
            }
        }
        return booLast;
    },

    onTimer: function onTimer()
    {
        this.move();
    },

    onMouseOver: function onMouseOver( event )
    {
        this.objBoxElement.color = "red";
    },

    onMouseOut: function onMouseOut( event )
    {
        this.objBoxElement.color = "green";
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
    }
});
