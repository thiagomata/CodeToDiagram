<?php
/**
 * MatchName - Match the string name with a string list
 * @package Match
 */

/**
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * @since 2009-06-16
 *
 * Math the string name with a string list
 *
 * The string itens are strings elements and the string name is a string.
 * The compare item and name returns true when the string it is equal the name.
 *
 * The values \<value\> start will boolean values, but is not restrict to it.
 * The not found value \<value\> by default is false.
 * The default found value \<value\> it is by default true.
 *
 *
 * @example{
 *      $objMatchName = new MatchName();
 *      $objMatchName->addItem( "Molly" );
 *      $objMatchName->addItem( "Armitage" );
 *      $objMatchName->addItem( "Wintermute" \, "machine" );
 *      $objMatchName->addItem( "Case" \, "hacker" );
 *      if ( $objMatchName->found( "Molly" ) !== true ) return false;
 *      if ( $objMatchName->match( "Molly" ) !== true ) return false;
 *      if( $objMatchName->match( "Wintermute" ) !== "machine" ) return false;
 *      if( $objMatchName->match( "Jackson" ) !== false ) return false;
 *      return true;
 * }
 * 
 */
class MatchName implements MatchListInterface
{
    /**
     * @default false
     * @var \<value\> object
     */
    protected $objNotFoundValue = false;

    /**
     * @default true
     * @var \<value\> object
     */
    protected $objDefaultItemValue = true;


    /**
     *
     * @var string[]
     */
    protected $arrItemList = array();

    /**
     *
     * @var \<value\>[]
     */
    protected $arrValues = array();

    /**
     * Set the not found value.
     *
     * Changing this value will change how the result
     * of the match() method when not item match with
     * the received name
     *
     * @implements MatchListInterface::match( \<name\> object )
     * @see MatchListInterface::setNotFoundValue( \<value\> object )
     * @see MatchName::setNotFoundValue( \<value\> object )
     * @param object <value> $objNotFoundValue
     * @return MatchName me
     */
    public function setNotFoundValue( $objNotFoundValue )
    {
        $this->objNotFoundValue = $objNotFoundValue;
    }

    /**
     * Get the not found value.
     *
     * This value will be returned when the name received
     * don't match with any element into the item list in
     * the match() method
     *
     * @implements MatchListInterface::getNotFoundValue()
     * @see MatchListInterface::match( \<name\> object )
     * @see MatchName::match( string )
     * @return object \<value\>
     */
    public function getNotFoundValue()
    {
        return $this->objNotFoundValue;
    }

    /**
     * Set the default item value.
     *
     * Changing this element will change how the value of the itens string[] what
     * not informed they values into the setItemList() and addItem()
     *
     * @implements MatchListInterface::setDefaultItemValue( \<value\> object )
     * @see MatchListInterface::setItemList( \<item\>[] [, \<value\>[] ] )
     * @see MatchName::setItemList( string[] [, \<value\>[] ] )
     * @param object <value> $objNotFoundValue
     * @return MatchName me
     */
    public function setDefaultItemValue( $objDefaultItemValue )
    {
        $this->objDefaultItemValue = $objDefaultItemValue;
        return $this;
    }

    /**
     * Get the default item value.
     *
     * This value \<value\> what will be saved on some string item when
     * this setter dont inform its value
     *
     * @implements MatchListInterface::getDefaultItemValue()
     * @return object \<value\>
     */
    public function getDefaultItemValue()
    {
        return $this->objDefaultItemValue;
    }

    /**
     * Set the array with the item list into the match.
     * Can receive the array with the values of each item.
     * If the array with values not received, the default value to the itens
     * will be <code> true </code>
     *
     * @implements MatchListInterface::setItemList( \<item\>[] [ , \<value\>[] ])
     * @see MatchListInterface::getItemList()
     * @see MatchName::getItemList()
     * @param string[] $arrItemList
     * @param <value>[] $arrValues
     * @return MatchListInterface me
     * @throws MatchException
     */
    public function setItemList( array $arrItemList , $arrValues = null )
    {
        if( $arrValues !== null )
        {
            if( sizeof( $arrValues ) !== sizeof( $arrItemList ) )
            {
                throw new MatchException( "Invalid value list to the respective item list" );
            }
        }
        else
        {
            $arrValues = array_pad( array() , null , sizeof( $arrItemList ) );
        }
        
        foreach( $arrItemList as $intKey => $objItem )
        {
            $objValue = $arrValues[ $intKey ];
            $this->addItem( $objItem , $objValue );
        }
        
        return $this;
    }

    /**
     * Get the array with the item list into the match
     *
     * @implements MatchListInterface::getItemList()
     * @return string[] $arrItemList
     */
    public function getItemList()
    {
        return $this->arrItemList;
    }

    /**
     * Add a item into the item list
     *
     * @implements MatchListInterface::addItem( \<item\> object [, \<value\> object ])
     * @see MatchListInterface::setItemList( string[] )
     * @see MatchName::setItemList( string[] )
     * @see MatchListInterface::getItemList()
     * @see MatchName::getItemList()
     * @param string $objItem
     * @param <value> $objValue
     * @return MatchListInterface me
     */
    public function addItem( $objItem , $objValue = null )
    {
        if( $objValue == null )
        {
            $objValue = $this->getDefaultItemValue();
        }
        $intItemKey = sizeof( $this->arrItemList );
        $this->arrItemList[ $intItemKey ] = (string) $objItem;
        $this->arrValues[ $intItemKey ] = $objValue;
    }

    /**
     * Returns <code> true </code> if the item list is empty
     * returns <code> false </code> if not.
     *
     * If is empty the match allways will return the not found value
     *
     * @plan{
     * <ul>
     *     <li> read the list itens.</li>
     *     <li> 
     *         check if the list is empty
     *         <ul> 
     *             <li> returns true if the list is empty </li>
     *             <li> returns false if the list is not empty </li>
     *         </ul> 
     *     </li> 
     * </ul>
     * }
     *
     * @implements MatchListInterface::isEmpty()
     * @return boolean
     */
    public function isEmpty()
    {
        return ( sizeof( $this->getItemList() ) == 0 );
    }

    /**
     * Match the name into the item list and
     * returns <code> true </code> if some item
     * successfully match or <code> false </code>
     * if not
     *
     * @plan{
     * <ul>
     *     <li> get the item list </li>
     *     <li> for each item into the list </li>
     *     <li> 
     *         try match the item with the name
     *         <ul>  
     *             <li> if match returns true  </li>
     *             <li> if no item match\, returns false </li>
     *         </ul>
     *     </li>
     * </ul>
     * }     
     *
     * @implements MatchListInterface::found( \<name\> object )
     * @param string $objName
     * @return boolean
     */
    public function found( $objName )
    {
        $strName = (string) $objName;
        return in_array( $strName , $this->getItemList() );
    }

    /**
     * Match the string name with the list string item 
     * return the value \<value\> of the first item what
     * match or the not found value when no
     * item match.
     *
     * @plan{
     * <ul>
     *     <li> get the item list </li>
     *     <li> for each item into the list </li>
     *     <li> 
     *         try match the item with the name
     *         <ul>  
     *             <li> if match returns the value of the item  </li>
     *             <li> if no item match\, returns the not found value </li>
     *         </ul>
     *     </li>
     * </ul>
     * }   
     *
     * @implements MatchListInterface::match( \<name\> object )
     * @see MatchListInterface::getNotFoundValue()
     * @see MatchName::getNotFoundValue()
     * @see MatchListInterface::getItemList()
     * @see MatchName::getItemList()
     * @param string $objName
     * @return object \<value\> 
     */
    public function match( $objName )
    {
        $strName = (string) $objName;

        // for each item into the list //
        // try match the item with the name //
        $intKey = array_search( $strName , $this->arrItemList );
        
        if( $intKey === false )
        {
            // if no item match, returns the not found value //
            return $this->getNotFoundValue();
        }
        else
        {
            // if match returns the value of the item //
            return $this->arrValues[ $intKey ];
        }
    }
}

?>
