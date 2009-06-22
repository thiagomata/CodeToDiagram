<?php
/**
 * MatchGroup - Class what combine a name match with a regular expression match
 * @package Match
 */

/**
 * Class what combine a name match with a regular expression match
 *
 * @autor Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 2009-06-12
 *
 */
class MatchGroup implements MatchInterface
{
    /**
     * Match Name of the group
     *
     * @var MatchName
     */
    protected $objMatchName;

    /**
     * Match Regular Expression of the group
     *
     * @var MatchName
     */
    protected $objMatchRegularExpression;

    /**
     * Object to be return when the received <name> unmatch
     * in the match() method
     *
     * @var object <value> 
     */
    protected $objNotFoundValue = false;

    /**
     * constructor of the group
     */
    public function __construct()
    {
        $this->objMatchName = new MatchName();
        $this->objMatchRegularExpression = new MatchRegularExpression();
    }

    /**
     * Set the match name
     *
     * @param MatchName $objMatchName
     * @return Match
     */
    public function setMatchName( MatchName $objMatchName )
    {
        $this->objMatchName = $objMatchName;
        return $this;
    }

    /**
     * Get the match name
     *
     * @return MatchName $objMatchName
     */
    public function getMatchName()
    {
        return $this->objMatchName;
    }

    /**
     * Set the match regular expression
     *
     * @param MatchName $objMatchRegularExpression
     * @return MatchGroup
     */
    public function setMatchRegularExpression( MatchRegularExpression $objMatchName )
    {
        $this->objMatchRegularExpression = $objMatchRegularExpression;
        return $this;
    }

    /**
     * Get the match regular expression
     *
     * @return MatchName $objMatchRegularExpression
     */
    public function getMatchRegularExpression()
    {
        return $this->objMatchRegularExpression;
    }

    /**
     * Set the not found value
     *
     * @param object <value> $objValue
     * @return MatchGroup
     */
    public function setNotFoundValue( $objNotFoundValue )
    {
        $this->objNotFoundValue = $objNotFoundValue;
        $this->getMatchName()->setNotFoundValue( $objNotFoundValue );
        $this->getMatchRegularExpression()->setNotFoundValue( $objNotFoundValue );
        return $this;
    }

    /**
     * Get the not found value
     *
     * @return object <value> $objValue
     */
    public function getNotFoundValue()
    {
        return $this->objNotFoundValue;
    }

    /**
     * proxy to add item into the match name
     *
     * @param string $strItemName
     * @param object <value> $objValue
     * @return MatchGroup
     */
    public function addItemName( $strItemName , $objValue = null )
    {
        $this->getMatchName()->addItem( $strItemName , $objValue );
        return $this;
    }

    /**
     * proxy to add item into the match regular expression
     *
     * @param string $strItemRegex
     * @param object <value> $objValue
     * @return MatchGroup
     */
    public function addItemRegularExpression( $strItemRegex , $objValue = null )
    {
        $this->getMatchRegularExpression()->addItem( $strItemRegex , $objValue );
        return $this;
    }

    /**
     * Match the string name
     * 
     * @see MatchName::match( string )
     * @see MatchRegularExpression::match( string )
     * @return object \<value\>
     */
    public function match( $strName )
    {
        if( $this->getMatchName()->found( $strName ) )
        {
            return $this->getMatchName()->match( $strName );
        }
        if( $this->getMatchRegularExpression()->found( $strName ) )
        {
            return $this->getMatchRegularExpression()->match( $strName );
        }
        return $this->getNotFoundValue();
    }

    /**
     * Found the name into the match group
     *
     * @param string $strName
     * @return boolean
     */
    public function found( $strName )
    {
        return
        (
            ( $this->getMatchName()->found( $strName ) )
        ||
            ( $this->getMatchRegularExpression()->found( $strName ) )
        );
    }

    /**
     * Inform if the match inside the group are empty
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return
        (
            ( $this->getMatchName()->isEmpty() )
        &&
            ( $this->getMatchRegularExpression()->isEmpty() )
        );
    }
}
?>
