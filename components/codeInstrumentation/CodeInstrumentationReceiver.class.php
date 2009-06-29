<?php
/**
 * CodeInstrumentationReceiver create the messages receive
 * @package CodeInstrumentation
 */

/**
 * Class create to make possible the creation of code instrumentation of executions.
 * 
 * It receive the messages of enter methods and leave methods, into what object, of what class
 * and, based into this informations, create a UmlSequenceDiagram object.
 * 
 * The uml sequence diagram object created, can be used for many ways, since create a xml, create a
 * diagram file, etc. as the printers avaliable of it.
 * 
 * @todo make filter methods to reduce the diagram of big executions
 * 
 * @see CodeInstrumentationMethod
 * @see CodeInstrumentationClass
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class CodeInstrumentationReceiver implements UmlSequenceDiagramFactoryInterface
{
	/**
	 * singletoon of the CodeInstrumentationReceiver
	 * 
	 * @var CodeInstrumentationReceiver
	 */
    static $objCodeInstrumentationReceiver;

    /**
     * param if the null return should be saved as a message
     * into the uml sequence diagram object
     * 
     * @var boolean
     */
    protected $booIgnoreNullReturns = true;
    
    /**
     * param if the recursive call should be ignored into
     * the uml sequence diagram object
     * 
     * @var boolean
     */
    protected $booIgnoreRecursiveCalls = false;
    
    /**
     * param of control if the messages between objects
     * of the same class should be saved into the uml
     * sequence diagram object as recursive calls into
     * the same object
     * 
     * @var boolean
     */
    protected $booMergeSameClassObjects = false;
    
    /**
     * stack of actors into the execution pile
     * 
     * @var UmlSequenceActor[]
     */
    protected $arrStack = array();

    /**
     * array with all the actors existents into the execution
     * 
     * @var UmlSequenceActor[]
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
     * @var UmlSequenceMessage[]
     */
    protected $arrMessages = array();

    /**
     * Gate keeper of the classes into the diagram
     *
     * @var MatchGatekeeper
     */
    protected $objGatekeeperClasses;

    /**
     * Gate keeper of the methods into the diagram
     *
     * @var MatchGatekeeper
     */
    protected $objGatekeeperMethods;

    /**
     * Object of the uml sequence diagram what will be feed into the execution
     * 
     * @var UmlSequenceDiagram
     */
    protected $objUmlSequence = null;

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
     * Set the configuration paramenter if the code instrumentation should merge same
     * class objects as one actor.
     *
     * @see CodeInstrumentationReceiver->booMergeSameClassObjects
     * @see CodeInstrumentationReceiver::getMergeSameClassObjects()
     * @param $booMergeSameClassObjects <code>true</code> if should should merge 
     * same class object
     * @return CodeInstrumentationReceiver me
     */
    public function setMergeSameClassObjects( $booMergeSameClassObjects )
    {
    	$this->booMergeSameClassObjects = $booMergeSameClassObjects;
    	return $this;
    }

    /**
     * get the configuration paramenter if the code instrumentation should merge same
     * class objects as one actor.
     *
     * @see CodeInstrumentationReceiver->booMergeSameClassObjects
     * @see CodeInstrumentationReceiver::setMergeSameClassObjects( boolean )
     * @return boolean <code>true</code> if should merge same class object
     */
    public function getMergeSameClassObjects()
    {
    	return $this->booMergeSameClassObjects;
    }

    /**
     * Set the gate keeper to the classes into the diagram
     * 
     * @param MatchGatekeeper $objGatekeeperClasses
     */
    public function setGatekeeperClasses( MatchGatekeeper $objGatekeeperClasses )
    {
        $this->objGatekeeperClasses = $objGatekeeperClasses;
    }

    /**
     * Get the gate keeper to the classes into the diagram
     *
     * @return MatchGatekeeper
     */
    public function getGatekeeperClasses()
    {
        return $this->objGatekeeperClasses;
    }

    /**
     * Set the gate keeper to the classes into the method
     *
     * @param MatchGatekeeper $objGatekeeperMethods
     */
    public function setGatekeeperMethods( MatchGatekeeper $objGatekeeperMethods )
    {
        $this->objGatekeeperMethods = $objGatekeeperMethods;
    }

    /**
     * Get the gate keeper to the classes into the method
     *
     * @return MatchGatekeeper $objGatekeeperMethods
     */
    public function getGatekeeperMethods()
    {
        return $this->objGatekeeperMethods;
    }

    /**
     * prepare the code instrumentation receiver to start to receive the informations about
     * the execution.
     * 
     * @plan{
     * <ol>
     *     <li> create the internal objects </li>
     *     <li> create the uml sequence diagram object </li>
     *     <li> create the user actor </li>
     * </ol>
     * }
     * 
     * @return null
     */
    public function __construct()
    {
        // create the internal objects //
        $objGatekeeperClasses = new MatchGatekeeper();
        $this->setGatekeeperClasses( $objGatekeeperClasses );

        $objGatekeeperMethods = new MatchGatekeeper();
        $this->setGatekeeperMethods( $objGatekeeperMethods );

    	// create the uml sequence diagram object //
        $this->objUmlSequence = new UmlSequenceDiagram();

        // create the user actor //	
        $objActorFrom = new UmlSequenceDiagramActor();
        $objActorFrom->setType( 'user' );
        $objActorFrom->setName( "user" );
        $objActorFrom->setId( sizeof( $this->arrActors ) + 1 );
        $this->arrActors[] = $objActorFrom;
        $this->arrStack[] = $objActorFrom;
        $this->objUmlSequence->addActor($objActorFrom);
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
     * @plan{
     * <ol>
     *     <li> if __construct replace by &gt;&gt;create&lt;&lt; </li>
     *     <li> if __destruct replace by &gt;&gt;destroy&lt;&lt; </li>
     *     <li> other cases should append the "()" </li>
     * </ol>
     * }
     *
     * @param string $strMethod old method name
     * @return string new method name
     */
    public function renameMethod( $strMethod , $strClass )
    {
        switch( $strMethod )
        {
        	// 1. if __construct replace by <<create>> //
            case "__construct":
            {
                $strMethod = ( "<<create>>" );
                break;
            }
            // 2. if __destruct replace by <<destroy>> //
            case "__destruct":
            {
                $strMethod = ( "<<destroy>>" );
                break;
            }
            // 3. other cases should append the "()" //
            default:
            {
                $objReflectedClass = new CodeReflectionClass( $strClass );
                $objReflectedMethod = $objReflectedClass->getMethod( $strMethod );
                $arrReflectedParameter = $objReflectedMethod->getParameters();
                $arrParams = array();
                foreach( $arrReflectedParameter as $objReflectedParameter )
                {
                    $arrParams[] = $objReflectedParameter->getCode();
                }
                $strMethod .= "( " . implode( " , " , $arrParams ) . " )";
                break;
            }
        }
        return $strMethod;
    }

    /**
     * Check if the method should be loged into the uml sequence diagram
     * 
     * @param String $strClass
     * @param String $strMethod
     * @return boolean
     */
    protected function shouldBeLog( $strClass , $strMethod )
    {
        if( $this->getGatekeeperClasses()->match( $strClass ) == false )
        {
            return false;
        }

        // returns of it is a ignored method
        if( $this->getGatekeeperMethods()->match( $strMethod ) == false )
        {
            return false;
        }
        
        return true;
    }
    
    /**
     * Receive a message of enter into some method and append it as a uml sequence diagram message
     * into the uml sequence diagram object, creating if necessary the uml sequence diagram actor
     * 
     * @plan{
     * <ol>
     *     <li> get the name of method as the diagram standart </li>
     *     <li> get the namespace name </li>
     *     <li> get the actor what the message is bring from </li>
     *     <li> get the actor what the message is bring to
     *          <ol>
     *              <li> create the actor to if he not exists </li>
     *          </ol>
     *     </li>
     *     <li> create the message
     *          <ol>
     *              <li> set the message attributes </li>
     *              <li> set the message values </li>
     *          </ol>
     *     </li>
     *     <li> append the message </li>
     * </ol>
     * }
     * 
     * @param string $uid
     * @param string $strClassDefinition
     * @param string $strMethod
     * @param Array $arrArguments
     * @return CodeInstrumentationReceiver me
     */
    public function onEnterMethod( $uid , $strClassDefinition , $strMethod, $arrArguments )
    {
    	// get the name of method as the diagram standart //
        $strClass 		= CorujaClassManipulation::getClassNameFromClassDefinition( $strClassDefinition );
        $arrMethod      = explode( "::" , $strMethod );
        $strRealMethod 	= array_pop( $arrMethod );
        $strMethod      = $this->renameMethod( $strRealMethod , $strClass);

        // get the namespace name //
        $strNamespace 	= CorujaClassManipulation::getNamespaceFromClassDefinition( $strClassDefinition );

        if( ! array_key_exists( $strClass, $this->arrClasses ) )
        {
            $this->arrClasses[ $strClass ] = 0;
        }
        
         // apply receiver configurations
        if( $this->getMergeSameClassObjects() )
        {
            $uid = $strClass;
        }        

        if( ! $this->shouldBeLog( $strClass , $strRealMethod ) )
        {
        	return $this;
        }
        
        // get the actor what the message is bring from  //
        $objActorFrom = current( $this->arrStack );
        if( $objActorFrom  === false )
        {
            return $this;
        }

        // get the actor what the message is bring to //
        if( ! array_key_exists( $uid , $this->arrActors ) )
        {
        	// create the actor to if he not exists //
            $this->arrClasses[ $strClass ]++;
            $objActorTo = new UmlSequenceDiagramActor();
            $objActorTo->setType( 'system' );
            $objActorTo->setClassName($strClass);

            // object counter by class only make sence when has more the one
            // object of the same class
            if( $this->getMergeSameClassObjects() )
            {
	            $objActorTo->setName( $strClass );
            }
            else
            {
	            $objActorTo->setName( $strClass . '(' . $this->arrClasses[ $strClass ] . ')');
            }
            
            $objActorTo->setId(sizeof( $this->arrActors ) + 1  );
            $this->arrActors[ $uid ] = $objActorTo;
            $this->objUmlSequence->addActor($objActorTo);
        }
        else
        {
            $objActorTo = $this->arrActors[ $uid ];
        }
        
        if( !$this->getIgnoreRecursiveCalls() || ( $objActorFrom != $objActorTo ) )
        {
            // create the message //
            $objMessage = new UmlSequenceDiagramMessage();

            // set the message attributes //
            $objMessage->setMethod( $strRealMethod );
            $objMessage->setText( $strMethod );
            $objMessage->setActorFrom( $objActorFrom );
            $objMessage->setActorTo( $objActorTo );
            $objMessage->setType( 'call' );

            $objReflectedClass = new CodeReflectionClass( $strClass );
            $objReflectedMethod = $objReflectedClass->getMethod( $strRealMethod );
            $arrReflectedParameter = $objReflectedMethod->getParameters();

            // set the message values //
            foreach( $arrArguments as $intPos => $mixValue )
            {
                $objValue = new UmlSequenceDiagramValue();
                $objReflectedParameter = $arrReflectedParameter[ $intPos ];
                $strName = $objReflectedParameter->getName();
                $objValue->setName( $strName );
                $objValue->setValue( $mixValue );
                $objMessage->addValue( $objValue );
            }
            $objMessage->setTimeStart( microtime( true ) );

            // append the message  //
            $this->objUmlSequence->addMessage( $objMessage );
            $this->arrMessages[] 	= $objMessage;
        }
        
        array_unshift( $this->arrStack , $objActorTo );
        return $this;
    }

    /**
     * Receive the message of leave some method and append it message into the uml sequence diagram object
     *
     * @plan{
     * <ol>
     *     <li> get the name of method as the diagram standart </li>
     *     <li> get the namespace name </li>
     *     <li> get the actor what the message is bring from </li>
     *     <li> get the actor what the message is bring to </li>
     *     <li>
     *         create the message
     *         <ol>
     *             <li> set the message attributes </li>
     *             <li> set the message values </li>
     *         </ol>
     *     </li>
     *     <li> append the message </li>
     * </ol>
     * }
     * 
     * @param integer $uid
     * @param string $strClassDefinition
     * @param string $strMethod
     * @param $mixReturn
     * @return CodeInstrumentationReceiver me
     */
    public function onLeaveMethod( $uid , $strClassDefinition, $strMethod, $mixReturn )
    {
    	// get the name of method as the diagram standart //
        $strClass 		= CorujaClassManipulation::getClassNameFromClassDefinition( $strClassDefinition );
        $arrMethod      = explode( "::" , $strMethod );
        $strRealMethod	= array_pop( $arrMethod );
        $strMethod      = $this->renameMethod( $strRealMethod , $strClass );

        // get the namespace name //
        $strNamespace 	= CorujaClassManipulation::getNamespaceFromClassDefinition( $strClassDefinition );

            if( ! $this->shouldBeLog( $strClass , $strRealMethod ) )
        {
        	return $this;
        }
                
        // get the actor what the message is bring from //
        $objActorFrom = array_shift( $this->arrStack );
        
        // get the actor what the message is bring to //
        $objActorTo = current( $this->arrStack );

        $boolCreateMessage = true;

        if( $mixReturn == null and $this->getIgnoreNullReturns() )
        {
            $boolCreateMessage = false;
        }

        if( ( $objActorFrom == $objActorTo ) and $this->getIgnoreRecursiveCalls() )
        {
            $boolCreateMessage = false;
        }

        if( $boolCreateMessage )
        {
        	// create the message //
            $objMessage = new UmlSequenceDiagramMessage();
            
            // set the message attributes //
            $objMessage->setMethod( $strRealMethod );
            $objMessage->setText( $strMethod );
            $objMessage->setActorFrom( $objActorFrom );
            $objMessage->setActorTo( $objActorTo );
            $objMessage->setType( 'return' );

            // set the message values //
            if( $mixReturn !== null )
            {
                $objValue = new UmlSequenceDiagramValue();
                $objValue->setName( "return" );
                $objValue->setValue( $mixReturn );
                $objMessage->addValue( $objValue );
            }

            // append the message  //
            $this->objUmlSequence->addMessage( $objMessage );
            $objMessage->setTimeEnd( microtime( true ) );
        }
        return $this;
    }

    /**
     * Return the uml sequence diagram Object what the Code Instrumentation Receiver feeds
     *
     * @see CodeInstrumentationReceiver->objUmlSequence
     * @see CodeInstrumentationReceiver::setUmlSequenceDiagram( UmlSequenceDiagram )
     * @return UmlSequenceDiagram
     */
    public function getUmlSequenceDiagram()
    {
        return $this->objUmlSequence;
    }

    /**
     * Set the uml sequence diagram Object what the Code Instrumentation Receiver feeds
     *
     * @param UmlSequenceDiagram
     * @see CodeInstrumentationReceiver->objUmlSequence
     * @see CodeInstrumentationReceiver::getUmlSequenceDiagram()
     * @return CodeInstrumentationReceiver me
     */
    public function setUmlSequenceDiagram( UmlSequenceDiagram $objUmlSequence )
    {
        $this->objUmlSequence = $objUmlSequence;
        return $this;
    }

    /**
     * Clean the attributes of the uml sequence diagram existing
     * 
     * <ol>
     *     <li> clean actors </li>
     *     <li> clean classes </li>
     *     <li> clean messages </li>
     *     <li> clean stack </li>
     *     <li> clean object uml sequence diagram </li>
     *     <li> restart the receiver </li>
     * </ol>
     * 
     * @return CodeInstrumentationReceiver
     */
    public function restart()
    {
    	// clean actors //
        $this->arrActors = array();
        // clean classes //
        $this->arrClasses = array();
        // clean messages //
        $this->arrMessages = array();
        // clean stack //
        $this->arrStack = array();
        // clean object uml sequence diagram //
        $this->objUmlSequence->restart();
        // restart the receiver //
        $this->__construct();
        return $this;
    }

    /**
     * Return the UmlSequenceDiagram created by this factory
     *
     * @return UmlSequenceDiagram
     */
    public function perform()
    {
        return $this->getUmlSequenceDiagram();
    }
}

?>