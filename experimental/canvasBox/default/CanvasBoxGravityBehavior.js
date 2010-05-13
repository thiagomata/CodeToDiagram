var CanvasBoxGravityBehavior = Class.create();
Object.extend( CanvasBoxGravityBehavior.prototype, CanvasBoxDefaultBehavior.prototype);
Object.extend( CanvasBoxGravityBehavior.prototype,
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
        this.objBoxElement.dy += 0.1;
        
        this.objBoxElement.x += this.objBoxElement.dx;
        this.objBoxElement.y += this.objBoxElement.dy;

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
            this.objBoxElement.y = this.objBoxElement.objBox.height - ( this.objBoxElement.height / 2 );
            this.objBoxElement.dy = -this.objBoxElement.dy + 1;
        }
       this.refresh();
    },

    onTimer: function onTimer()
    {
        this.move();
    },

    onMouseOver: function onMouseOver( event )
    {
        document.title = 'gravity';
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