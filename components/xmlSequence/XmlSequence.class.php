<?php
/**
 *
 * @author Thiago Henrique Ramos da Mata
 * @date 17-02-2009
 * @link thiagomata.blogspot.com
 * @link thiagomata.com
 *
 */
class XmlSequence
{
    protected $objXml;
    protected $arrActors = Array();
    protected $arrMessages = Array();

    protected $intMessageWidth = 300;
    protected $intActorHeaderWidth = 100;
    protected $intActorBarWidth = 10;
    protected $intFont = 13;
    protected $intZoom = 100;

    public function restart()
    {
        $this->arrActors = array();
        $this->arrMessages = array();
    }

    /**
     * Returns a path to a folder relative from another folder. Both parameters
     * must be absolute.
     *
     * - check for valid parameters
     * - in case paths are equal return './'
     * - explode parameters using '/'
     * - remove similar base folders
     * - make final address
     *
     * @param String $strFileFrom Base from the path. This must be an absolute path.
     * @param String $strFileTo Destination of the path. This must be an absolute path.
     * @param Boolean $booValidPath Use false if you don't want to check for valid folders.
     * @throws XmlSequenceException In case of invalid values
     *
     * @example $path = XmlSequence::getRelativePath( "/www/folder/", "/www/another/big/" ); // "../another/big/"
     *
     * @assert ( "/www/folder/", "/www/another/big/", false ) == "../another/big/"
     * @assert ( "", "" ) throws XmlSequenceException
     * @assert ( "hello", "" ) throws XmlSequenceException
     * @assert ( "", "hello" ) throws XmlSequenceException
     * @assert ( "cool", "hello" ) throws XmlSequenceException
     * @assert ( "/cool/", "hello" ) throws XmlSequenceException
     * @assert ( "cool", "/hello/" ) throws XmlSequenceException
     * @assert ( "/cool/", "/hello/", false ) == "../hello/"
     * @assert ( "/cool/", "/hello/", false ) == "../hello/"
     * @assert ( "/cool/", "/cool/", false ) == "./"
     * @assert ( "/cool/more/", "/other/", false ) == "../../other/"
     * @assert ( "/cool/", "/other/more/", false ) == "../other/more/"
     */
    public static function getRelativePath( $strFileFrom, $strFileTo, $booValidPath = true )
    {
        // check for valid parameters

        $strFileFrom = str_replace( "\\" , "/" , $strFileFrom );
        $strFileTo = str_replace( "\\" , "/" , $strFileTo );

        if( $booValidPath
            && ( ! is_dir( $strFileFrom ) || ! is_dir( $strFileTo ) )
        )
        {
            throw new XmlSequenceException("Invalid parameter: strFileFrom: ".$strFileFrom." strFileTo: ".$strFileTo);
        }

        // special case: equal paths
        if( $strFileFrom == $strFileTo )
        {
             $strReturnPath = './';
        }
        else
        {
            // explode parameters using '/'
            $arrFileFrom = explode( '/', $strFileFrom );
            $arrFileTo   = explode( '/', $strFileTo );

            // remove similar base folders
            while(
                current( $arrFileFrom ) == current( $arrFileTo )
                && count( $arrFileFrom ) > 0
            )
            {
                array_shift( $arrFileFrom );
                array_shift( $arrFileTo );
            }

            $arrReturnPath = array();

            // make final address
            foreach( $arrFileFrom as $strFolder )
            {
                if( $strFolder != "" ) {
                    $arrReturnPath[] = "..";
                }
            }

            foreach( $arrFileTo as $strFolder )
            {
                $arrReturnPath[] = $strFolder;
            }

            $strReturnPath = implode( '/', $arrReturnPath );

        }

        return $strReturnPath;
    }

    public function setMessages( array $arrMessages )
    {
        $this->arrMessages = $arrMessages;
    }

    public function setActors( array $arrActors )
    {
        $this->arrActors = $arrActors;
    }

    public function addMessage( XmlSequenceMessage $objMessage )
    {
        $this->arrMessages[] = $objMessage;
    }

    public function addActor( XmlSequenceActor $objActor )
    {
        $this->arrActors[] = $objActor;
    }

    public function setZoom( $intZoom )
    {
        $this->intZoom = $intZoom;
    }

    public function getZoom()
    {
        return $this->intZoom;
    }

    public function setXml( $strXml )
    {
        $this->objXml = simplexml_load_string( $strXml );
        $this->load();
    }

    public function getXml()
    {
        return $this->objXml;
    }

    public function show()
    {
        $strHtml = '';
        $strHtml .= $this->showHeaders();
        $strHtml .= $this->showActors();
        $strHtml .= $this->showMessages();
        $strHtml .= $this->showFooter();
        return $strHtml;
    }

    protected function load()
    {
        $this->loadActors();
        $this->loadMessages();
    }

    protected function loadActors()
    {
       foreach( $this->objXml->actors->actor as $xmlActor )
        {
            $intId = (integer)$xmlActor['id'];
            $strType = (string)$xmlActor['type'];
            $strName = (string)$xmlActor;

            $objActor = new XmlSequenceActor();
            $objActor->setId( $intId );
            $objActor->setType( $strType );
            $objActor->setName( $strName );

            $this->arrActors[ $objActor->getId() ] = $objActor;
        }
        ksort( $this->arrActors );
    }

    protected function loadMessages()
    {
        foreach( $this->objXml->messages->message as $xmlMessage )
        {
            $intFrom    = (integer)$xmlMessage[ 'from' ];
            $intTo      = (integer)$xmlMessage[ 'to' ];
            $strType    = (string) $xmlMessage[ 'type' ];
            $strText = (string) $xmlMessage[ 'text' ];

            $objMessage = new XmlSequenceMessage();
            $objMessage->setType( $strType );
            $objMessage->setText( $strText );

           if( !array_key_exists( $intFrom , $this->arrActors ) )
            {
                throw new Exception( ' Actor From ' . $intFrom . ' not Found ' );
            }
            $objMessage->setActorFrom( $this->arrActors[ $intFrom ] );

           if( !array_key_exists( $intTo , $this->arrActors ) )
            {
                throw new Exception( ' Actor To ' . $intTo . ' not Found ' );
            }
            $objMessage->setActorTo( $this->arrActors[ $intTo ] );

            if( isset( $xmlMessage->values->value ) )
            foreach( $xmlMessage->values->value as $xmlValue )
            {
                $strName = (string)$xmlValue['name'];
                $strValue = (string)$xmlValue['value'];
                $objValue = new XmlSequenceValue();
                $objValue->setName( $strName );
                $objValue->setValue( $strValue );

                $objMessage->addValue( $objValue );
            }

            $this->arrMessages[] = $objMessage;
        }
    }

    protected function showHeaders()
    {
        $strPublicPath = XmlSequence::getRelativePath( CALLER_PATH, PUBLIC_PATH );

        $intQtdActors = sizeof( $this->arrActors );
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
                @import "{$strPublicPath}css/sequenceStyle.css";
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

    protected function showFooter()
    {
        return ' </div> ';
    }
    protected function showActors()
    {
        $strHtmlActors = '';


        $strHtmlActors .=
<<<HTML
    <div class="line head">
HTML;

        foreach( $this->arrActors as $objActor )
        {
            /**
             * @var $objActor XmlSequenceActor
             */

            $arrActorName = explode( ":" , $objActor->getName() );

            $strClass = array_pop( $arrActorName );
            array_push( $arrActorName , '<strong>' . $strClass . '</strong>' );

            $strActorName = implode( " : " , $arrActorName );

            $strHtmlActors .=
<<<HTML
            <div class="row">
                <div class="message">
                    <span>&nbsp;</span>
                </div>
            </div>
            <div class="actor {$objActor->getType()}">
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

    protected function showMessages()
    {
        $strHtmlMessages = '';

        foreach( $this->arrMessages as $intKey => $objMessage )
        {
            $intPos = $intKey + 1;

            /**
             * @var $objMessage XmlSequenceMessage
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
            $arrActors = $this->arrActors;

            $strReverse = $objMessage->isReverse() ? 'reverse' : 'regular';
            $strLarge = $objMessage->isLarge() ? 'large' : 'short';
            $strRecursive = $objMessage->isRecursive() ? 'recursive' : 'line';


            while( $objActorActual = array_shift( $arrActors ) )
            {
                $objActorNext = current( $arrActors );

                if( $objActorNext == false )
                {
                    $objActorNext = new XmlSequenceActor();
                    $objActorNext->setId( $objActorActual->getId() + 1 );
                }
                /**
                 * @var $objActorNext XmlSequenceActor
                 * @var $objActorActual XmlSequenceActor
                 */

               if( $objActorActual->getId() < $intStart )
               {
                   // before line //
                    $strHtmlMessages .=
<<<HTML

                  <div class="actor">
                    <div class="name">
                      <span title="{$objActorActual->getName()}">{$objActorActual->getName()}</span>
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
                    $strHtmlMessages .=
<<<HTML
                  <div class="actor start">
                    <div class="name">
                      <span title="{$objActorActual->getName()}">{$objActorActual->getName()}</span>
                    </div>
                  </div>

                  <div class="row {$objMessage->getType()} {$strReverse} {$strLarge} {$strRecursive} start ">
                    <div class="message ">
                      <span><strong>{$intPos}</strong>. {$objMessage->getText()}</span>
                        {$objMessage->showValues()}
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
                      <span title="{$objActorActual->getName()}">{$objActorActual->getName()}</span>
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
                      <span title="{$objActorActual->getName()}">{$objActorActual->getName()}</span>
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
                      <span title="{$objActorActual->getName()}">{$objActorActual->getName()}</span>
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
}

?>
