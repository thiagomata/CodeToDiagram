<?php

/**
 * Class whith a group of rules what a regular expression can be
 * match and be considered valid or invalid into this match
 *
 * @autor Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 2009-14-12
 * @package RuleMach
 *
 */
class RuleRegularExpressionMatch
{
    /**
     * Array with the string RegularExpression list
     * what should be match
     *
     * If is empty, anyone can enter.
     *
     * @var string[]
     */
    protected $arrRegularExpressionList = array();

    /**
     * array with the values of the match if founded
     * 
     * @var array 
     */
    protected $arrValueList = array();

    /**
     * value of the match when the element not be found
     * into the RegularExpression list
     *
     * @default false
     * @var mixer 
     */
    protected $mixNotFoundedValue = FALSE;

    /**
     * Set the not founded value
     *
     * @see RuleRegularExpressionMatch->mixNotFoundedValue
     * @see RuleRegularExpressionMatch::getNotFoundValue()
     * @param mixer $mixNotFoundedValue
     * @return RuleRegularExpressionMatch
     */
    public function setNotFoundValue( $mixNotFoundedValue )
    {
        $this->mixNotFoundedValue = $mixNotFoundedValue;
        return $this;
    }

    /**
     * Get the not founded value
     *
     * @see RuleRegularExpressionMatch->mixNotFoundedValue
     * @see RuleRegularExpressionMatch::setNotFoundValue( mixer )
     * @return mixer $mixNotFoundedValue
     */
    public function getNotFoundedValue()
    {
        return $this->mixNotFoundedValue;
    }

    /**
     * Set the array with the RegularExpression list into the match
     *
     * @see RuleMatchList->arrRegularExpressionList
     * @see RuleMatchList::getRegularExpressionList()
     * @param String[] $arrRegularExpressionList
     * @return RuleRegularExpressionMatch me
     */
    public function setRegularExpressionList( $arrRegularExpressionList )
    {
    	$this->arrRegularExpressionList = $arrRegularExpressionList;
    	return $this;
    }

    /**
     * get the array with the RegularExpression list into the match
     *
     * @see RuleMatchList->arrRegularExpressionList
     * @see RuleMatchList::setRegularExpressionList( String[] )
     * @return String[] $arrRegularExpressionList
     */
    public function getRegularExpressionList()
    {
    	return $this->arrRegularExpressionList;
    }

    /**
     * Add a class RegularExpression into the RegularExpression list
     *
     * @see RuleMatchList->arrRegularExpressionList
     * @see RuleMatchList::setRegularExpressionList( String[] )
     * @see RuleMatchList::getRegularExpressionList()
     * @param string $strRegularExpression
     * @return RuleRegularExpressionMacth me
     */
    public function addRegularExpression( $strRegularExpression , $mixValue = TRUE )
    {
        $intKeyRegularExpression = sizeof( $this->arrRegularExpressionList );
    	$this->arrRegularExpressionList[ $intKeyRegularExpression ] = $strRegularExpression;
        $this->arrValueList[ $intKeyRegularExpression ] = $mixValue;
    	return $this;
    }

    /**
     * Search the element into the array and returns true if founded
     * and false if not
     *
     * @param string $strRegularExpression
     * @return boolean
     */
    public function found( $strRegularExpression )
    {
        if ( in_array( $strRegularExpression , $this->arrRegularExpressionList ) )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Match the string RegularExpression
     *
     * @param string $strRegularExpression
     * @return boolean
     */
    public function match( $strName )
    {
        $intKeyFound = FALSE;
        foreach( $this->arrRegularExpressionList  as $intRegularExpressionKey => $strRegularExpression )
        {
            if( ereg( $strRegularExpression , $strName ) )
            {
                $intKeyFound = $intRegularExpressionKey;
            }
        }
        
        if( $intKeyFound !== FALSE )
        {
            $mixReturn = $this->arrValueList[ $intKeyFound ];
        }
        else
        {
            $mixReturn = $this->getNotFoundedValue();
        }
        return $mixReturn;
    }
}
?>
