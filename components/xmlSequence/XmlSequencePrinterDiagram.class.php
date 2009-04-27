<?php
/**
 * Generate a html diagram of the xml sequence object
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @package XmlSequence
 *
 */
class XmlSequencePrinterDiagram implements XmlSequencePrinterInterface
{
	/**
	 * xml sequence object what will be print
	 * 
	 * @see XmlSequencePrinterInterface->objXmlSequence
	 * @var XmlSequence
	 */
	protected $objXmlSequence;
	
	/**
	 * Singleton of the XmlSequencePrinterDiagram
	 * 
	 * @see XmlSequencePrinterInterface::$objInstance
	 * @var XmlSequencePrinterDiagram
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
	 * Return the singleton of the XmlSequencePrinterDiagram
	 * 
	 * @see XmlSequencePrinterInterface::getInstance
	 * @return XmlSequencePrinterDiagram
	 */
	public static function getInstance()
	{
		if( self::$objInstance == null )
		{
			self::$objInstance = new XmlSequencePrinterDiagram();
		}
		return self::$objInstance;
	}
	
	/**
	 * Perfom the print process
	 *  
	 * @see XmlSequencePrinterInterface::perform( XmlSequence )
	 * @param XmlSequence $objXmlSequence
	 * @return mixer
	 */
	public function perform( XmlSequence $objXmlSequence )
	{
		$this->objXmlSequence = $objXmlSequence;
		return $this->show();	
	}


    /**
     * Set the zoom of the diagram
     * 
     * @param integer $intZoom
     * @return XmlSequence me
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
    	
    public function show()
    {
        $strHtml = '';
        $strHtml .= $this->showHeaders();
        $strHtml .= $this->showActors();
        $strHtml .= $this->showMessages();
        $strHtml .= $this->showFooter();
        return $strHtml;
    }

    /**
     * Create and return the string of the header of the html sequence diagram
     *
     * @return string
     */
    protected function showHeaders()
    {
        if( $this->objXmlSequence->getCallerPath() != null and $this->objXmlSequence->getPublicPath() != null )
        {
            $strPublicPath = CorujaStringManipulation::getRelativePath( $this->objXmlSequence->getCallerPath(), $this->objXmlSequence->getPublicPath() );
        }
        else
        {
            $strPublicPath = "./";
        }

        $intQtdActors = sizeof( $this->objXmlSequence->getActors() );
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

        $arrActors = $this->objXmlSequence->getActors();
        
        foreach( $arrActors as $objActor )
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

    /**
     * Create and return the string of the messages into the html sequence
     * diagram
     *
     * @return string
     */
    protected function showMessages()
    {
        $strHtmlMessages = '';

        $arrMessages = $this->objXmlSequence->getMessages();
        
        foreach( $arrMessages as $intKey => $objMessage )
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
            $arrActors = $this->objXmlSequence->getActors();

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
                    $strHtmlMessages .=
<<<HTML
                  <div class="actor start">
                    <div class="name">
                      <span title="{$objActorActual->getName()}">&nbsp;</span>
                    </div>
                  </div>

                  <div class="row {$objMessage->getType()} {$strReverse} {$strLarge} {$strRecursive} start ">
                    <div class="message ">
                      <span><strong>{$intPos}</strong>. {$objMessage->getText()}</span>
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
     * @param XmlSequenceMessage $objXmlMessage
     * @return string
     */
    public function showValues( XmlSequenceMessage $objXmlMessage )
    {
        $arrValues = $objXmlMessage->getValues();
        if( sizeof( $arrValues ) > 0 )
        {
            $strHtml = '<div class="parameters">';
            $strHtml .= '<ul>' . "\n";

            foreach( $arrValues as $objValue )
            {
                $strHtml .= '<li>' . "\n";
                $strHtml .= '   <strong>' . $objValue->getName() . '</strong>' . "\n";
                $strHtml .= '   ' . $objValue->getValue() . ' ' . "\n";
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
}
?>