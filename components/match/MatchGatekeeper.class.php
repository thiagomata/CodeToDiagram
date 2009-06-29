<?php
/**
 * MatchGatekeeper - Gate opener make a match using white list and black list.
 * @package Match
 */

/**
 * @autor Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 2009-06-12
 *
 * Gate opener make a match using white list , with the allowed names
 * and black list, with the forbiden names.
 *
 * @example{
 *   $objMatch = new MatchGatekeeper();
 *   $objMatch->getAllowedMatch()->addItemName( "just" );
 *   $objMatch->getAllowedMatch()->addItemName( "us" );
 * 	 if ( $objMatch->match( "other" ) !== false ) return false;
 *   return true;
 * }
 *
 * @example{
 *   $objMatch = new MatchGatekeeper();
 *   $objMatch->getForbiddenMatch()->addItemRegularExpression( "^set*" );
 *   $objMatch->getForbiddenMatch()->addItemRegularExpression( "^get*" );
 *   $objMatch->getForbiddenMatch()->addItemName( "play" );
 *	 if ( $objMatch->match( "setSomething" ) !== false ) return false;
 *	 if ( $objMatch->match( "getSomething" ) !== false ) return false;
 *	 if ( $objMatch->match( "play" ) !== false ) return false;
 *	 if ( $objMatch->match( "other" ) !== true) return false;
 *   return true;
 * }
 *
 */
class MatchGatekeeper implements MatchInterface
{
    /**
     * Match Group of the Forbidden List
     *
     * @var MatchGroup
     */
    protected $objForbidenMatch;

    /**
     * Match Group of the Allowed List
     *
     * @var MatchGroup
     */
    protected $objAllowedMatch;

    /**
     * Value what should return when the name dont match
     * with the allowed list even with the forbiden list
     *
     * @var object <value>
     */
    protected $objNotFoundValue = true;

    /**
     * Value what should return when the name match
     * into the forbiden list
     */
    protected $objDeniedValue = false;

    /**
     * constructor create the class matchs
     */
    public function __construct()
    {
        $this->objForbidenMatch = new MatchGroup();
        $this->objAllowedMatch = new MatchGroup();
    }

    /*
     * set the forbiden list match
     *
     * @param Match $objForbidenMatch
     * @return MatchGatekeeper me
     */
    public function setForbidenMatch( Match $objForbidenMatch )
    {
        $this->objForbidenMatch = $objForbidenMatch;
        return $this;
    }

    /**
     * get the forbiden list match
     *
     * @return MatchGroup
     */
    public function getForbiddenMatch()
    {
        return $this->objForbidenMatch;
    }

    /**
     * Set the allowed list match
     *
     * @param Match $objAllowedMatch
     * @return MatchGatekeeper me
     */
    public function setAllowedMatch( Match $objAllowedMatch )
    {
        $this->objAllowedMatch = $objAllowedMatch;
        return $this;
    }

    /**
     * Get the allowed list match
     *
     * @return MatchGroup
     */
    public function getAllowedMatch()
    {
        return $this->objAllowedMatch;
    }

    /**
     * Set the value what should be return when the name
     * not be found into any list
     *
     * @param object <value> $objValue
     * @return MatchGatekeeper
     */
    public function setNotFoundValue( $objValue )
    {
        $this->objNotFoundValue = $objValue;
        $this->getAllowedMatch->setNotFoundValue( $objValue );
        $this->getForbiddenMatch->setNotFoundValue( $objValue );
        return $this;
    }

    /**
     * Get the value what shoul be return when the name
     * not be found into any list
     *
     * @return object \<value\>
     */
    public function getNotFoundValue()
    {
        return $this->objNotFoundValue;
    }

    /**
     * Set the value of a name into the forbidden list
     *
     * @param object <value> $objValue
     * @return MatchGatekeeper
     */
    public function setDeniedValue( $objValue )
    {
        $this->objDeniedValue = $objValue;
        return $this;
    }

    /**
     * Get the value of a name into the forbidden list
     *
     * @return object \<value\>
     */
    public function getDeniedValue()
    {
        return $this->objDeniedValue;
    }

    /**
     * Match the string name
     *
     * @param string $strName
     * @return object \<value\>
     */
    public function match( $strName )
    {
        // if forbidden list exists //
        if( $this->getForbiddenMatch()->isEmpty() == false )
        {
            // if is forbidden //
            if( $this->getForbiddenMatch()->found( $strName ) )
            {
                // return denied value //
                return $this->getDeniedValue();
            }
        }
        // if allowed restriction list exists //
        if( $this->getAllowedMatch()->isEmpty() == false )
        {
            // if is allowed //
            if( $this->getAllowedMatch()->found( $strName ) )
            {
                // return the allowed value //
                return $this->getAllowedMatch()->match( $strName );
            }
            else
            {
                // else return the denied value //
                return $this->getDeniedValue();
            }
        }
        // else return the not found value //
        return $this->getNotFoundValue();
    }


    /**
     * Found the string name
     *
     * @param string $strName
     * @return object \<value\>
     */
    public function found( $strName )
    {
         // if forbidden list exists //
        if( $this->getForbiddenMatch()->isEmpty() == false )
        {
            // if is forbidden //
            if( $this->getForbiddenMatch()->found( $strName ) )
            {
                // return false //
                return false;
            }
        }
        // if allowed restriction list exists //
        if( $this->getAllowedMatch()->isEmpty() == false )
        {
            // if is allowed //
            if( $this->getAllowedMatch()->found( $strName ) )
            {
                // return true //
                return true;
            }
        }
        // the element was not founded in any list //
        return false;
    }

}
?>
