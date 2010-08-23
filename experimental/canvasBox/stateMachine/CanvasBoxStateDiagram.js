var CanvasBoxStateDiagram = Class.create();
Object.extend( CanvasBoxStateDiagram.prototype, window.autoload.loadCanvasBox().prototype);
Object.extend( CanvasBoxStateDiagram.prototype,
{

    defineMenu: function defineMenu()
    {
        this.objMenu = new autoload.newCanvasBoxMenu();
        this.objMenu.objParent = this;
        this.objMenu.ojbBox = this;
        this.objMenu.ojbParent = this;
        this.objMenu.arrMenuItens = ({
            0:{
                name: "create state",
                event: function( objParent ){

                    var objState = new autoload.newCanvasBoxState();
                    objState.objBehavior = new autoload.newCanvasBoxMagneticBehavior( objState );
                    objState.x = objParent.mouseX;
                    objState.y = objParent.mouseY;
                    objParent.addElement( objState );
                }
            }
        });
        this.objMenuSelected = null;
    }
});