<?php

/**
 * Class whith a group of rules what a string can be match and be considered
 * valid or invalid into this match
 *
 * @autor Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 2009-14-12
 * @package RuleMach
 *
 */
class RuleNameMatch
{
    /**
     * Array with the string name list
     * what should be match
     *
     * If is empty, anyone can enter.
     *
     * @var string[]
     */
    protected $arrNameList = array();

    /**
     * array with the values of the match if founded
     * 
     * @var array 
     */
    protected $arrValueList = array();

    /**
     * value of the match when the element not be found
     * into the name list
     *
     * @default false
     * @var mixer 
     */
    protected $mixNotFoundedValue = FALSE;

    /**
     * Set the not founded value
     *
     * @see RuleNameMatch->mixNotFoundedValue
     * @see RuleNameMatch::getNotFoundValue()
     * @param mixer $mixNotFoundedValue
     * @return RuleNameMatch
     */
    public function setNotFoundValue( $mixNotFoundedValue )
    {
        $this->mixNotFoundedValue = $mixNotFoundedValue;
        return $this;
    }

    /**
     * Get the not founded value
     *
     * @see RuleNameMatch->mixNotFoundedValue
     * @see RuleNameMatch::setNotFoundValue( mixer )
     * @return mixer $mixNotFoundedValue
     */
    public function getNotFoundedValue()
    {
        return $this->mixNotFoundedValue;
    }

    /**
     * Set the array with the name list into the match
     *
     * @see RuleMatchList->arrNameList
     * @see RuleMatchList::getNameList()
     * @param String[] $arrNameList
     * @return RuleNameMatch me
     */
    public function setNameList( $arrNameList )
    {
    	$this->arrNameList = $arrNameList;
    	return $this;
    }

    /**
     * get the array with the name list into the match
     *
     * @see RuleMatchList->arrNameList
     * @see RuleMatchList::setNameList( String[] )
     * @return String[] $arrNameList
     */
    public function getNameList()
    {
    	return $this->arrNameList;
    }

    /**
     * Add a class name into the name list
     *
     * @see RuleMatchList->arrNameList
     * @see RuleMatchList::setNameList( String[] )
     * @see RuleMatchList::getNameList()
     * @param string $strName
     * @return RuleNameMacth me
     */
    public function addName( $strName , $mixValue = TRUE )
    {
        $intKeyName = sizeof( $this->arrNameList );
    	$this->arrNameList[ $intKeyName ] = $strName;
        $this->arrValueList[ $intKeyName ] = $mixValue;
    	return $this;
    }

    /**
     * Search the element into the array and returns true if founded
     * and false if not
     *
     * @param string $strName
     * @return boolean
     */
    public function found( $strName )
    {
        if ( in_array( $strName , $this->arrNameList ) )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Returns if the rule is empty
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return ( sizeof( $this->arrNameList ) == 0 );
    }

    /**
     * Match the string name
     *
     * @param string $strName
     * @return boolean
     */
    public function match( $strName )
    {
        $intKeyFound = array_search( $strName , $this->arrNameList );
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
