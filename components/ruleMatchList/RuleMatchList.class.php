<?php

/**
 * Class whith a group of rules what a string can be match and be considered
 * valid or invalid into this match
 *
 * @autor Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 2009-06-12
 * @package StringMachList
 *
 */
class RuleMatchList
{
    /**
     *
     * @var RuleMatch
     */
    protected $objIgnoredRuleMatch = null;

    /**
     *
     * @var RuleMatch
     */
    protected $objExclusiveRuleMatch = null;

    /**
     *
     * @var mixer 
     */
    protected $mixNotFoundValue = TRUE;

    public function __construct()
    {
        $this->objIgnoredRuleMatch = new RuleMatch();
        $this->objExclusiveRuleMatch = new ruleMatch();
    }

    /*
     *
     * @param RuleMatch $objIgnoredRuleMatch
     * @return RuleMatchList me
     */
    public function setIgnoredRuleMatch( RuleMatch $objIgnoredRuleMatch )
    {
        $this->objIgnoredRuleMatch = $objIgnoredRuleMatch;
        return $this;
    }

    /**
     *
     * @return RuleMatch
     */
    public function getIgnoredMatchList()
    {
        return $this->objIgnoredRuleMatch;
    }

    /**
     *
     * @see RuleMatch::addName( string , mixer )
     * @param string $strIgnoredName
     * @return RuleMatchList me
     */
    public function addIgnoredName( $strIgnoredName )
    {
        $this->getIgnoredMatchList()->addName( $strIgnoredName , TRUE );
        return $this;
    }

    /**
     *
     * @see RuleMatch::addRegularExpression( string , mixer )
     * @param string $strIgnoreName
     * @return RuleMatchList me
     */
    public function addIgnoredRegularExpression( $strIgnoredRegex)
    {
        $this->getIgnoredMatchList()->addRegularExpression( $strIgnoredRegex, TRUE );
        return $this;
    }


    /**
     *
     * @param RuleMatch $objExclusiveRuleMatch
     * @return RuleMatchList me
     */
    public function setExclusiveRuleMatch( RuleMatch $objExclusiveRuleMatch )
    {
        $this->objExclusiveRuleMatch = $objExclusiveRuleMatch;
        return $this;
    }

    /**
     *
     * @return RuleMatch
     */
    public function getExclusiveMatchList()
    {
        return $this->objExclusiveRuleMatch;
    }

    /**
     * add a exclusive name into the rule
     *
     * @see RuleMatch::addName( string , mixer )
     * @param string $strExclusiveName
     * @param mixer $mixValue value of the element. Beware!
     * @return RuleMatchList me
     */
    public function addExclusiveName( $strExclusiveName , $mixValue = TRUE )
    {
        $this->getExclusiveMatchList()->addName( $strExclusiveName , $mixValue);
        return $this;
    }

    /**
     *
     * @see RuleMatch::addRegularExpression( string , mixer )
     * @param string $strIgnoreName
     * @return RuleMatchList me
     */
    public function addExclusiveRegularExpression( $strExclusiveRegex )
    {
        return $this;
    }

    /**
     * Set the value what should be return when the name
     * not be found into any list
     *
     * @param mixer $mixValue
     */
    public function setNotFoundValue( $mixValue )
    {
        $this->mixNotFoundValue = $mixValue;
    }

    /**
     * Get the value what shoul be return when the name
     * not be found into any list
     *
     * @return mixer
     */
    public function getNotFoundValue()
    {
        return $this->mixNotFoundValue;
    }

    /**
     * Match the string name
     *  
     * @param string $strName
     * @return mixer 
     */
    public function match( $strName )
    {
        if( $this->getExclusiveMatchList()->isEmpty() == FALSE )
        {
            return ( $this->getExclusiveMatchList()->match( $strName ) );
        }
        else
        {
            if( $this->getIgnoredMatchList()->isEmpty() == FALSE )
            {
                if( $this->getIgnoredMatchList()->found( $strName ) )
                {
                    return FALSE;
                }
            }
        }
        return $this->getNotFoundValue();
    }
}
?>
