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
                @import "sequenceStyle.css";
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
            <div class="line">
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
                    $strHtmlMessages .=
<<<HTML
                  <div class="actor">
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
                    $strHtmlMessages .=
<<<HTML
                  <div class="actor {$objMessage->getType()}">
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
                  <div class="actor {$objMessage->getType()}">
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
