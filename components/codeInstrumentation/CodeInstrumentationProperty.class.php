<?php
/**
 * class necessary to make the code instrumentation process possible
 * 
 * the propery has not big changes of the code reflection property 
 * but it is necessary to extend it to create the reflections links
 * possibles keeping the code instrumentation context.
 * 
 * @author Thiago Mata
 *
 */
class CodeInstrumentationProperty extends CodeReflectionProperty
{
	/**
	 * Make the calls to the reflection class of the property
	 * return a Code Instrumentation class
	 * 
	 * @see CodeReflectionProperty::createExtendedReflectionClass( ReflectionClass )
	 * @see CodeReflectionProperty::createExtendedReflectionClass( ReflectionClass )
	 */
    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
    {
        return new CodeInstrumentationClass( $objOriginalReflectionClass->getName() );
    }

}
?>
