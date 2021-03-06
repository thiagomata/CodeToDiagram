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
    public function setConfiguration( UmlSequenceDiagramPrinterConfigurationInterface $objConfiguration )
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
            $strStyle = $this->getStyle();
        }
        else
        {
            $strStyle = "";
        }
        $strStyle = str_replace( "\r", '', $strStyle );
        return implode( "'+\n'" , explode( "\n" , $strStyle ) );
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

    protected function getProportion()
    {
        return $this->getConfiguration()->getZoom() / 100 ;
    }
    /**
     * Create and return the string of the header of the html sequence diagram
     *
     * @return string
     */
    protected function getStyle()
    {
        # get the public folder
        $strPublicPath = $this->getConfiguration()->getPublicFolderPath();

        # get the url of the static style file
        $strCssFile = "{$strPublicPath}css/sequenceStyle.css";

        # if is external access, all the style should be in line
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

        # calc the number of actors and messages 
        $intQtdActors = sizeof( $this->objUmlSequenceDiagram->getActors() );
        if( $intQtdActors > 1 )
        {
            $intQtdMessageLine = $intQtdActors - 1;
        }
        else
        {
            $intQtdMessageLine = 1;
        }

        # calc the size of the header of each actor
        $intActorHeaderWidth =
        round(
            ( $this->getProportion()  * $this->getConfiguration()->getWidth() )
            /
            ( $intQtdActors )
        ) - 1;

        # calc the width of one slice of each actor
        $intSlice = $intActorHeaderWidth * 2;

        # calc the actor sizes
        $intActorBarWidth = floor( $intActorHeaderWidth * $this->getConfiguration()->getActorBarPercentWidth() / 100 );
        $intActorLogoWidth = floor( $intActorHeaderWidth * $this->getConfiguration()->getActorHeaderPercentWidth() / 100 );
        $intActorLogoBorder = floor( ( $intActorHeaderWidth - $intActorLogoWidth ) / 2 );
        $intActorHeaderHeight = floor( $intActorHeaderWidth * $this->getConfiguration()->getLineActorPercentHeight() / 100 );
        $intActorLogoHeight = floor( $intActorHeaderHeight * $this->getConfiguration()->getActorLogoPercentWidth() / 100 );
        $intActorMarginLogo = 1;
        $intActorLogoPercentHeight = floor( $this->getConfiguration()->getActorLogoPercentWidth() ) - $intActorMarginLogo;
        $intActorBoxPercentHeight = floor( 100 -  $this->getConfiguration()->getActorLogoPercentWidth() ) - $intActorMarginLogo;

        # calc the messages sizes
        $intMessageHeaderWidth = floor( $intSlice - $intActorHeaderWidth );
        $intMessageBarWidth = floor( ( $intSlice - $intActorBarWidth ) / 2 ) + 1 ;
        $intMessageBarHeight = floor( $intMessageBarWidth * $this->getConfiguration()->getLinePercentHeight() / 100 );

        # calc the font size
        $intFontWidth =
        floor(
                ( $intMessageBarHeight * $this->getConfiguration()->getPercentFont() )
                /
                100        
        );

        # calc the line margin
        $intLineMargin = round( $intMessageBarWidth / 2);

        # put the data into the replace container
        $arrReplace = array();
        $arrReplace[ "codetodiagram_sequencestyleurl" ]         = $strSequenceStyleUrl;
        $arrReplace[ "codetodiagram:body_width" ]               = round( $this->getProportion() * $this->getConfiguration()->getWidth() ) . "px";
        $arrReplace[ "codetodiagram:body_font" ]                = round( $this->getProportion() * $intFontWidth ). "px";
        $arrReplace[ "codetodiagram:slice_width" ]              = $intSlice . "px";
        $arrReplace[ "codetodiagram:message_header_width" ]     = $intMessageHeaderWidth . "px";
        $arrReplace[ "codetodiagram:message_bar_width" ]        = $intMessageBarWidth. "px";
        $arrReplace[ "codetodiagram:message_bar_height" ]       = $intMessageBarHeight. "px";
        $arrReplace[ "codetodiagram:message_row_width" ]        = round( $intMessageBarWidth - 2 *  $intActorBarWidth ). "px";
        $arrReplace[ "codetodiagram:message_row_short_width" ]  = round( $intLineMargin - 2 *  $intActorBarWidth ). "px";
        $arrReplace[ "codetodiagram:actor_header_width" ]       = $intActorHeaderWidth . "px";
        $arrReplace[ "codetodiagram:actor_header_height" ]      = $intActorHeaderHeight . "px";
        $arrReplace[ "codetodiagram:actor_bar_width" ]          = $intActorBarWidth . "px";
        $arrReplace[ "codetodiagram:actor_logo_width" ]         = $intActorLogoWidth . "px";
        $arrReplace[ "codetodiagram:actor_logo_height" ]        = $intActorLogoHeight . "px";
        $arrReplace[ "codetodiagram:actor_logo_percent_height" ]= $intActorLogoPercentHeight . "%";
        $arrReplace[ "codetodiagram:actor_box_percent_height" ] = $intActorBoxPercentHeight . "%";
        $arrReplace[ "codetodiagram:actor_logo_border" ]        = $intActorLogoBorder . "px";
        $arrReplace[ "codetodiagram:line_height" ]              = $intMessageBarHeight . "px";
        $arrReplace[ "codetodiagram_styleinline" ]              = $strStyleInLine;
        $arrReplace[ "codetodiagram:line_margin" ]              = $intLineMargin . "px";
        $arrReplace[ "codetodiagram:public_path" ]              = $strPublicPath;

        # feed the style template with the received data
        return "*/" . $this->getTemplate( "style.css" , $arrReplace ) . "/*";
    }

    protected function makeBase64File( $strFile , $strMime )
    {
        $strContent = file_get_contents( $strFile );
        $strBase64  = base64_encode( $strContent );
        return ('data:' . $strMime . ';base64,' . $strBase64 );

    }

    protected function getActor( UmlSequenceDiagramActor $objActor )
    {
        $objStereotype = $objActor->getStereotype();

        if( $objStereotype->getDefault() )
        {
            $strImage = '<img alt="' . $objActor->getStereotype()->getName() . '" src="' . $this->getConfiguration()->getPublicFolderPath() . 'images/' . $objStereotype->getName() . '.gif"/>';
            //$strImage = '<img alt="' . $objActor->getStereotype()->getName() . '" src="' . $this->makeBase64File( $this->getConfiguration()->getPublicPath() . 'images/' . $objStereotype->getName() . '.gif' , "image/gif" ) . '"/>';
        }
        else
        {
            $strImage = '<img alt="' . $objActor->getStereotype()->getName() . '"  src="' . $objStereotype->getImage() . '"/>';
        }

        $arrReplace = array();
        $arrReplace[ "codetodiagram:actor_stereotype" ] = $objStereotype->getName();
        $arrReplace[ "codetodiagram:actor_image" ] = $strImage;
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
        $strResult = '';
        $strNotesBefore = '';
        $strNotesAfter = '';

        $arrNotes = $objMessage->getNotesBefore();
        foreach( $arrNotes as $objNote )
        {
            $strNotesBefore .= $this->getNote( $objNote , false );
        }
        $arrNotes = $objMessage->getNotesAfter();
        foreach( $arrNotes as $objNote )
        {
            $strNotesAfter .= $this->getNote( $objNote , true );
        }

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

        $arrActors = $objMessage->getUmlSequenceDiagram()->getActors();
        $intQtdActors = sizeof( $arrActors );

        $strReverse = $objMessage->isReverse() ? 'reverse' : 'regular';
        $strLarge = $objMessage->isLarge() ? 'large' : 'short';
        $strRecursive = $objMessage->isRecursive() ? 'recursive' : '';

        $arrReplace = array();
        $arrReplace[ "codetodiagram:reverse" ] = $strReverse;
        $arrReplace[ "codetodiagram:large" ] = $strLarge;
        $arrReplace[ "codetodiagram:recursive" ] = $strRecursive;
        $arrReplace[ "codetodiagram:message_type" ] = $objMessage->getType();
        $arrReplace[ "<codetodiagram:message_text/>" ] =  UmlSequenceDiagramPrinterToHtml::getMessageText( $objMessage );
        $arrReplace[ "codetodiagram:message_id" ] = $objMessage->getPosition();
        $arrReplace[ "<codetodiagram:message_position/>" ] = $objMessage->getPosition();
        $arrReplace[ "codetodiagram:actor_from" ] = "actor" . $intStart;
        $arrReplace[ "codetodiagram:message_dif" ] = "dif" . ( $intStart - $intEnd );
        $arrReplace[ "<codetodiagram:message_values/>" ] = $this->getValues( $objMessage );
        $arrReplace[ "codetodiagram:regular_actor" ] = "";
        $arrReplace[ "codetodiagram:active_actor" ] = "start";

        while( $objActorActual = array_shift( $arrActors ) )
        {
            $intNextPosition =  $objActorActual->getPosition() + 1;
            $strFinal = ( $objActorActual->getPosition() == $intQtdActors ) ? "final" : "regular";

            /**
            * @var $objActorActual UmlSequenceDiagramActor
            */

            $arrReplace[ "codetodiagram:message_final" ] = $strFinal;
            $arrReplace[ "codetodiagram:actoractual_name" ] = $objActorActual->getName();
            $arrReplace[ "codetodiagram:message_dif" ] = $intNextPosition - $intEnd;;
            $arrReplace[ "codetodiagram:message_values" ] = "";

            if( $objActorActual->getPosition() < $intStart )
            {
                $strResult .= $this->getTemplate( "line_before.html" , $arrReplace );
            }
            elseif( $objActorActual->getPosition() == $intStart )
            {
                // start line //
                $strResult .=  $this->getTemplate( "line_start.html" , $arrReplace );
            }
            elseif( ( $objActorActual->getPosition() > $intStart ) and ($intNextPosition  < $intEnd ) )
            {
                // inside line //
                $strResult .=  $this->getTemplate( "line_inside.html" , $arrReplace );

            }
            elseif( $intNextPosition == $intEnd )
            {
                // last line //
                $strResult .=  $this->getTemplate( "line_end.html" , $arrReplace );
            }
            elseif( $intNextPosition > $intEnd )
            {
                // after line //
                $strResult .=  $this->getTemplate( "line_after.html" , $arrReplace );
            }
            else
            {
                $strMessage = '';
                $strMessage .= ' Invalid Position ' . "\n" ;
                $strMessage .= ' Actual Actor ' . $objActorActual->getPosition() ;
                $strMessage .= ' Message Start ' . $intStart ;
                $strMessage .= ' Message End' . $intEnd ;
                throw new Exception( $strMessage );
            }
        }

        $arrReplace = array();
        $arrReplace[ '<codetodiagram:message_collection/>' ] = $strResult;
        $arrReplace[ '<codetodiagram:message_title/>' ] = $this->getMessageValues( $objMessage , false );
        $arrReplace[ 'codetodiagram:message_click' ] = "window.location = '#message_" . $objMessage->getPosition() . "'";



        $strMessages = $this->getTemplate( "messages.html" , $arrReplace );
        $strMessages = $strNotesBefore . $strMessages . $strNotesAfter;
        return $strMessages;
    }

    /**
     * Get the html of a note element
     *
     * @param UmlSequenceDiagramNote $objNote
     * @param boolean $booAfter
     * @return string
     */
    protected function getNote( UmlSequenceDiagramNote $objNote , $booAfter = true )
    {
        $arrActors = $objNote->getActor()->getUmlSequenceDiagram()->getActors();
        $intPosition = $objNote->getActor()->getPosition();

        if( $objNote->getLeft() )
        {
            $intPosition--;
        }
        $strResult = "";

        foreach( $arrActors as $objActor )
        {
            $arrReplace = array();

            $strFinal = ( $objActor->getPosition() == sizeof( $arrActors ) ) ? "final" : "regular";

            $arrReplace[ "codetodiagram:message_final" ] = $strFinal;
            $arrReplace[ "codetodiagram:actoractual_name" ] = $objActor->getName();
            $arrReplace[ "codetodiagram:message_dif" ] = 0;
            $arrReplace[ "codetodiagram:message_type" ] = "";
            $arrReplace[ "codetodiagram:reverse" ] = "";
            $arrReplace[ "codetodiagram:large" ] = "";
            $arrReplace[ "codetodiagram:recursive" ] = "";
            $arrReplace[ "codetodiagram:regular_actor" ] = "";
            $arrReplace[ "codetodiagram:active_actor" ] = "start";
            
            /**
             * @var $objActor UmlSequenceDiagramActor
             */

            if( $objActor->getPosition() < $intPosition )
            {
                $strResult .= $this->getTemplate( "line_before.html" , $arrReplace );
            }
            elseif( $objActor->getPosition() == $intPosition )
            {
                $strContent = $objNote->getContent();
                $intMaxSize = 30;
                if( strlen( $strContent ) > $intMaxSize )
                {
                    $strShortContent = substr( $strContent , 0 , $intMaxSize - strlen( "..." ) ) . "...";   
                }
                else
                {
                        $strShortContent = $strContent;
                }
                $arrReplace[ "<codetodiagram:message_text/>" ] = $strShortContent;
                $arrReplace[ "codetodiagram:message_values" ] = $strContent;
                if( $objNote->getLeft() )
                {
                    $arrReplace[ "codetodiagram:regular_actor" ] = "";
                    $arrReplace[ "codetodiagram:active_actor" ] = "";            
                }
                $strResult .=  $this->getTemplate( "line_note.html" , $arrReplace );
            }
            elseif( $objActor->getPosition()  > $intPosition )
            {
                if( $objNote->getLeft() && ( ( $intPosition + 1 ) == $objActor->getPosition() ) )
                {
                    $arrReplace[ "codetodiagram:regular_actor" ] = "active start";
                    $arrReplace[ "codetodiagram:active_actor" ] = "active start";
                    $arrReplace[ "aftercodetodiagram:message_dif" ] = "";
                }
                // after line //
                $strResult .=  $this->getTemplate( "line_after.html" , $arrReplace );
            }
            else
            {
                $strMessage = '';
                $strMessage .= ' Invalid Position ' . "\n" ;
                $strMessage .= ' Actual Actor ' . $objActorActual->getPosition() ;
                $strMessage .= ' Message Start ' . $intStart ;
                $strMessage .= ' Message End' . $intEnd ;
                throw new Exception( $strMessage );
            }
        }

        $arrReplace = array();
        $arrReplace[ '<codetodiagram:message_collection/>' ] = $strResult;
        $arrReplace[ '<codetodiagram:message_title/>' ] = "";
        $arrReplace[ 'codetodiagram:message_click' ] = "";

        //return $strResult;
        $strReturn = $this->getTemplate( "messages.html" , $arrReplace );
//        CorujaDebug::debug( $strReturn , 1 );
        return $strReturn;
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

        return $strMessageCollection;
    }

    public function getValue( UmlSequenceDiagramValue $objValue , UmlSequenceDiagramMessage $objMessage )
    {
        $strMark = ( $objMessage->getType() == 'return' ) ? '' : '$';

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
        if( $objValue->getValue()  !== null )
        {
            $arrReplace[ '<codetodiagram:attribute_varexport/>' ] = $this->getVar( $objValue->getValue() );
        }
        else
        {
            $arrReplace[ '<codetodiagram:attribute_varexport/>' ] = "";
        }

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
        if( sizeof( $arrValues ) > 0 )
        {
            foreach( $arrValues as $objValue )
            {
                $strValueCollection .= $this->getValue( $objValue , $objMessage );
            }
            $strValueCollection = "<ul>" . $strValueCollection . "</ul>";
        }

        $arrReplace = array();
        $arrReplace[ '<codetodiagram:value_collection/>' ] = $strValueCollection;

        return $this->getTemplate( "line_values.html" , $arrReplace );
    }

    public function getMessageValues( UmlSequenceDiagramMessage $objMessage , $booHtmlTags = false )
    {
        if( $booHtmlTags )
        {
            $strResult = '<li><div class="message" id="div_message_' . $objMessage->getPosition() . '">' . "\n";
        }
        else
        {
            $strResult = '';
        }

        $strText = html_entity_decode( $objMessage->getText() );

        switch( $strText )
        {
            case '<<create>>':
            {
                if( $booHtmlTags )
                {
                    $strText = '<span class="detail_actor from">' . $objMessage->getActorFrom()->getName() . '</span> create new ' . '<span class="detail_actor to">' . $objMessage->getActorTo()->getName() .  '</span>';
                }
                else
                {
                    $strText = $objMessage->getActorFrom()->getName() . ' create new ' . $objMessage->getActorTo()->getName();
                }
                break;
            }
            case '<<destroy>>':
            {
                if( $booHtmlTags )
                {
                    $strText = '<span class="detail_actor from">' . $objMessage->getActorFrom()->getName() . '</span>' .  ' destroy ' . '<span class="detail_actor to">' . $objMessage->getActorTo()->getName() .  '</span>';
                }
                else
                {
                    $strText = $objMessage->getActorFrom()->getName();
                }
                break;
            }
            default:
            {
                if( $objMessage->getType() == 'call' )
                {
                    if( $booHtmlTags )
                    {
                        $strText = '<span class="detail_actor from">' . $objMessage->getActorFrom()->getName() .  '</span>' .  ' ' . $objMessage->getType() . ' ' . '<span class="detail_actor to">' . $objMessage->getActorTo()->getName() .  '</span>' .  '-&gt;' . self::getMessageText( $objMessage );
                    }
                    else
                    {
                        $strText = $objMessage->getActorFrom()->getName() .  ' ' . $objMessage->getType() . ' ' . $objMessage->getActorTo()->getName() . '-&gt;' . $objMessage->getText();
                    }
                }
                else
                {
                    if( $booHtmlTags )
                    {
                        $strText = '<span class="detail_actor from">' . $objMessage->getActorTo()->getName() .  '</span>' .  ' receive from ' . '<span class="detail_actor to">' . $objMessage->getActorFrom()->getName() .  '</span>' .  '-&gt;' . $objMessage->getText();
                    }
                    else
                    {
                        $strText = $objMessage->getActorTo()->getName() . ' receive from ' . $objMessage->getActorFrom()->getName() .  '-&gt;' . $objMessage->getText();
                    }
                }
                break;
            }
        }

        if( $booHtmlTags )
        {
            $strResult .= '<a name="message_' . $objMessage->getPosition() . '">' . $strText . '</a>' . "\n";
            $arrValues = $objMessage->getValues();

            $strResult .= '<div class="values" >' . "\n";
            foreach( $arrValues as $intValueId => $objValue )
            {

                if( $objMessage->getType() != 'return' )
                {
                    $strResult .= '<strong> $' . $objValue->getName() . '</strong>' .  "\n";
//                  $strResult .= '<a class="noLink" name="message_' . $intMessageId . '_param_' . $intValueId . '" ><strong> $' . $objValue->getName() . '</strong> </a>' .  "\n";
                }
                else
                {
                    $strResult .= '<strong> ' . $objValue->getName() . ' </strong>' . "\n";
                }
                $strResult .= '   <div>' .  self::getVar( $objValue->getValue() ). '</div>' . "\n";
            }

            $strResult .= '</div></div></li>' . "\n";
        }
        else
        {
            $strResult .= $strText;
        }

        return $strResult;
    }

    public function getDetails()
    {
        $strMessageValues = '';
        $arrMessages = $this->objUmlSequenceDiagram->getMessages();
        foreach( $arrMessages as $objMessage )
        {
            /** 
             * @var $objMessage UmlSequenceDiagramMessage
             **/
            $strMessageValues .= $this->getMessageValues( $objMessage , true);
        }

        $arrReplace = array();
        $arrReplace[ '<codetodiagram:message_values/>' ] = $strMessageValues;
        return $this->getTemplate( "details.html" , $arrReplace );
    }

    private static function getVar( $mixVar )
    {
        if( $mixVar == null )
        {
            return "";
        }
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
        $booActive = CodeInstrumentationReceiver::getInstance()->getConfiguration()->getActive();
        CodeInstrumentationReceiver::getInstance()->getConfiguration()->setActive( false );

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

        CodeInstrumentationReceiver::getInstance()->getConfiguration()->setActive( $booActive );
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
    //                $arrReplace[] = '<a class="noLink" href="#message_' . $intMessageId . '_param_' . $intPos . '">' . $objReflectedParameter->getCode() . '</a>';
                }
                $strText = str_replace( $arrSearch , $arrReplace , htmlentities( $strText ) );
            }
        }
        $strText = str_replace( '<span style="color: #0000BB"></span>' , '' , $strText );
        return ( $strText );
    }
}
?>
