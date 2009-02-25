<?php
class CodeReflectionProperty extends ExtendedReflectionProperty
{
    /**
     * Get the default value of the property.
     *
     * While the PHP Reflection don't make this method native.
     * We have to create this workaround to get the default value
     * of the attribute. This brings a problem of classes what need
     * of paramenters into it's constructors. In this cases, the default
     * value will be ignored.
     *
     * @workaround getDafaultValue don't exist into reflection
     * @fixme unable to get default value on constructors with parameters
     * @todo get the default value of the attribute reading direct from the file
     * @return mix
     */
    public function getDefaultValue()
    {
        try
        {
            $objParent = $this->getDeclaringClass();
            $strClassName = $objParent->getClassName();
            $objTemp = new $strClassName();
            $arrTemp = (array)$objTemp;
            $arrNew = array();
            foreach( $arrTemp as $strKeyTemp => $mixValue )
            {
                $strNewKey = substr( $strKeyTemp , 3 );
                $arrNew[ $strNewKey ] = $mixValue;
            }
            return $arrNew[ $this->getName() ];
        }catch( Exception $objException )
        {
            // error on init object //
            return null;
        }
    }
	public function getCode()
	{

        $strCode = "";
		$strCode .= CorujaStringManipulation::retab( $this->getDocComment() , 1 );
		if( $this->isPrivate() )
		{
			$strCode .= " private ";
		}
		if( $this->isProtected())
		{
			$strCode .= " protected ";
		}
		if( $this->isPublic())
		{
			$strCode .= " public ";
		}
		if( $this->isStatic() )
		{
			$strCode .= " static ";
		}
		$strCode .= '$'. $this->getName();

        $strCode .= ' = ' . var_export( $this->getDefaultValue() , true );
		$strCode .= ";" . "\n";
		
		return $strCode;
	}
	
	protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
	{
		return new CodeReflectionClass( $objOriginalReflectionClass->getName() );
	}

}
?>