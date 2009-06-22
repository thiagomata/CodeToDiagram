<?php
/**
 * MatchInterface - Define the behavior of one match
 * @package Match
 */

/**
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 2009-06-16
 *
 * Define the behavior of one match
 *
 * One match implementation deal with names \<name\> and with values \<value\>.
 *
 * What value the match method MatchInterface::match() will returns it is
 * customizable to each implementation of this interface.
 *
 * When MatchInterface::found() method be called, the class should returns
 * <code> true </code>, when the matching process be successfuly or
 * <code> false </code>, otherwise.
 *
 * When MatchInterface::match() method be called, the matching process should
 * return the value of the matching sucessfuly process.
 *
 * Case, the received name be unable to match sucessfuly, the
 * MatchInterface::match() should return the NotFoundValue informed into
 * the MatchInterface::setNotFoundValue().
 *
 */
interface MatchInterface
{
    /**
     * Set the not found value.
     *
     * Changing this value will change how the result
     * of the match() method when not item match with
     * the received name
     *
     * @implements MatchInterface::match( \<name\> object )
     * @see MatchInterface::setNotFoundValue( \<value\> object )
     * @param object <value> $objNotFoundValue
     * @return MatchInterface me
     */
    public function setNotFoundValue( $objNotFoundValue );

    /**
     * Get the not found value.
     *
     * This value will be returned when the name received
     * don't match with any element into the item list in
     * the match() method
     *
     * @implements MatchInterface::getNotFoundValue()
     * @see MatchInterface::match( <name> object )
     * @return object \<value\>
     */
    public function getNotFoundValue();

    /**
     * Match the name received and
     * returns <code> true </code>
     * if successfully match or
     * <code> false </code> otherwise.
     *
     * @implements MatchInterface::found( \<name\> object )
     * @param object <name> $objName
     * @return boolean
     */
    public function found( $objName );
 
    /**
     *  When MatchInterface::match() method be called, the matching process should
     * return the \<value\> of the matching sucessfuly process.
     *
     * Case, the received \<name\> be unable to match sucessfuly, the
     * MatchInterface::match() should return the NotFoundValue informed into
     * the MatchInterface::setNotFoundValue().
     *
     * @implements MatchInterface::match( \<name\> object )
     * @see MatchInterface::getNotFoundValue()
     * @param object <name> $objName
     * @return object \<value\>
     */
    public function match( $objName );
}

?>
