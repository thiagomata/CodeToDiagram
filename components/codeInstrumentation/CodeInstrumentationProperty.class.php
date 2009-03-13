<?php
class CodeInstrumentationProperty extends CodeReflectionProperty
{
    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
    {
        return new CodeInstrumentationClass( $objOriginalReflectionClass->getName() );
    }

}
?>
