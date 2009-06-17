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
 * The Match Class is feed with a Match Itens, here called as "itens".
 *
 * The Itens are append to the Match Class to configure it. They are append into
 * it by the MatchInterface::setItemList() and MatchInterface::addItem()
 * method.
 *
 * Each iten can be compared with each name and a boolean result must be
 * extract from this operation.
 *
 * The mode as each item interact with the name to get the result it is
 * customizable to each implementation of this interface.
 *
 * When MatchInterface::found() method be called, the class should compare
 * the name with each item, one by one. Case some compared item returns true,
 * the MatchInterface::found() method will returns true. Otherwise, the method
 * will returns false.
 *
 * When MatchInterface::match() method be called, the class should compare
 * the name with each item, one by one. Case some compared item returns true,
 * the MatchInterface::match() method will returns the value of this item, what
 * will be the default value if not informed into the MatchInterface::addItem()
 * method or into the MatchInterface::setItemList() method. The itens should
 * be checked into the include order. The last add will be the last compared.
 *
 * Case, after try match the name with all the itens without success, the
 * MatchInterface::match() should return the NotFoundValue informed into
 * the MatchInterface::setNotFoundValue().
 *
 * To know if the match has some filter, the method MatchInterface::isEmpty()
 * returns <code> true </code> if the list itens has no elements and
 * returns <code> false </code> otherwise.
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
     * @implements MatchInterface::match( <name> object )
     * @see MatchInterface::setNotFoundValue( <value> object )
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
     * @return object <value>
     */
    public function getNotFoundValue();

    /**
     * Set the default item value.
     *
     * Changing this element will change how the value of the itens <item> what
     * not informed they values into the setItemList() and addItem()
     *
     * @implements MatchInterface::setDefaultItemValue( <value> object )
     * @see MatchInterface::setItemList( <item>array [, <value>array ] )
     * @param object <value> $objNotFoundValue
     * @return MatchInterface me
     */
    public function setDefaultItemValue( $objDefaultItemValue );

    /**
     * Get the default item value.
     *
     * This value <value> what will be saved on some item <item> when
     * this setter dont inform its value
     *
     * @implements MatchInterface::getDefaultItemValue()
     * @return object <value>
     */
    public function getDefaultItemValue();

    /**
     * Set the array with the item list into the match.
     * Can receive the array with the values of each item.
     * If the array with values not received, the default value to the itens
     * will be <code> true </code>
     *
     * @implements MatchInterface::setItemList( <item>[] [ , <value>[] ])
     * @see MatchInterface::getItemList()
     * @param <item>[] $arrItemList
     * @param <value>[] $arrValues
     * @return MatchInterface me
     * @throws MatchException
     */
    public function setItemList( array $arrItemList , $arrValues = null );

    /**
     * Get the array with the item list into the match
     *
     * @implements MatchInterface::getItemList()
     * @return <item>[] $arrItemList
     */
    public function getItemList();

    /**
     * Add a item into the item list
     *
     * @implements MatchInterface::addItem( <item> object [, <value> object ])
     * @see MatchInterface::setItemList( <item>[] )
     * @see MatchInterface::getItemList()
     * @param <item> $objItem
     * @param <value> $objValue
     * @return MatchInterface me
     */
    public function addItem( $objItem , $objValue = null );

    /**
     * Returns <code> true </code> if the item list is empty
     * returns <code> false </code> if not.
     *
     * If is empty the match allways will return the not found value
     *
     * 1. read the list itens.
     * 2. check if the list is empty
     * 2.1 returns true if the list is empty
     * 2.2 returns false if the list is not empty
     *
     * @implements MatchInterface::isEmpty()
     * @return boolean
     */
    public function isEmpty();

    /**
     * Match the name into the item list and
     * returns <code> true </code> if some item
     * successfully match or <code> false </code>
     * if not
     * 
     * 1. get the item list
     * 2. for each item into the list
     * 2.1 try match the item with the name
     * 2.1.1 if match returns true
     * 3. if no item match, returns false
     *
     * @implements MatchInterface::found( <name> object )
     * @param object <name> $objName
     * @return boolean
     */
    public function found( $objName );
 
    /**
     * Match the name <name> with the list item <item>
     * return the value <value> of the first item what
     * match or the not found value when no
     * item match.
     *
     * 1. get the item list
     * 2. for each item into the list
     * 2.1 try match the item with the name
     * 2.1.1 if match returns the value of the item
     * 3. if no item match, returns the not found value
     *
     * @implements MatchInterface::match( <name> object )
     * @see MatchInterface::getNotFoundValue()
     * @see MatchInterface::getItemList()
     * @param object <name> $objName
     * @return object <value>
     */
    public function match( $objName );
}

?>