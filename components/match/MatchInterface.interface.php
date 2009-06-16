<?php

/**
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 2009-06-16
 * @package Rule
 * @subpackage RuleMatch
 *
 * Define the behaivor of one match
 *
 * The Rule Match is feed with a Rule Match Itens, here called as "itens".
 *
 * The Itens are append to the RuleMatch to configure it. They are append into
 * it by the RuleMatchInterface::setItemList and RuleMatchInterface::addItem
 * method.
 *
 * Each iten can be compared with each name and a result boolean result can be
 * extract from this operation.
 *
 * The mode as each item interact with the name to get the result it is
 * customizable to each implementation of this interface.
 *
 * When RuleMatchInterface::found method be called, the class should compare
 * the name with each item, one by one. Case some compared item returns true,
 * the RuleMatchInterface::found method will returns true.
 *
 * When RuleMatchInterface::match method be called, the class should compare
 * the name with each item, one by one. Case some compared item returns true,
 * the RuleMatchInterface::match method will returns the value of this item,
 * receveid into the RuleMatchInterface::addItem method or into the
 * RuleMatchInterface::setItemList method. The itens should be checked into
 * the include order.
 *
 * Case, after try match the name with all the itens without success, the
 * RuleMatchInterface::match should return the NotFoundValue informed into
 * the setNotFoundValue.
 */
interface MatchInterface
{
    /**
     * Set the not founded value.
     *
     * Changing this element will change how the
     *
     * @param mixer <value> $mixNotFoundedValue
     */
    public function setNotFoundValue( $mixNotFoundedValue );

    /**
     * Get the not founded value.
     *
     * This value will be returned when the name received
     * don't match with any element into the item list
     *
     * @return mixer <value>
     */
    public function getNotFoundedValue();

    /**
     * Set the array with the item list into the match
     *
     * @see RuleMatchInterface::getItemList()
     * @param <item>[] $arrItemList
     * @param <value>[] $arrValues
     * @return RuleMatchInterface me
     * @throws RuleException
     */
    public function setItemList( array $arrItemList , $arrValues = null );

    /**
     * Get the array with the item list into the match
     *
     * @see RuleMatchInterface::getItemList()
     * @return <item>[] $arrItemList
     */
    public function getItemList();

    /**
     * Add a item into the item list
     *
     * @see RuleMatchInterface::setItemList( <item>[] )
     * @see RuleMatchInterface::getItemList()
     * @param <item> $objItem
     * @param <value> $mixValue
     * @return RuleMatchInterface me
     */
    public function addItem( $objItem , $mixValue );

    /**
     * Match the name into the item list and
     * returns <code> true </code> if some item
     * successfully match or <code> false </code>
     * if not
     *
     * @param mixer <name> $objName
     * @return boolean
     */
    public function found( $objName );
 
    /**
     * Match the string name with the list item
     * return the value of the first item what
     * match or the not found value when no
     * item match.
     *
     * @param mixer <name> $objName
     * @return mixer <value>
     */
    public function match( $objName );
}

?>