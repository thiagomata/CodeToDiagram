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
	 * Singleton of the UmlSequenceDiagramPrinterToHtml
	 *
	 * @see UmlSequenceDiagramPrinterInterface::$objInstance
	 * @var UmlSequenceDiagramPrinterToHtml
	 */
	protected static $objInstance;

	/**
	 * Uml Sequence Diagram object what will be print
	 *
	 * @see UmlSequenceDiagramPrinterInterface->objUmlSequenceDiagram
	 * @var UmlSequenceDiagram
	 */
	protected $objUmlSequenceDiagram;

    /**
     * Configuration of this printer
     *
     * @var UmlSequenceDiagramPrinterConfigurationToHtml
     */
    protected $objConfiguration;

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

    public function __construct()
    {
        $objConfiguration = new UmlSequenceDiagramPrinterConfigurationToHtml();
        $this->setConfiguration( $objConfiguration );
    }
    /**
     * Set the configuration of this printer
     *
     * @param UmlSequenceDiagramPrinterConfigurationToHtml $objConfiguration
     * @return UmlSequenceDiagramPrinterToHtml me
     */
    public function setConfiguration( UmlSequenceDiagramPrinterConfigurationToHtml $objConfiguration )
    {
        $this->objConfiguration = $objConfiguration;
        return $this;
    }

    /**
     * Get the configuration of this printer
     *
     * @return UmlSequenceDiagramPrinterConfigurationToHtml
     */
    public function getConfiguration()
    {
        return $this->objConfiguration;
    }

	/**
	 * Perfom the print process
	 *
	 * @see UmlSequenceDiagramPrinterInterface::perform( UmlSequenceDiagram )
	 * @param UmlSequenceDiagram $objUmlSequenceDiagram
	 * @return string
	 */
	public function perform( UmlSequenceDiagram $objUmlSequenceDiagram )
	{
		$this->objUmlSequenceDiagram = $objUmlSequenceDiagram;
		return $this->getPage();
	}

    /**
     * Get the header of the html printer type
     */
    public function getHeader()
    {
        header( "Content-type: text/html" );
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

    public function getDiagram()
    {
        $arrReplace = array();
        $arrReplace[ '<codetodiagram:actors/>' ] = $this->getActors();
        $arrReplace[ '<codetodiagram:messages/>' ] = $this->getMessages();
        $arrReplace[ '<codetodiagram:embededscript/>' ] = $this->getEmbededScript();

        if( $this->getConfiguration()->getShowDetails() )
        {
            $arrReplace[ '<codetodiagram:details/>' ] = $this->getDetails();
        }
        else
        {
            $arrReplace[ '<codetodiagram:details/>' ] = '';
        }
        
        return $this->getTemplate( "diagram.html" , $arrReplace );
    }

    public function getEmbededScript()
    {
        if( $this->getConfiguration()->getEmbeded() )
        {
            return $this->getStyle();
        }
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
            $arrReplace[ '<codetodiagram:diagram/>' ] = $this->getDiagram();
            $arrReplace[ 'codetodiagram:style' ] = $this->getStyle();
            return $this->getTemplate( "page.html" , $arrReplace );
        }
    }

    protected function getSequenceStyleFile()
    {
        return $this->getConfiguration()->getPublicFolderPath() . "css/sequenceStyle.css";
    }

    /**
     * Create and return the string of the header of the html sequence diagram
     *
     * @return string
     */
    protected function getStyle()
    {
        $strPublicPath = $this->getConfiguration()->getPublicFolderPath();
        $strCssFile = "{$strPublicPath}css/sequenceStyle.css";

        if( $this->getConfiguration()->getExternalAccess() )
        {
            $strStyleInLine = file_get_contents( $strCssFile  );
            $strSequenceStyleUrl = "";
        }
        else
        {
            $strStyleInLine = "";
            $strSequenceStyleUrl = $strCssFile;
        }

        $intMessageWidth = round(
                $this->getConfiguration()->getWidth() /
                count( $this->objUmlSequenceDiagram->getActors() )
        );

        $intFontWidth = round(
                ( $this->getConfiguration()->getWidth() * $this->getConfiguration()->getPercentFont() )
                /
                100
                
        );

        $arrReplace = array();
        $arrReplace[ "codetodiagram_sequencestyleurl" ] = $strSequenceStyleUrl;
        $arrReplace[ "codetodiagram:body_width" ] = $this->getConfiguration()->getWidth() . "px";
        $arrReplace[ "codetodiagram:body_font" ] = $intFontWidth . "px";
        $arrReplace[ "codetodiagram:message_height" ] = $this->getConfiguration()->getLinePercentHeight() . "%";
        $arrReplace[ "codetodiagram:message_width" ] =$intMessageWidth . "px";
        $arrReplace[ "codetodiagram:actor_height" ] = $this->getConfiguration()->getLinePercentHeight() . "%";
        $arrReplace[ "codetodiagram_styleinline" ] = $strStyleInLine;

        return $this->getTemplate( "style.css" , $arrReplace );
    }

    protected function getActor( UmlSequenceDiagramActor $objActor )
    {
        $objStereotype = $objActor->getStereotype();
        if( $objStereotype->getDefault())
        {
            $strStyle = '';
        }
        else
        {
            $strStyle = 'style=\'background-image: url( "' . $objStereotype->getImage() . '" );\'';
        }

        $arrReplace = array();
        $arrReplace[ "codetodiagram:actor_stereotype" ] = $objStereotype->getName();
        $arrReplace[ "codetodiagram:actor_style" ] = $strStyle;
        $arrReplace[ "codetodiagram:actor_name" ] = $objActor->getName();

        return $this->getTemplate( "actor.html" , $arrReplace );
    }

    /**
     * Create and return the string of the actors of the html sequence diagram
     *
     * @return string
     */
    protected function getActors()
    {
        $arrActors = $this->objUmlSequenceDiagram->getActors();
        $strActorCollection = '';

        foreach( $arrActors as $objActor )
        {
            $strActorCollection .= $this->getActor( $objActor );
        }

        $arrReplace[ '<codetodiagram:actor_collection/>' ] = $strActorCollection;

        return $this->getTemplate( "actors.html" , $arrReplace );
    }

    /**
     * Return the html of some message
     *
     * @param UmlSequenceDiagramMessage $objMessage
     * @return string HTML of each message
     */
    protected function getMessage( UmlSequenceDiagramMessage $objMessage )
    {
        if( $objMessage->isReverse() )
        {
            $intStart = $objMessage->getActorTo()->getPosition();
            $intEnd = $objMessage->getActorFrom()->getPosition();
        }
        else
        {
            $intEnd = $objMessage->getActorTo()->getPosition();
            $intStart = $objMessage->getActorFrom()->getPosition();
        }

        $strReverse = $objMessage->isReverse() ? 'reverse' : 'regular';
        $strLarge = $objMessage->isLarge() ? 'large' : 'short';
        $strRecursive = $objMessage->isRecursive() ? 'recursive' : 'line';

        $arrActors = $this->objUmlSequenceDiagram->getActors();

        $arrReplace = array();
        $arrReplace[ "codetodiagram:reverse" ] = $strReverse;
        $arrReplace[ "codetodiagram:large" ] = $strLarge;
        $arrReplace[ "codetodiagram:recursive" ] = $strRecursive;
        $arrReplace[ "codetodiagram:message_type" ] = $objMessage->getType();
        $arrReplace[ "<codetodiagram:message_text/>" ] =  UmlSequenceDiagramPrinterToHtml::getMessageText( $objMessage );
        $arrReplace[ "codetodiagram:message_id" ] = $objMessage->getPosition();
        $arrReplace[ "<codetodiagram:message_position/>" ] = $objMessage->getPosition();
        $arrReplace[ "codetodiagram:actoractual_name" ] = "";
        $arrReplace[ "codetodiagram:message_dif" ] = "";
        $arrReplace[ "<codetodiagram:message_values/>" ] = $this->getValues( $objMessage );

        while( $objActorActual = array_shift( $arrActors ) )
        {

            $objActorNext = current( $arrActors );
            $intNextPosition =  $objActorActual->getPosition() + 1;

            /**
            * @var $objActorNext UmlSequenceDiagramActor
            * @var $objActorActual UmlSequenceDiagramActor
            */

            $arrReplace[ "codetodiagram:actoractual_name" ] = $objActorActual->getName();
            $arrReplace[ "codetodiagram:message_dif" ] = $intNextPosition - $intEnd;;
            $arrReplace[ "codetodiagram:message_values" ] = "";

            if( $objActorActual->getPosition() < $intStart )
            {
                return $this->getTemplate( "line_before.html" , $arrReplace );
            }
            elseif( $objActorActual->getPosition() == $intStart )
            {
                // start line //
                return $this->getTemplate( "line_start.html" , $arrReplace );
            }
            elseif( ( $objActorActual->getPosition() > $intStart ) and ($intNextPosition  < $intEnd ) )
            {
                // inside line //
                return $this->getTemplate( "line_inside.html" , $arrReplace );

            }
            elseif( $intNextPosition == $intEnd )
            {
                // last line //
                return $this->getTemplate( "line_end.html" , $arrReplace );
            }
            elseif( $intNextPosition > $intEnd )
            {
                // after line //
                return $this->getTemplate( "line_after.html" , $arrReplace );
            }
            else
            {
                $strMessage = '';
                $strMessage .= ' Invalid Position ' . "\n" ;
                $strMessage .= ' Actual Actor ' . $objActorActual->getPosition() ;
                $strMessage .= ' Next Actor ' . $objActorNext->getPosition() ;
                $strMessage .= ' Message Start ' . $intStart ;
                $strMessage .= ' Message End' . $intEnd ;
                throw new Exception( $strMessage );
            }
        }
    }

    /**
     * Create and return the string of the messages into the html sequence
     * diagram
     *
     * @return string
     */
    protected function getMessages()
    {
        $arrMessages = $this->objUmlSequenceDiagram->getMessages();
        $strMessageCollection = '';

        foreach( $arrMessages as $objMessage )
        {
            $strMessageCollection .= $this->getMessage( $objMessage );
        }
        
        $arrReplace = array();
        $arrReplace[ '<codetodiagram:message_collection/>' ] = $strMessageCollection;

        return $this->getTemplate( "messages.html" , $arrReplace );
    }

    public function getValue( UmlSequenceDiagramValue $objValue , UmlSequenceDiagramMessage $objMessage )
    {
        $strMark = ( $objMessage->getType() != 'return' ) ? '' : '$';

        if( is_object( $objValue->getValue()  ) )
        {
            $strType = 'object';
            $strClass = get_class( $objValue->getValue() );
        }
        else
        {
            $strType = gettype( $objValue->getValue() );
            $strClass = '';
        }

        $arrReplace[ '<codetodiagram:attribute_mark/>' ] = $strMark;
        $arrReplace[ '<codetodiagram:attribute_name/>' ] = $objValue->getName() ;
        $arrReplace[ '<codetodiagram:attribute_type/>' ] = $strType;
        $arrReplace[ '<codetodiagram:attribute_class/>' ] = $strClass;
        $arrReplace[ '<codetodiagram:attribute_varexport/>' ] = $this->getVar( $objValue->getValue() );

        return $this->getTemplate( "value.html" , $arrReplace );
    }

    /**
     * Create and return the html of some values of some messages into the html
     * sequence diagram
     *
     * @param UmlSequenceDiagramMessage $objMessage
     * @return string
     */
    public function getValues( UmlSequenceDiagramMessage $objMessage )
    {
        $strValuesCollection = '';

        $arrValues = $objMessage->getValues();
        $strValueCollection = '';
        foreach( $arrValues as $objValue )
        {
            $strValueCollection .= $this->getValue( $objValue , $objMessage );
        }
        
        $arrReplace = array();
        $arrReplace[ '<codetodiagram:value_collection/>' ] = $strValueCollection;

        return $this->getTemplate( "line_values.html" , $arrReplace );
    }

    public function getDetails()
    {
        $strHtml = '';
        $strHtml .= '<div id="detail"><ol>' . "\n";

        $arrMessages = $this->objUmlSequenceDiagram->getMessages();
        foreach( $arrMessages as $objMessage )
        {
            /** 
             * @var $objMessage UmlSequenceDiagramMessage
             **/
            $strHtml .= '<li><div class="message" id="div_message_' . $objMessage->getPosition() . '">' . "\n";

            $strText = html_entity_decode( $objMessage->getText() );

            switch( $strText )
            {
                case '<<create>>':
                {
                    $strText = '<span class="detail_actor from">' . $objMessage->getActorFrom()->getName() . '</span> create new ' . '<span class="detail_actor to">' . $objMessage->getActorTo()->getName() .  '</span>';
                    break;
                }
                case '<<destroy>>':
                {
                    $strText = '<span class="detail_actor from">' . $objMessage->getActorFrom()->getName() . '</span>' .  ' destroy ' . '<span class="detail_actor to">' . $objMessage->getActorTo()->getName() .  '</span>';
                    break;
                }
                default:
                {
                    if( $objMessage->getType() == 'call' )
                    {
                        $strText = '<span class="detail_actor from">' . $objMessage->getActorFrom()->getName() .  '</span>' .  ' ' . $objMessage->getType() . ' ' . '<span class="detail_actor to">' . $objMessage->getActorTo()->getName() .  '</span>' .  '-&gt;' . self::getMessageText( $objMessage );
                    }
                    else
                    {
                        $strText = '<span class="detail_actor from">' . $objMessage->getActorTo()->getName() .  '</span>' .  ' receive from ' . '<span class="detail_actor to">' . $objMessage->getActorFrom()->getName() .  '</span>' .  '-&gt;' . $objMessage->getText();
                    }
                    break;
                }
            }

            $strHtml .= '<a name="message_' . $objMessage->getPosition() . '">' . $strText . '</a>' . "\n";
            $arrValues = $objMessage->getValues();


            $strHtml .= '<div class="values" >' . "\n";
            foreach( $arrValues as $intValueId => $objValue )
            {
                if( $objMessage->getType() != 'return' )
                {
                    $strHtml .= '<strong> $' . $objValue->getName() . '</strong>' .  "\n";
//                    $strHtml .= '<a class="noLink" name="message_' . $intMessageId . '_param_' . $intValueId . '" ><strong> $' . $objValue->getName() . '</strong> </a>' .  "\n";
                }
                else
                {
                    $strHtml .= '<strong> ' . $objValue->getName() . ' </strong>' . "\n";
                }
                $strHtml .= '   <div>' .  self::getVar( $objValue->getValue() ). '</div>' . "\n";
            }

            $strHtml .= '</div></div></li>' . "\n";
        }

        $strHtml .= '</ol></div>' . "\n";
        return $strHtml;
    }

        private static function getVar( $mixVar )
    {
        $strHtml = highlight_string( '<?php ' .
            self::removeRecursiveProblem(
                    $mixVar
            ),
            true
        );
        $strHtml = str_replace( '&lt;?php&nbsp;', '', $strHtml );
        $strHtml = str_replace( '<span style="color: #0000BB"></span>', '', $strHtml );
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
        $mixExpression = str_replace( '<span style="color: #0000BB"></span>' , '' , $mixExpression );
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

    private static function getMessageText( UmlSequenceDiagramMessage $objMessage )
    {
        $strText = $objMessage->getText();
        if( $objMessage->getType() != 'call' )
        {
            $strText = htmlentities( $strText );
        }
        else
        {
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
                    $arrReflectedParameter = array();
                }
                $arrSearch = array();
                $arrReplace = array();
                foreach( $arrReflectedParameter as $intPos => $objReflectedParameter )
                {
                    $arrSearch[] = $objReflectedParameter->getCode();
                    $arrReplace[] = $objReflectedParameter->getCode();
    //	            $arrReplace[] = '<a class="noLink" href="#message_' . $intMessageId . '_param_' . $intPos . '">' . $objReflectedParameter->getCode() . '</a>';
                }
                $strText = str_replace( $arrSearch , $arrReplace , htmlentities( $strText ) );
            }
        }
        $strText = str_replace( '<span style="color: #0000BB"></span>' , '' , $strText );
        return ( $strText );
    }
}
?>