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
     * @var RuleNameMatch
     */
    protected $objIgnoredNameList = null;

    /**
     *
     * @var RuleNameMatch
     */
    protected $objNameList = null;

    /**
     * Array with the string name values what should be not
     * be added into this match
     *
     * If is empty, no one will be ignored
     *
     * @var string[]
     */
    protected $arrIgnoredNameList = array();

    /**
     * Array with the regular expressions of the values
     * what should be not be added into this match
     *
     * If is empty, no one will be ignored
     *
     * @var string[]
     */
    protected $arrIgnoredRegularExpressionList = array();

    /**
     * Array with the string name list of the exclusive
     * names what should be match
     *
     * If is empty, anyone can enter.
     *
     * @var string[]
     */
    protected $arrExclusiveNameList = array();

    /**
     * Array with the string list name of the exclusive
     * regular expressions what should be match
     *
     * If is empty, anyone can enter.
     *
     * @var string[]
     */
    protected $arrExclusiveRegularExpressionList = array();

    /**
     * Set the array with the ignored list name of the match
     *
     * @see RuleMatchList->arrIgnoredNameList
     * @see RuleMatchList::getIgnoredNameList()
     * @param String[] $arrIgnoredNameList
     * @return RuleMatchList me
     */
    public function setIgnoredNameList( array $arrIgnoredNameList )
    {
    	$this->arrIgnoredNameList = $arrIgnoredNameList;
    	return $this;
    }

    /**
     * get the array with the ignored list name of the match
     *
     * @see RuleMatchList->arrIgnoredNameList
     * @see RuleMatchList::setIgnoredNameList( String[] )
     * @return String[] $arrIgnoredNameList
     */
    public function getIgnoredNameList()
    {
    	return $this->arrIgnoredNameList;
    }

    /**
     * Add a string element name into the ignore list string
     *
     * @see RuleMatchList->arrIgnoredNametString
     * @see RuleMatchList::setIgnoredListString( String[] )
     * @see RuleMatchList::getIgnoredListString()
     * @param string $strIgnoredName
     * @return RuleMatchList me
     */
    public function addIgnoredName( $strIgnoredName )
    {
    	$this->arrIgnoredNameList[] = $strIgnoredName;
    	return $this;
    }

    /**
     * Set the array with the exclusive name into the match
     *
     * @see RuleMatchList->arrExclusiveNameList
     * @see RuleMatchList::getExclusiveNameList()
     * @param String[] $arrExclusiveNameList
     * @return RuleMatchList me
     */
    public function setExclusiveNameList( $arrExclusiveNameList )
    {
    	$this->arrExclusiveNameList = $arrExclusiveNameList;
    	return $this;
    }

    /**
     * get the array with the exclusive name into the match
     *
     * @see RuleMatchList->arrExclusiveNameList
     * @see RuleMatchList::setExclusiveNameList( String[] )
     * @return String[] $arrExclusiveNameList
     */
    public function getExclusiveNameList()
    {
    	return $this->arrExclusiveNameList;
    }

    /**
     * Add a class name into the exclusive name list
     *
     * @see RuleMatchList->arrExclusiveNameList
     * @see RuleMatchList::setExclusiveNameList( String[] )
     * @see RuleMatchList::getExclusiveClasses()
     * @param string $strExclusiveName
     * @return RuleMatchList me
     */
    public function addExclusiveName( $strExclusiveName )
    {
    	$this->arrExclusiveNameList[] = $strExclusiveName;
    	return $this;
    }

    /**
     * Set the array with the Ignored Regular Expression into the match
     *
     * @see RuleMatchList->arrIgnoredRegularExpressionList
     * @see RuleMatchList::getIgnoredRegularExpressionList()
     * @param String[] $arrIgnoredRegularExpressionList
     * @return RuleMatchList me
     */
    public function setIgnoredRegularExpressionList( $arrIgnoredRegularExpressionList )
    {
    	$this->arrIgnoredRegularExpressionList = $arrIgnoredRegularExpressionList;
    	return $this;
    }

    /**
     * get the array with the Ignored Regular Expression into the match
     *
     * @see RuleMatchList->arrIgnoredRegularExpressionList
     * @see RuleMatchList::setIgnoredRegularExpressionList( String[] )
     * @return String[] $arrIgnoredRegularExpressionList
     */
    public function getIgnoredRegularExpressionList()
    {
    	return $this->arrIgnoredRegularExpressionList;
    }

    /**
     * Add a class Regular Expression into the Ignored Regular Expression list
     *
     * @see RuleMatchList->arrIgnoredRegularExpressionList
     * @see RuleMatchList::setIgnoredRegularExpressionList( String[] )
     * @see RuleMatchList::getIgnoredClasses()
     * @param string $strIgnoredRegularExpression
     * @return RuleMatchList me
     */
    public function addIgnoredRegularExpression( $strIgnoredRegularExpression )
    {
    	$this->arrIgnoredRegularExpressionList[] = $strIgnoredRegularExpression;
    	return $this;
    }

    /**
     * Set the array with the exclusive Regular Expression into the match
     *
     * @see RuleMatchList->arrExclusiveRegularExpressionList
     * @see RuleMatchList::getExclusiveRegularExpressionList()
     * @param String[] $arrExclusiveRegularExpressionList
     * @return RuleMatchList me
     */
    public function setExclusiveRegularExpressionList( $arrExclusiveRegularExpressionList )
    {
    	$this->arrExclusiveRegularExpressionList = $arrExclusiveRegularExpressionList;
    	return $this;
    }

    /**
     * get the array with the exclusive Regular Expression into the match
     *
     * @see RuleMatchList->arrExclusiveRegularExpressionList
     * @see RuleMatchList::setExclusiveRegularExpressionList( String[] )
     * @return String[] $arrExclusiveRegularExpressionList
     */
    public function getExclusiveRegularExpressionList()
    {
    	return $this->arrExclusiveRegularExpressionList;
    }

    /**
     * Add a class Regular Expression into the exclusive Regular Expression list
     *
     * @see RuleMatchList->arrExclusiveRegularExpressionList
     * @see RuleMatchList::setExclusiveRegularExpressionList( String[] )
     * @see RuleMatchList::getExclusiveClasses()
     * @param string $strExclusiveRegularExpression
     * @return RuleMatchList me
     */
    public function addExclusiveRegularExpression( $strExclusiveRegularExpression )
    {
    	$this->arrExclusiveRegularExpressionList[] = $strExclusiveRegularExpression;
    	return $this;
    }

    /**
     * Validate the string name by the rules into the match and returns true
     * if should be considered and false if should not
     *
     * @param string $strName
     * @return boolean
     */
    public function validate( $strName , $strFullName = '' )
    {
        // returns if it is into ignore list
        if(
            ( count( $this->getIgnoredNameList() ) > 0 )
             and
             (
             	( in_array( $strName , $this->getIgnoredNameList() ) )
                ||
             	( in_array( $strFullName , $this->getIgnoredNameList() ) )
             )
          )
        {
            return false;
        }

        // returns if it is not into the exclusive list
        if(
            ( count( $this->getExclusiveNameList() ) > 0 )
             and
             (
             	( ! in_array( $strName , $this->getExclusiveNameList() ) )
             	&&
             	( ! in_array( $strFullName , $this->getExclusiveNameList() ) )
             )
          )
        {
            return false;
        }

        // exists a ignore regular expression list //
        if( count( $this->getIgnoredRegularExpressionList() ) > 0 )
        {
            foreach( $this->getIgnoredRegularExpressionList() as $strRegex )
            {
                if( ereg( $strRegex , $strMethod ) || ereg( $strRegex , $strFullName ) )
                {
                    // and the method match into //
                    return false;
                }
            }
        }

        // exists a exclusive methods regular expression list //
        if( count( $this->getExclusiveRegularExpressionList() ) > 0 )
        {
            foreach( $this->getExclusiveRegularExpressionList() as $strRegex )
            {
                if( ereg( $strRegex , $strName ) || ereg( $strRegex , $strFullName ) )
                {
                    // and the element match into //
                    return true;
                }
            }
            // and the element not match into //
            return false;
        }

        // not reasons was founded to ignore this element //
        return true;
    }
}
?>
