<?php
/**
 * UmlClassDiagramPrinterToHtml - Create an html page based on the uml class diagram
 * Diagram Printer object
 * @package UmlClassDiagram
 */

/**
 * Create one class diagram based the UmlClassDiagram object
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class UmlClassDiagramPrinterToHtml implements UmlClassDiagramPrinterInterface
{
    /**
     * singleton of the printer
     * 
     * @var UmlClassdiagramPrinterHtml
     */
    protected static $objInstance;
    
    /*
     * Configuration of the printer
     * 
     * @var UmlClassDiagramPrinterConfigurationInterface 
     */
    protected $objConfiguration;
    
    /**
     * Uml Class Diagram object what will be print
     *
     * @see UmlClassDiagramPrinterInterface->objUmlClassDiagram
     * @var UmlClassDiagram
     */
    protected $objUmlClassDiagram;
    
    /**
     * Return the singleton of the UmlClassDiagramPrinterDiagram
     * 
     * @return UmlClassDiagramPrinterInterface
     */
     public static function getInstance()
     {
         if( self::$objInstance == null )
         {
             self::$objInstance = new UmlClassDiagramPrinterToHtml();
         }
         return self::$objInstance;
     }

     public function __construct()
     {
         $this->setConfiguration( new UmlClassDiagramPrinterConfigurationToHtml() ); 
     }
    /**
     * Set the configuration of the printer
     * 
     * @param UmlClassDiagramPrinterConfigurationInterface $objConfiguration
     * @return UmlClassDiagramPrinterInterface me
     */
    public  function setConfiguration( UmlClassDiagramPrinterConfigurationInterface $objConfiguration )
    {
        $this->objConfiguration = $objConfiguration;
    }

    /**
     * Get the configuration of the printer
     *
     * @return UmlClassDiagramPrinterConfigurationInterface
     */
    public  function getConfiguration()
    {
        return $this->objConfiguration;
    }

    public function getCanvasId()
    {
        if( $this->objConfiguration instanceof UmlClassDiagramPrinterConfigurationToHtml )
        {
            return $this->objConfiguration->getCanvasId();
        }
        else
        {
            return UmlClassDiagramPrinterConfigurationToHtml::getDefaultCanvasId();
        }
    }

    protected function getDiagram()
    {
        $strScriptDiagram = '';
        $strScriptDiagram .= '
            window.box = new autoload.newCanvasBox( 
                "' . $this->getCanvasId() . '" , 
                document.body.clientWidth - 10, 
                document.body.clientHeight - 10  
            );        
        ';
        foreach( $this->objUmlClassDiagram->getClasses() as $objClass )
        {
            $strScriptDiagram .= '
                var objClass' . $objClass->getPosition() . ' = new autoload.newCanvasBoxClass();            
                objClass' . $objClass->getPosition() . '.objBehavior = new autoload.newCanvasBoxDefaultBehavior( objClass' . $objClass->getPosition() . ' );
                objClass' . $objClass->getPosition() . '.strClassElementName = "' . $objClass->getName() . '";
                objClass' . $objClass->getPosition() . '.x = ' . $objClass->getX()  . ' ;
                objClass' . $objClass->getPosition() . '.y = ' . $objClass->getY()  . ' ;
                //objClass' . $objClass->getPosition() . '.x = Math.random() *  window.box.width ;
                //objClass' . $objClass->getPosition() . '.y = Math.random() * window.box.height ;                
                objClass' . $objClass->getPosition() . '.width  = ' . $objClass->getWidth()  . ' ;
                objClass' . $objClass->getPosition() . '.height = ' . $objClass->getHeight()  . ' ;
                ';
            
            $arrMethods = array();
            $arrVisibility = array(
                "public"    => "+",
                "private"   => "-",
                "protected" => "#",
                "package"   => "@"
            );
            
            $strScriptDiagram .= 'objClass' . $objClass->getPosition() . '.arrMethods = Array( "';
            foreach( $objClass->getMethods() as $objMethod )
            {
                $strMethod = $arrVisibility[ $objMethod->getVisibility() ] . $objMethod->getName() . "(";
                $arrParams = array();
                foreach( $objMethod->getParameters() as $objParameter )
                {
                    $arrParams[] = $objParameter->getName() . ': ' . $objParameter->getType();
                }
                $strMethod .= implode( ',' , $arrParams );
                $strMethod .= '): ' . $objMethod->getType();
                $arrMethods[] = $strMethod;
            }
            $strScriptDiagram .= implode( '","' , $arrMethods );
            $strScriptDiagram .= '" );
                ';
            
            $arrAttributes = array();
            
            $strScriptDiagram .= 'objClass' . $objClass->getPosition() . '.arrAttributes = Array( "';
            foreach( $objClass->getAttributes() as $objAttribute )
            {
                $strAttribute = $arrVisibility[ $objAttribute->getVisibility() ] . $objAttribute->getName()  . ': ' . $objAttribute->getType();
                $arrAttributes[] = $strAttribute;
            }
            $strScriptDiagram .= implode( '","' , $arrAttributes );
            $strScriptDiagram .= '" );
            window.box.addElement( objClass' . $objClass->getPosition() . ' );
                ';
        }
        foreach( $this->objUmlClassDiagram->getConnectors() as $objConnector)
        {
            $strClassConnector = 'CanvasBox' . ucfirst( $objConnector->getType() );
            $strScript = '
            var objLine = new autoload.new'. $strClassConnector .'( 
                objClass'. $objConnector->getClassFrom()->getPosition() . ' , 
                objClass'. $objConnector->getClassTo()->getPosition() . ' 
            );
            objLine.objBehavior = new autoload.newCanvasBoxDefaultConnectorBehavior( objLine );
            objLine.x =  ( objClass'. $objConnector->getClassFrom()->getPosition() . '.x + objClass'. $objConnector->getClassTo()->getPosition() . '.x  ) / 2;
            objLine.y =  ( objClass'. $objConnector->getClassFrom()->getPosition() . '.y + objClass'. $objConnector->getClassTo()->getPosition() . '.y  ) / 2;
            window.box.addElement( objLine );
            ';
            $strScriptDiagram .= $strScript;
        }
        return $strScriptDiagram;
    }
    
    /**
     * Perfom the print process
     *  
     * @param UmlClassDiagram $objUmlClassDiagram
     * @return mixer
     */
     public function perform( UmlClassDiagram $objUmlClassDiagram )
     {
         $this->objUmlClassDiagram = $objUmlClassDiagram;
         return $this->getPage();
     }

    /**
     * Create the html ouput of the diagram
     *
     * @return string
     */
    public function getPage()
    {
        if( $this->getConfiguration()->getEmbeded() )
        {
            return $this->getDiagram();
        }
        else
        {
            $arrReplace = array();
            $arrReplace[ '[codetodiagram:public_path]' ] = $this->getConfiguration()->getPublicPath();
            $arrReplace[ 'codetodiagram:canvasboxid' ] = $this->getCanvasId();
            $arrReplace[ '<codetodiagram:diagram/>' ] = '*/' . $this->getDiagram() . '/*';
            return $this->getTemplate( "classdiagram.html" , $arrReplace );
        }
    }
     
    public function getTemplate( $strTemplateFile , $arrReplace )
    {
        $strTemplateContent = file_get_contents( "template/" . $strTemplateFile , true );
        $strTemplateContent = str_replace(
            array_keys( $arrReplace ),
            array_values( $arrReplace ),
            $strTemplateContent
        );
        return $strTemplateContent;
    }
    
    /**
     * Create the php header to the printer type
     */
    public function getHeader()
    {        
        header( "Content-type: text/html" );
    }
}
?>