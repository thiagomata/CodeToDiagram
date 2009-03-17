<?php

class CodeInstrumentationReceiver
{
    const IGNORE_NULL_RETURNS = true;

    static $objCodeInstrumentationReceiver;

    protected $arrStack = array();

    protected $arrActors = array();

    protected $arrClasses = array();

    protected $arrMessages = array();

    protected $objXmlSequence = null;

    public function __construct()
    {
        $this->objXmlSequence = new XmlSequence();

        $objActorFrom = new XmlSequenceActor();
        $objActorFrom->setType( 'user' );
        $objActorFrom->setName( "user" );
        $objActorFrom->setId( sizeof( $this->arrActors ) + 1 );
        $this->arrActors[] = $objActorFrom;
        $this->arrStack[] = $objActorFrom;
        $this->objXmlSequence->addActor($objActorFrom);
    }

    public static function getInstance()
    {
        if( self::$objCodeInstrumentationReceiver ==  null )
        {
            self::$objCodeInstrumentationReceiver = new CodeInstrumentationReceiver();
        }
        return self::$objCodeInstrumentationReceiver;
    }

    public function onEnterMethod( $uid , $strClassDefinition , $strMethod, $arrArguments )
    {
        $strClass 		= CorujaClassManipulation::getClassNameFromClassDefinition( $strClassDefinition );
        $arrMethod      = explode( "::" , $strMethod );
        $strMethod 		= array_pop( $arrMethod );
        $strNamespace 	= CorujaClassManipulation::getNamespaceFromClassDefinition( $strClassDefinition );

        if( ! array_key_exists( $strClass, $this->arrClasses ) )
        {
            $this->arrClasses[ $strClass ] = 0;
        }

        $objActorFrom = current( $this->arrStack );

        if( ! array_key_exists( $uid , $this->arrActors ) )
        {
            $this->arrClasses[ $strClass ]++;
            $objActorTo = new XmlSequenceActor();
            $objActorTo->setClassName($strClass);
            $objActorTo->setName( $strClass . '(' . $this->arrClasses[ $strClass ] . ')');
            $objActorTo->setId(sizeof( $this->arrActors ) + 1  );
            $this->arrActors[ $uid ] = $objActorTo;
            $this->objXmlSequence->addActor($objActorTo);
        }
        else
        {
            $objActorTo = $this->arrActors[ $uid ];
        }

        $objMessage = new XmlSequenceMessage();
        $objMessage->setText( $strMethod . '()');
        $objMessage->setActorFrom( $objActorFrom );
        $objMessage->setActorTo( $objActorTo );
        $objMessage->setType( 'call' );
        foreach( $arrArguments as $strName => $mixValue )
        {
            $objValue = new XmlSequenceValue();
            $objValue->setName( '[' . $strName  . ']');
            $objValue->setValue( serialize( $mixValue ) );
            $objMessage->addValue( $objValue );
        }

        $objMessage->setTimeStart( microtime( true ) );
        $this->objXmlSequence->addMessage( $objMessage );

        $this->arrMessages[] 	= $objMessage;
        array_unshift( $this->arrStack , $objActorTo );

    }

    public function onLeaveMethod( $uid , $strClassDefinition, $strMethod, $mixReturn )
    {
        $strClass 		= CorujaClassManipulation::getClassNameFromClassDefinition( $strClassDefinition );
        $arrMethod      = explode( "::" , $strMethod );
        $strMethod 		= array_pop( $arrMethod );
        $strNamespace 	= CorujaClassManipulation::getNamespaceFromClassDefinition( $strClassDefinition );

        $objActorFrom = array_shift( $this->arrStack );
        $objActorTo = current( $this->arrStack );

        if( $mixReturn != null or !self::IGNORE_NULL_RETURNS )
        {
            $objMessage = new XmlSequenceMessage();
            $objMessage->setText( $strMethod );
            $objMessage->setActorFrom( $objActorFrom );
            $objMessage->setActorTo( $objActorTo );
            $objMessage->setType( 'return' );

            if( $mixReturn !== null )
            {
                $objValue = new XmlSequenceValue();
                $objValue->setName( "[return]" );
                $objValue->setValue( serialize( $mixReturn ) );
                $objMessage->addValue( $objValue );
            }

            $this->objXmlSequence->addMessage( $objMessage );
            $objMessage->setTimeEnd( microtime( true ) );
        }
    }

    public function getXmlSequence()
    {
        return $this->objXmlSequence;
    }
}
?>
