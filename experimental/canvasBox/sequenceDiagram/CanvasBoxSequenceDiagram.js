var CanvasBoxSequenceDiagram = Class.create();
Object.extend( CanvasBoxSequenceDiagram.prototype, CanvasBox.prototype);
Object.extend( CanvasBoxSequenceDiagram.prototype,
{

    defineMenu: function defineMenu()
    {
        this.objMenu = new CanvasBoxMenu();
        this.objMenu.objParent = this;
        this.objMenu.objContext = this.getContext();
        this.objMenu.arrMenuItens = ({
            0:{
                name: "create class",
                event: function( objParent ){

                    var objClass = new CanvasBoxSequenceElement( objParent );
                    objClass.objBehavior = new CanvasBoxDefaultBehavior( objClass );
                    objClass.x = objParent.mouseX;
                    objClass.y = 0;
                    objParent.addElement( objClass );
                }
            }
        });
        this.objMenuSelected = null;
    }
});
