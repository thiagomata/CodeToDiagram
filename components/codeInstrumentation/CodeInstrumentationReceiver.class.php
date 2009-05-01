<?php
/**
 * CodeInstrumentationReceiver create the messages receive
 * @package CodeInstrumentation
 */

/**
 * Class create to make possible the creation of code instrumentation of executions.
 * 
 * It receive the messages of enter methods and leave methods, into what object, of what class
 * and, based into this informations, create a xmlSequence object.
 * 
 * The xml sequence object created, can be used for many ways, since create a xml, create a 
 * diagram file, etc.
 * 
 * @todo make filter methods to reduce the diagram of big executions
 * 
 * @see CodeInstrumentationMethod
 * @see CodeInstrumentationClass
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class CodeInstrumentationReceiver
{
	/**
	 * singletoon of the CodeInstrumentationReceiver
	 * 
	 * @var CodeInstrumentationReceiver
	 */
    static $objCodeInstrumentationReceiver;

    /**
     * param if the null return should be saved as a message
     * into the xml sequence object
     * 
     * @var boolean
     */
    protected $booIgnoreNullReturns = true;
    
    /**
     * param if the recursive call should be ignored into
     * the xml sequence object
     * 
     * @var boolean
     */
    protected $booIgnoreRecursiveCalls = false;
    
    /**
     * param of control if the messages between objects
     * of the same class should be saved into the xml
     * sequence object as recursive calls into the same
     * object
     * 
     * @var boolean
     */
    protected $booMergeSameClassObjects = false;
    
    /**
     * stack of actors into the execution pile
     * 
     * @var XmlSequenceActor[]
     */
    protected $arrStack = array();

    /**
     * array with all the actors existents into the execution
     * 
     * @var XmlSequenceActor[]
     */
    protected $arrActors = array();

    /**
     * Array with the name of all the classes existents into the execution
     * 
     * @var String[]
     */
    protected $arrClasses = array();

    /**
     * Array with all the messages received into the execution
     * 
     * @var XmlSequenceMessage[]
     */
    protected $arrMessages = array();

    /**
     * Object of the xml sequence what will be feed into the execution
     * 
     * @var XmlSequence
     */
    protected $objXmlSequence = null;

    /**
     * Set the configuration paramenter if the code instrumentation should ignore the returns
     * messages with null value returned.
     * 
     * @see CodeInstrumentationReceiver->boolIgnoreNullReturns
     * @see CodeInstrumentationReceiver::geIgnoreNullReturns()
     * @param $booIgnoreNullReturns <code>true</code> if should ignore the null returns
     * @return CodeInstrumentationReceiver me
     */
    public function setIgnoreNullReturns( $booIgnoreNullReturns )
    {
    	$this->booIgnoreNullReturns = $booIgnoreNullReturns;
    	return $this;
    }
    
    /**
     * get the configuration paramenter if the code instrumentation should ignore the returns
     * messages with null value returned.
     * 
     * @see CodeInstrumentationReceiver->boolIgnoreNullReturns
     * @see CodeInstrumentationReceiver::seIgnoreNullReturns( boolean )
     * @return boolean <code>true</code> if should ignore the null returns
     */
    public function getIgnoreNullReturns()
    {
    	return $this->booIgnoreNullReturns;
    }
    
    /**
     * Set the configuration paramenter if the code instrumentation should ignore the recursive
     * messages.
     * 
     * @see CodeInstrumentationReceiver->booIgnoreRecursiveCalls
     * @see CodeInstrumentationReceiver::getIgnoreRecursiveCalls()
     * @param $booIgnoreNullReturns <code>true</code> if should ignore the recursive calls
     * @return CodeInstrumentationReceiver me
     */
    public function setIgnoreRecursiveCalls( $booIgnoreRecursiveCalls )
    {
    	$this->booIgnoreRecursiveCalls = $booIgnoreRecursiveCalls;
    	return $this;
    }
    
    /**
     * get the configuration paramenter if the code instrumentation should ignore the recursive
     * messages.
     * 	
     * @see CodeInstrumentationReceiver->booIgnoreRecursiveCalls
     * @see CodeInstrumentationReceiver::setIgnoreRecursiveCalls( boolean )
     * @param $booIgnoreNullReturns <code>true</code> if should ignore the null returns
     * @return boolean <code>true</code> if should ignore the recursive calls
     */
    public function getIgnoreRecursiveCalls()
    {
    	return $this->booIgnoreRecursiveCalls;
    }
   
    /**
     * Set the caller path of the xml sequence of the code instrumentation receiver
     * 
     * @see XmlSequence::setCallerPath
     * @param string $strCallerPath
     * @return CodeInstrumentationReceiver me
     */
    public function setCallerPath( $strCallerPath )
    {
    	$this->objXmlSequence->setCallerPath( $strCallerPath );
    	return $this;
    }
    
    /**
     * Get the caller path of the xml sequence of the code instrumentation receiver
     * 
     * @see XmlSequence::getCallerPath
     * @return string
     */
    public function getCallerPath()
    {
    	return $this->objXmlSequence->getCallerPath();	
    }
    
    /**
     * Set the public path of the xml sequence of the code instrumentation receiver
     * 
     * @see XmlSequence::setPublicPath
     * @param string $strPublicPath
     * @return CodeInstrumentationReceiver me
     */
    public function setPublicPath( $strPublicPath )
    {
    	$this->objXmlSequence->setPublicPath( $strPublicPath );
    	return $this;
    }
    
    /**
     * Get the public path of the xml sequence of the code instrumentation receiver
     * 
     * @see XmlSequence::getPublicPath
     * @return string
     */
    public function getPublicPath()
    {
    	return $this->objXmlSequence->getPublicPath();	
    }
    
    /**
     * prepare the code instrumentation receiver to start to receive the informations about
     * the execution.
     * 
     * 1. create the xml sequence object
     * 2. create the user actor
     * 
     * @return null
     */
    public function __construct()
    {
    	// 1. create the xml sequence object //
        $this->objXmlSequence = new XmlSequence();

        // 2. create the user actor //	
        $objActorFrom = new XmlSequenceActor();
        $objActorFrom->setType( 'user' );
        $objActorFrom->setName( "user" );
        $objActorFrom->setId( sizeof( $this->arrActors ) + 1 );
        $this->arrActors[] = $objActorFrom;
        $this->arrStack[] = $objActorFrom;
        $this->objXmlSequence->addActor($objActorFrom);
    }

    /**
     * 
     * Get the code instrumentation receiver singleton
     * 
     * @return CodeInstrumentationReceiver
     */
    public static function getInstance()
    {
        if( self::$objCodeInstrumentationReceiver ==  null )
        {
            self::$objCodeInstrumentationReceiver = new CodeInstrumentationReceiver();
        }
        return self::$objCodeInstrumentationReceiver;
    }

    /**
     * Rename the method to which they are in accordance
     * with the standarts of the diagram
     * 
     * 1. if __construct replace by <<create>>
     * 2. if __destruct replace by <<destroy>>
     * 3. other cases should append the "()"
     * 
     * @param string $strMethod old method name
     * @return string new method name
     */
    public function renameMethod( $strMethod )
    {
        switch( $strMethod )
        {
        	// 1. if __construct replace by <<create>> //
            case "__construct":
            {
                $strMethod = htmlentities( "<<create>>" );
                break;
            }
            // 2. if __destruct replace by <<destroy>> //
            case "__destruct":
            {
                $strMethod = htmlentities( "<<destroy>>" );
                break;
            }
            // 3. other cases should append the "()" //
            default:
            {
                $strMethod .= "()";
                break;
            }
        }
        return $strMethod;
    }

    /**
     * Receive a message of enter into some method and append it as a xml sequence message
     * into the xml sequence object, creating if necessary the xml sequence actor
     * 
     * 1. get the name of method as the diagram standart
     * 2. get the namespace name
     * 3. get the actor what the message is bring from 
     * 4. get the actor what the message is bring to
     * 4.1 create the actor to if he not exists
     * 5. create the message
     * 5.1 set the message attributes
     * 5.2 set the message values
     * 6. append the message 
     * 
     * @param string $uid
     * @param string $strClassDefinition
     * @param string $strMethod
     * @param Array $arrArguments
     * @return CodeInstrumentationReceiver me
     */
    public function onEnterMethod( $uid , $strClassDefinition , $strMethod, $arrArguments )
    {
    	// 1. get the name of method as the diagram standart //
        $strClass 		= CorujaClassManipulation::getClassNameFromClassDefinition( $strClassDefinition );
        $arrMethod      = explode( "::" , $strMethod );
        $strMethod 		= array_pop( $arrMethod );
        $strMethod      = $this->renameMethod( $strMethod );

        // 2. get the namespace name //
        $strNamespace 	= CorujaClassManipulation::getNamespaceFromClassDefinition( $strClassDefinition );

        if( ! array_key_exists( $strClass, $this->arrClasses ) )
        {
            $this->arrClasses[ $strClass ] = 0;
        }

        // 3. get the actor what the message is bring from  //
        $objActorFrom = current( $this->arrStack );

        // 4. get the actor what the message is bring to //
        if( ! array_key_exists( $uid , $this->arrActors ) )
        {
        	// 4.1 create the actor to if he not exists //
            $this->arrClasses[ $strClass ]++;
            $objActorTo = new XmlSequenceActor();
            $objActorTo->setType( 'system' );
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

        // 5. create the message //
        $objMessage = new XmlSequenceMessage();

        // 5.1 set the message attributes //
        $objMessage->setText( $strMethod );
        $objMessage->setActorFrom( $objActorFrom );
        $objMessage->setActorTo( $objActorTo );
        $objMessage->setType( 'call' );
        
        // 5.2 set the message values //
        foreach( $arrArguments as $strName => $mixValue )
        {
            $objValue = new XmlSequenceValue();
            $objValue->setName( '[' . $strName  . ']');
            $objValue->setValue( serialize( $mixValue ) );
            $objMessage->addValue( $objValue );
        }
        $objMessage->setTimeStart( microtime( true ) );
        
        // 6. append the message  //
        $this->objXmlSequence->addMessage( $objMessage );

        $this->arrMessages[] 	= $objMessage;
        array_unshift( $this->arrStack , $objActorTo );

        return $this;
    }

    /**
     * Receive the message of leave some method and append it message into the xml sequence object
     * 
     * 1. get the name of method as the diagram standart
     * 2. get the namespace name
     * 3. get the actor what the message is bring from 
     * 4. get the actor what the message is bring to
     * 5. create the message
     * 5.1 set the message attributes
     * 5.2 set the message values
     * 6. append the message 
     * 
     * @param integer $uid
     * @param string $strClassDefinition
     * @param string $strMethod
     * @param $mixReturn
     * @return CodeInstrumentationReceiver me
     */
    public function onLeaveMethod( $uid , $strClassDefinition, $strMethod, $mixReturn )
    {
    	// 1. get the name of method as the diagram standart //
        $strClass 		= CorujaClassManipulation::getClassNameFromClassDefinition( $strClassDefinition );
        $arrMethod      = explode( "::" , $strMethod );
        $strMethod 		= array_pop( $arrMethod );
        $strMethod      = $this->renameMethod( $strMethod );
        
        // 2. get the namespace name //
        $strNamespace 	= CorujaClassManipulation::getNamespaceFromClassDefinition( $strClassDefinition );

        // 3. get the actor what the message is bring from //
        $objActorFrom = array_shift( $this->arrStack );

        // 4. get the actor what the message is bring to //
        $objActorTo = current( $this->arrStack );

        if( $mixReturn != null or !$this->booIgnoreNullReturns)
        {
        	// 5. create the message //
            $objMessage = new XmlSequenceMessage();
            
            // 5.1 set the message attributes //
            $objMessage->setText( $strMethod );
            $objMessage->setActorFrom( $objActorFrom );
            $objMessage->setActorTo( $objActorTo );
            $objMessage->setType( 'return' );

            // 5.2 set the message values //
            if( $mixReturn !== null )
            {
                $objValue = new XmlSequenceValue();
                $objValue->setName( "[return]" );
                $objValue->setValue( serialize( $mixReturn ) );
                $objMessage->addValue( $objValue );
            }

            // 6. append the message  //
            $this->objXmlSequence->addMessage( $objMessage );
            $objMessage->setTimeEnd( microtime( true ) );
        }
        return $this;
    }

    /**
     * Return the Xml Sequence Object what the Code Instrumentation Receiver feeds
     * 
     * @return XmlSequence
     */
    public function getXmlSequence()
    {
        return $this->objXmlSequence;
    }

    /**
     * Clean the attributes of the xml sequence existing
     * 
     * 1. clean actors
     * 2. clean classes
     * 3. clean messages
     * 4. clean stack
     * 5. clean object xml sequence
     * 6. restart the receiver
     * 
     * @return CodeInstrumentationReceiver
     */
    public function restart()
    {
    	// 1. clean actors //
        $this->arrActors = array();
        // 2. clean classes //
        $this->arrClasses = array();
        // 3. clean messages //
        $this->arrMessages = array();
        // 4. clean stack //
        $this->arrStack = array();
        // 5. clean object xml sequence //
        $this->objXmlSequence->restart();
        // 6. restart the receiver //
        $this->__construct();
        return $this;
    }
}

?>