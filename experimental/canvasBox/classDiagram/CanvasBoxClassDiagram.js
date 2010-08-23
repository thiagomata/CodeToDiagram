var CanvasBoxClassDiagram = Class.create();
Object.extend( CanvasBoxClassDiagram.prototype, window.autoload.loadCanvasBox().prototype);
Object.extend( CanvasBoxClassDiagram.prototype,
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

                    var objClass = new CanvasBoxClass();
                    objClass.objBehavior = new CanvasBoxMagneticBehavior( objClass );
                    objClass.x = objParent.mouseX;
                    objClass.y = objParent.mouseY;
                    objParent.addElement( objClass );
                }
            }
        });
        this.objMenuSelected = null;
    }
});