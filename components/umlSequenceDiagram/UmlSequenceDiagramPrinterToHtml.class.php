<?php
/**
 * UmlSequenceDiagramPrinterToHtml - Generate a html diagram of the Uml Sequence Diagram object
 * @package UmlSequenceDiagram
 */

/**
 * Generate a html diagram of the Uml Sequence Diagram object
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
class UmlSequenceDiagramPrinterToHtml implements UmlSequenceDiagramPrinterInterface
{
	/**
	 * Uml Sequence Diagram object what will be print
	 * 
	 * @see UmlSequenceDiagramPrinterInterface->objUmlSequenceDiagram
	 * @var UmlSequenceDiagram
	 */
	protected $objUmlSequenceDiagram;
	
	/**
	 * Singleton of the UmlSequenceDiagramPrinterToHtml
	 * 
	 * @see UmlSequenceDiagramPrinterInterface::$objInstance
	 * @var UmlSequenceDiagramPrinterToHtml
	 */
	protected static $objInstance;
	
    /**
     * width ( in pixels ) for each message
     * 
     * @var integer
     */
    protected $intMessageWidth = 300;
    
    /**
     * width ( in pixels ) for each actor header
     * 
     * @var integer
     */
    protected $intActorHeaderWidth = 100;
    
    /**
     * width ( in pixels ) for each actor bar
     * 
     * @var integer
     */
    protected $intActorBarWidth = 10;
    
    /**
     * size ( in pixels ) of text font
     * 
     * @var integer
     */
    protected $intFont = 13;
    
    /**
     * zoom in % of the diagram
     * 
     * @var integer
     */
    protected $intZoom = 100;

    /**
     * Flag to control if access it is as a external call
     *
     * @var boolean 
     */
    protected $booExternalAccess;

    /**
     * Set if the acess it is as a external call
     *
     * @see CodeToDiagram::getExternalAcess()
     * @see CodeToDiagram->boolExternalAccess
     * @param boolean $booExternalAccess
     * @return CodeToDiagram me
     */
    public function setExternalAcess( $booExternalAccess )
    {
        $this->booExternalAccess = (boolean)$booExternalAccess;
        return $this;
    }

    /**
     * Get if the acess it is as a external call
     *
     * @see CodeToDiagram::setExternalAcess( boolean )
     * @see CodeToDiagram->boolExternalAccess
     * @return boolean
     */
    public function getExternalAcess()
    {
        return $this->booExternalAccess;
    }

	/**
	 * Return the singleton of the UmlSequenceDiagramPrinterToHtml
	 * 
	 * @see UmlSequenceDiagramPrinterInterface::getInstance
	 * @return UmlSequenceDiagramPrinterToHtml
	 */
	public static function getInstance()
	{
		if( self::$objInstance == null )
		{
			self::$objInstance = new UmlSequenceDiagramPrinterToHtml();
		}
		return self::$objInstance;
	}
	
	/**
	 * Perfom the print process
	 *  
	 * @see UmlSequenceDiagramPrinterInterface::perform( UmlSequenceDiagram )
	 * @param UmlSequenceDiagram $objUmlSequenceDiagram
	 * @return mixer
	 */
	public function perform( UmlSequenceDiagram $objUmlSequenceDiagram )
	{
		$this->objUmlSequenceDiagram = $objUmlSequenceDiagram;
		return $this->show();	
	}

    /**
     * Set the zoom of the diagram
     * 
     * @param integer $intZoom
     * @return UmlSequenceDiagram me
     */
    public function setZoom( $intZoom )
    {
        $this->intZoom = $intZoom;
        return $this;
    }

    /**
     * Get the zoom of the diagram
     * 
     * @return integer
     */
    public function getZoom()
    {
        return $this->intZoom;
    }

    /**
     * Path of the caller file
     * @var string
     */
    protected $strCallerPath;

    /**
     * Path of the public folder
     * @var string
     */
    protected $strPublicPath;

    /**
     * Set the caller path
     *
     * @see UmlSequenceDiagram::getCallerPath()
     * @see UmlSequenceDiagram->strCallerPath
     * @param string $strCallerPath
     * @return UmlSequenceDiagram me
     */
    public function setCallerPath( $strCallerPath )
    {
        $this->strCallerPath = $strCallerPath;
        return $this;
    }

    /**
     * Get the caller path
     *
     * @see UmlSequenceDiagram::setCallerPath( string )
     * @see UmlSequenceDiagram->strCallerPath
     * @param string $strCallerPath
     * @return string
     */
    public function getCallerPath()
    {
        return $this->strCallerPath;
    }

    /**
     * Set the public path
     *
     * @see UmlSequenceDiagram::getPublicPath()
     * @see UmlSequenceDiagram->strPublicPath
     * @param string $strPublicPath
     * @return UmlSequenceDiagram me
     */
    public function setPublicPath( $strPublicPath )
    {
        $this->strPublicPath = $strPublicPath;
        return $this;
    }

    /**
     * Get the public path
     *
     * @see UmlSequenceDiagram::setPublicPath( string )
     * @see UmlSequenceDiagram->strPublicPath
     * @param string $strPublicPath
     * @return string
     */
    public function getPublicPath()
    {
        return $this->strPublicPath;
    }

    /**
     * Get the header of the html printer type
     */
    public function getHeader()
    {
        header( "Content-type: text/html" );
    }

    /**
     * Create the html ouput of the diagram
     *
     * @return string
     */
    public function show()
    {
        $strHtml = '';
        $strHtml .= $this->showHeaders();
        $strHtml .= $this->showActors();
        $strHtml .= $this->showMessages();
        $strHtml .= $this->showFooter();
        $strHtml .= $this->showDetails();
        return $strHtml;
    }

    protected function getPublicFolderPath()
    {
        if( $this->getExternalAcess() )
        {
            $strPublicPath = $this->getPublicPath();
        }
        else
        {
            if( $this->getCallerPath() != null and $this->getPublicPath() != null )
            {
                $strPublicPath = CorujaFileManipulation::getRelativePath( $this->getCallerPath(), $this->getPublicPath() );
            }
            elseif( $this->getCallerPath() == null and $this->getPublicPath() != null )
            {
                $strPublicPath = $this->getPublicPath();
            }
            else
            {
                $strPublicPath = "./";
            }
        }
        return $strPublicPath;
    }

    /**
     * Create and return the string of the header of the html sequence diagram
     *
     * @return string
     */
    protected function showHeaders()
    {
        $strPublicPath = $this->getPublicFolderPath();

        $strCssFile = "{$strPublicPath}css/sequenceStyle.css";
        
        if( $this->getExternalAcess() )
        {
            $strCssImport = file_get_contents( $strCssFile  );
            $strCssImport = str_replace( 'url( "' , 'url( "' . $strPublicPath . "css/" ,  $strCssImport );
        }
        else
        {
            $strCssImport = "@import url( \"$strCssFile\" ); ";
        }
        $intQtdActors = sizeof( $this->objUmlSequenceDiagram->getActors() );
        $intQtdMessages = $intQtdActors + 1;
        $intBodyWidth =
            ( $this->intMessageWidth * $intQtdMessages * $this->intZoom / 100 )
            +
            ( 100 * $intQtdActors * $this->intZoom / 100 );

        $intFont = ( $this->intFont + round( $this->intFont * $this->intZoom / 100 ) ) / 2;
        $intMessageWidth = round( $this->intMessageWidth * $this->intZoom / 100 );

        $intMessageHeight = max( 40 ,  round( 40 * $this->intZoom / 100 ) );
        $strHtmlHeaders =
<<<HTML
            <style>
                {$strCssImport}
                .sequenceDiagram
                {
                    width: {$intBodyWidth}px;
                }
                .row
                {
                    height:{$intMessageHeight}px;
                    width: {$intMessageWidth}px;
                    font-size: {$intFont};
                }
                .row span
                {
                    height: 50%;
                }
                .actor .name
                {
                    height:{$intMessageHeight}px;
                }
            </style>
            <div class='sequenceDiagram'>
HTML;
        return $strHtmlHeaders;
    }

    /**
     * Create and return the string of the footer of the html sequence diagram
     *
     * @return string
     */
    protected function showFooter()
    {
        return ' </div> ';
    }

    /**
     * Create and return the string of the actors of the html sequence diagram
     *
     * @return string
     */
    protected function showActors()
    {
        $strHtmlActors = '';


        $strHtmlActors .=
<<<HTML
    <div class="line head">
HTML;

        $arrActors = $this->objUmlSequenceDiagram->getActors();
        
        foreach( $arrActors as $objActor )
        {
            /**
             * @var $objActor UmlSequenceDiagramActor
             */

            $arrActorName = explode( ":" , $objActor->getName() );

            $strClass = array_pop( $arrActorName );
            array_push( $arrActorName , '<strong>' . $strClass . '</strong>' );

            $strActorName = implode( " : " , $arrActorName );

            $objStereotype = $objActor->getStereotype();
            
            if( $objStereotype->getDefault())
            {
            	$strStyle = '';
            }
            else
            {
            	$strStyle = 'style=\'background-image: url( "' . $objStereotype->getImage() . '" );\'';            	
            }
            $strHtmlActors .=
<<<HTML
            <div class="row">
                <div class="message">
                    <span>&nbsp;</span>
                </div>
            </div>
            <div class="actor {$objStereotype->getName()}" {$strStyle} >
                <div class="name">
                    <span title="{$objActor->getName()}">{$strActorName}</span>
                </div>
            </div>
HTML;
         }

        $strHtmlActors .=
<<<HTML
    </div>
HTML;

         return $strHtmlActors;
    }

    /**
     * Create and return the string of the messages into the html sequence
     * diagram
     *
     * @return string
     */
    protected function showMessages()
    {
        $strHtmlMessages = '';

        $arrMessages = $this->objUmlSequenceDiagram->getMessages();
        
        foreach( $arrMessages as $intMessageId => $objMessage )
        {
            $intPos = $intMessageId + 1;

            /**
             * @var $objMessage UmlSequenceDiagramMessage
             */
            if( $objMessage->isReverse() )
            {
                $intStart = $objMessage->getActorTo()->getId();
                $intEnd = $objMessage->getActorFrom()->getId();
            }
            else
            {
                $intEnd = $objMessage->getActorTo()->getId();
                $intStart = $objMessage->getActorFrom()->getId();
            }

$strHtmlMessages .=
<<<HTML
            <div class="line body">
                  <div class="row " >
                    <div class="message ">
                      <span>&nbsp;</span>
                    </div>
                  </div>
HTML;
            $arrActors = $this->objUmlSequenceDiagram->getActors();

            $strReverse = $objMessage->isReverse() ? 'reverse' : 'regular';
            $strLarge = $objMessage->isLarge() ? 'large' : 'short';
            $strRecursive = $objMessage->isRecursive() ? 'recursive' : 'line';


            while( $objActorActual = array_shift( $arrActors ) )
            {
                $objActorNext = current( $arrActors );

                if( $objActorNext == false )
                {
                    $objActorNext = new UmlSequenceDiagramActor();
                    $objActorNext->setId( $objActorActual->getId() + 1 );
                }
                /**
                 * @var $objActorNext UmlSequenceDiagramActor
                 * @var $objActorActual UmlSequenceDiagramActor
                 */

               if( $objActorActual->getId() < $intStart )
               {
                   // before line //
                    $strHtmlMessages .=
<<<HTML

                  <div class="actor">
                    <div class="name">
                      <span title="{$objActorActual->getName()}">&nbsp;</span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="message">
                      <span>&nbsp;</span>
                    </div>
                  </div>
HTML;
               }
               elseif( $objActorActual->getId() == $intStart )
               {
                   // start line //
                   $strText = UmlSequenceDiagramPrinterToHtml::getMessageText( $intMessageId , $objMessage );
                    $strHtmlMessages .=
<<<HTML
                  <div class="actor start">
                    <div class="name">
                      <span title="{$objActorActual->getName()}">&nbsp;</span>
                    </div>
                  </div>

                  <div class="row {$objMessage->getType()} {$strReverse} {$strLarge} {$strRecursive} start ">
                    <div class="message ">
                        <a href="#message_$intMessageId" class="noLink">
                        <span><strong>{$intPos}</strong>. {$strText}</span>
                        </a>
                    {$this->showValues( $objMessage )}
                    </div>
                  </div>
HTML;
               }
               elseif( ( $objActorActual->getId() > $intStart ) and ($objActorNext->getId() < $intEnd ) )
               {
                   // inside line //
                    $strHtmlMessages .=
<<<HTML
                  <div class="actor middle {$objMessage->getType()}">
                    <div class="name">
                      <span title="{$objActorActual->getName()}">&nbsp;</span>
                    </div>
                  </div>

                  <div class="row {$objMessage->getType()} {$strReverse} {$strLarge} middle ">
                    <div class="message">
                      <span>&nbsp;</span>
                    </div>
                  </div>
HTML;
               }
               elseif( $objActorNext->getId() == $intEnd )
               {
                    $strHtmlMessages .=
<<<HTML
                  <div class="actor end {$objMessage->getType()}">
                    <div class="name">
                      <span title="{$objActorActual->getName()}">&nbsp;</span>
                    </div>
                  </div>

                  <div class="row {$objMessage->getType()} {$strReverse}  end ">
                    <div class="message ">
                      <span>&nbsp;</span>
                    </div>
                  </div>
HTML;
               }
               elseif( $objActorNext->getId() > $intEnd )
               {
                   $intDif = $objActorNext->getId() - $intEnd;
                    $strHtmlMessages .=
<<<HTML
                  <div class="actor after{$intDif}">
                    <div class="name">
                      <span title="{$objActorActual->getName()}">&nbsp;</span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="message">
                      <span>&nbsp;</span>
                    </div>
                  </div>
HTML;
               }
               else
               {
                   $strMessage = '';
                   $strMessage .= ' Invalid Id ' . "\n" ;
                   $strMessage .= ' Actual Actor ' . $objActorActual->getId() ;
                   $strMessage .= ' Next Actor ' . $objActorNext->getId() ;
                   $strMessage .= ' Message Start ' . $intStart ;
                   $strMessage .= ' Message End' . $intEnd ;
                   throw new Exception( $strMessage );
               }
            }

        $strHtmlMessages .=
<<<HTML
            </div>
HTML;

        }

        return $strHtmlMessages;
    }

    /**
     * Create and return the html of some values of some messages into the html
     * sequence diagram
     *
     * @param UmlSequenceDiagramMessage $objXmlMessage
     * @return string
     */
    public function showValues( UmlSequenceDiagramMessage $objXmlMessage )
    {
        $arrValues = $objXmlMessage->getValues();
        if( sizeof( $arrValues ) > 0 )
        {
            $strHtml = '<div class="parameters">';
            $strHtml .= '<ul>' . "\n";

            foreach( $arrValues as $objValue )
            {
                $strHtml .= '<li>' . "\n";
                if( $objXmlMessage->getType() != 'return' )
                {
                    $strHtml .= '   <strong> $' . $objValue->getName() . '</strong>' . "\n";
                }
                else
                {
                    $strHtml .= '   <strong> ' . $objValue->getName() . '</strong>' . "\n";
                }
                if( is_object( $objValue->getValue()  ) )
                {
                    $strHtml .= '   <span> object ' . get_class( $objValue->getValue() ). ' </span>' . "\n";
                }
                else
                {
                    $strHtml .= '   <span>' . gettype( $objValue->getValue() ) . ' ' . var_export( $objValue->getValue() , true ). ' </span>' . "\n";
                }
                $strHtml .= '</li>' . "\n";

            }

            $strHtml .= '</ul></div>' . "\n";
        }
        else
        {
            $strHtml = '';
        }
        return $strHtml;
    }

    public function showDetails()
    {
        $strHtml = '';
        $strHtml .= '<div id="detail"><ol>' . "\n";

        $arrMessages = $this->objUmlSequenceDiagram->getMessages();
        foreach( $arrMessages as $intMessageId => $objMessage )
        {
            /**
             * @var $objMessage UmlSequenceDiagramMessage
             **/
            $strHtml .= '<div class="message" id="message_' . $intMessageId . '">' . "\n";

            $strText = html_entity_decode( $objMessage->getText() );

            switch( $strText )
            {
                case '<<create>>':
                {
                    $strText = $objMessage->getActorFrom()->getName() . ' create new ' . $objMessage->getActorTo()->getName();
                    break;
                }
                case '<<destroy>>':
                {
                    $strText = $objMessage->getActorFrom()->getName() . ' destroy ' . $objMessage->getActorTo()->getName();
                    break;
                }
                default:
                {
                    if( $objMessage->getType() == 'call' )
                    {
                        $strText = $objMessage->getActorFrom()->getName() . ' ' . $objMessage->getType() . ' ' . $objMessage->getActorTo()->getName() . '->' . self::getMessageText( $intMessageId , $objMessage );
                    }
                    else
                    {
                        $strText = $objMessage->getActorTo()->getName() . ' receive from ' . $objMessage->getActorFrom()->getName() . '->' . $objMessage->getText();
                    }
                    break;
                }
            }

            $strHtml .= '<li><a name="message_' . $intMessageId . '">' . $strText . '</a></li>' . "\n";
            $arrValues = $objMessage->getValues();


            $strHtml .= '<div class="values" >' . "\n";
            foreach( $arrValues as $intValueId => $objValue )
            {
                if( $objMessage->getType() != 'return' )
                {
                    $strHtml .= '<strong><a class="noLink" name="message_' . $intMessageId . '_param_' . $intValueId . '" > $' . $objValue->getName() . ' </a></strong>' . "\n";
                }
                else
                {
                    $strHtml .= '<strong> ' . $objValue->getName() . ' </strong>' . "\n";
                }
                $strHtml .= '   <div>' .  self::showVar( $objValue->getValue() ). '</div>' . "\n";
            }

            $strHtml .= '</div></div>' . "\n";
        }

        $strHtml .= '</ol></div>' . "\n";
        return $strHtml;
    }

    private static function showVar( $mixVar )
    {
        $strHtml = highlight_string( '<?php ' .
            self::removeRecursiveProblem(
                    $mixVar
            ),
            true
        );
        $strHtml = str_replace( '&lt;?php&nbsp;', '', $strHtml );
        return $strHtml;
    
    }
    /**
     * When objects with recursive are export to string one error happen. This
     * code it is a work around to recusive object can be see. They recursive
     * call are replace to string with the "recursive" value
     *
     * @param object $mixExpression
     */
    private static function removeRecursiveProblem( $mixExpression )
    {
        $mixExpression = serialize( $mixExpression );
        $arrExpression = explode( ";" , $mixExpression );
        foreach( $arrExpression as $intKey => $strExpression )
        {
            $arrElement = explode( ":" , $strExpression );
            if( $arrElement[0] == "r" )
            {
                $arrElement[0] = "s";
                $arrElement[2] = '"*recursive*"';
                $arrElement[1] = strlen( $arrElement[2] ) - 2;
            }
            $arrExpression[ $intKey ] = implode( ":" , $arrElement );
        }

        $mixExpression = implode( ";" , $arrExpression );
        $mixExpression = unserialize( $mixExpression );

        $mixExpression = ( var_export( $mixExpression , true )  );
        $arrClasses = explode( "::" , $mixExpression );

        foreach( $arrClasses as $intKey => $strClass )
        {
            $arrClass = explode( " " , $strClass );
            $intLast =  sizeof( $arrClass ) - 1;
            $arrClass[ $intLast ] = ''. $arrClass[ $intLast ] . '';
            $strClass = implode( " " , $arrClass );
            $arrClasses[ $intKey ] = $strClass;
        }

        $mixExpression = implode( "::" , $arrClasses );
        return $mixExpression;
    }

    private static function getMessageText( $intMessageId , UmlSequenceDiagramMessage $objMessage )
    {
        $strText = $objMessage->getText();
        if( $objMessage->getType() != 'call' )
        {
            return  htmlentities( $strText );
        }
        $strClass = $objMessage->getActorTo()->getClassName();
        $strMethod = $objMessage->getMethod();
        if( class_exists( $strClass ) )
        {
	        $objReflectedClass = new CodeReflectionClass( $strClass );
	        if( method_exists( $strClass , $strMethod ) )
	        {
	            $objReflectedMethod = $objReflectedClass->getMethod( $strMethod );
	            $arrReflectedParameter = $objReflectedMethod->getParameters();
	        }
	        else
	        {
	 //           $objReflectedMethod = null;
	            $arrReflectedParameter = array();
	        }
	        $arrSearch = array();
	        $arrReplace = array();
	        foreach( $arrReflectedParameter as $intPos => $objReflectedParameter )
	        {
	            $arrSearch[] = $objReflectedParameter->getCode();
	            $arrReplace[] = '<a class="noLink" href="#message_' . $intMessageId . '_param_' . $intPos . '">' . $objReflectedParameter->getCode() . '</a>';
	        }
	        $strText = str_replace( $arrSearch , $arrReplace , htmlentities( $strText ) );
        }
        return ( $strText );
    }
}
?>