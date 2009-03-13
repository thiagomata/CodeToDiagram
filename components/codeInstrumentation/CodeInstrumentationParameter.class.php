<?php
class CodeInstrumentationParameter extends CodeReflectionParameter
{
    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
    {
        return new CodeInstrumentationClass( $objOriginalReflectionClass->getName() );
    }

    protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
    {
        return new CodeInstrumentationMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
    }

    protected function createExtendedReflectionFunction( ReflectionFunction $objOriginalReflectionFunction )
    {
        if( $objOriginalReflectionFunction instanceof ReflectionMethod )
        {
            return new CodeInstrumentationMethod( $objOriginalReflectionFunction->getName() );
        }
        else
        {
            return new CodeInstrumentationFunction( $objOriginalReflectionFunction->getName() );
        }
    }
}

?>
