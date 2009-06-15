<?php

/**
 * Class what combine a name match with a regular expression match
 *
 * @autor Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 2009-06-12
 * @package StringMachList
 *
 */
class RuleMatch
{
    /**
     * @var RuleNameMatch
     */
    protected $objNameRuleList = null;

    /**
     *
     * @var RuleRegularExpressionMatch
     */
    protected $objRegexRuleList = null;

    public function __construct()
    {
        $this->objNameRuleList = new RuleNameMatch();
        $this->objRegexRuleList = new RuleRegularExpressionMatch();
    }

    /**
     *
     * @see RuleNameMatch::addName( string , mixer )
     * @param string $strName
     * @param mixer $mixValue
     * @return RuleMatch
     */
    public function addName( $strName , $mixValue = TRUE )
    {
        $this->objNameRuleList->addName( $strName , $mixValue );
        return $this;
    }

    /**
     * @see RuleNameMatch::setNameList( string[] )
     * @param array $arrNameList
     * @return RuleMatch
     */
    public function setNameList( $arrNameList )
    {
        $this->setNameList( $arrNameList );
        return $this;
    }

    /**
     * @see RuleNameMatch::getNameList()
     * @return string[]
     */
    public function getNameList()
    {
        return $this->getNameList();
    }


    /**
     *
     * @see RuleNameMatch::addtRegularExpression( string , mixer )
     * @param string $strtRegularExpression
     * @param mixer $mixValue
     * @return RuleMatch
     */
    public function addRegularExpression( $strtRegularExpression , $mixValue = TRUE )
    {
        $this->objRegexRuleList->addRegularExpression( $strtRegularExpression , $mixValue );
        return $this;
    }

    /**
     * @see RuleRegularExpressionMatch::setRegularExpressionList( string[] )
     * @param string[] $arrRegularExpressionList
     * @return RuleMatch
     */
    public function setRegularExpressionList( $arrRegularExpressionList )
    {
        $this->objRegexRuleList->setRegularExpressionList( $arrRegularExpressionList );
        return $this;
    }

    /**
     *
     * @see RuleRegularExpressionMatch::getRegularExpressionList()
     * @return string[]
     */
    public function getRegularExpressionList()
    {
        return $this->objRegexRuleList->getRegularExpressionList();
    }

    /**
     *
     * @see RuleNameMatch::setNotFoundValue()
     * @see RuleRegularExpressionMatch::setNotFoundValue()
     * @return RuleMatch
     */
    public function setNotFoundValue( $mixNotFoundedValue )
    {
        $this->objNameRuleList->setNotFoundValue( $mixNotFoundedValue );
        $this->objRegexRuleList->setNotFoundValue( $mixNotFoundedValue );
        return $this;
    }

    /**
     * @see RuleNameMatch::getNotFoundValue()
     * @see RuleRegularExpressionMatch::getNotFoundValue()
     * @return mixer
     */
    public function getNotFoundValue()
    {
        return $this->objNameRuleList->getNotFoundedValue();
    }

    /**
     * @see RuleNameMatch::match( string )
     * @see RuleRegularExpressionMatch::match( string )
     * @return mixer
     */
    public function match( $strName )
    {
        if( $this->objNameRuleList->found( $strName ) )
        {
            return $this->objNameRuleList->match( $strName );
        }
        if( $this->objRegexRuleList->found($strRegularExpression))
        {
            return $this->objNameRuleList->match( $strName );
        }
        return $this->getNotFoundValue();
    }
}
?>
