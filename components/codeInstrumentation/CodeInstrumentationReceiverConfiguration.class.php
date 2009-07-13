<?php
/**
 * CodeInstrumentationReceiverConfiguration set the configurations to the code
 * instrumentation receiver
 * @package CodeInstrumentation
 */

/**
 * Class to set the configurations of the code instrumentation receiver
 *
 * @since 2009-07-01
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class CodeInstrumentationReceiverConfiguration
{
    /**
     * param to control if the code instrumentation is active.
     * Can be changed in execution time to ignore some slice
     * of the execution.
     * 
     * @example{
     *  // logged code //
     *  $this->setActive( false );
     *  // not logged code //
     *  $this->setActive( true );
     *  // logged code //
     * }
     * @var boolean 
     */
    protected $booActive = true;

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
     * Match Group to define the stereotypes of the classes
     *
     * @var MatchGroup
     */
    protected $objMatchGroupStereotypes;

    /**
     * Set if the code instrumentation is active.
     *
     * @see CodeInstrumentationReceiverConfiguration->booActive
     * @see CodeInstrumentationReceiverConfiguration::getActive()
     * @param boolean $booActive <code> true </code> to be active
     * @return CodeInstrumentationReceiverConfiguration me
     */
    public function setActive( $booActive )
    {
        $this->booActive = $booActive;
        return $this;
    }

    /**
     * Get if the code instrumentation is active
     *
     * @see CodeInstrumentationReceiverConfiguration->booActive
     * @see CodeInstrumentationReceiverConfiguration::setActive( boolean )
     * @return boolean <code> true </code> if is active
     */
    public function getActive()
    {
        return $this->booActive;
    }

    /**
     * Set the configuration paramenter if the code instrumentation should ignore the returns
     * messages with null value returned.
     *
     * @see CodeInstrumentationReceiverConfiguration->boolIgnoreNullReturns
     * @see CodeInstrumentationReceiverConfiguration::geIgnoreNullReturns()
     * @param boolean $booIgnoreNullReturns <code>true</code> if should ignore the null returns
     * @return CodeInstrumentationReceiverConfiguration me
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
     * @see CodeInstrumentationReceiverConfiguration->boolIgnoreNullReturns
     * @see CodeInstrumentationReceiverConfiguration::seIgnoreNullReturns( boolean )
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
     * @see CodeInstrumentationReceiverConfiguration->booIgnoreRecursiveCalls
     * @see CodeInstrumentationReceiverConfiguration::getIgnoreRecursiveCalls()
     * @param boolean $booIgnoreNullReturns <code>true</code> if should ignore the recursive calls
     * @return CodeInstrumentationReceiverConfiguration me
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
     * @see CodeInstrumentationReceiverConfiguration->booIgnoreRecursiveCalls
     * @see CodeInstrumentationReceiverConfiguration::setIgnoreRecursiveCalls( boolean )
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
     * @see CodeInstrumentationReceiverConfiguration->booMergeSameClassObjects
     * @see CodeInstrumentationReceiverConfiguration::getMergeSameClassObjects()
     * @param boolean $booMergeSameClassObjects <code>true</code> if should should merge
     * same class object
     * @return CodeInstrumentationReceiverConfiguration me
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
     * @see CodeInstrumentationReceiverConfiguration->booMergeSameClassObjects
     * @see CodeInstrumentationReceiverConfiguration::setMergeSameClassObjects( boolean )
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
     * Set the match group to the stereotype definition
     *
     * @param MatchGroup $objMatchGroupStereotypes
     */
    public function setMatchGroupStereotypes( MatchGroup $objMatchGroupStereotypes )
    {
        $this->objMatchGroupStereotypes = $objMatchGroupStereotypes;
        return $this;
    }

    /**
     * Get the match group to the stereotype definition
     *
     * @return MatchGroup
     */
    public function getMatchGroupStereotypes()
    {
        return $this->objMatchGroupStereotypes;
    }

    /**
     * Constructor of the Configuration.
     * Create the internal objects.
     *
     */
    public function __construct()
    {
        // create the internal objects //
        $objGatekeeperClasses = new MatchGatekeeper();
        $this->setGatekeeperClasses( $objGatekeeperClasses );

        $objGatekeeperMethods = new MatchGatekeeper();
        $this->setGatekeeperMethods( $objGatekeeperMethods );

        $objMatchGroupStereotypes = new MatchGroup();
        $objDefaultStereotype = UmlSequenceDiagramStereotype::getStereotypeByName( "system" );
        $objMatchGroupStereotypes->setNotFoundValue( $objDefaultStereotype );
        $this->setMatchGroupStereotypes( $objMatchGroupStereotypes );
    }

}
?>
