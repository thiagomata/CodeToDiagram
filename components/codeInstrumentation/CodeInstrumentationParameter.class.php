<?php
/**
 * Class what make possible the code instrumentation of methods and fucntions
 * with parameters
 * 
 * @author Thiago Mata
 * 
 */
class CodeInstrumentationParameter extends CodeReflectionParameter
{
    /**
     * Replace the original reflection class by the
     * Code Instrumentation version of it
     *
     * @param ReflectionClass $objOriginalReflectionClass
     * @return CodeInstrumentationClass
     */
    protected function createExtendedReflectionClass( ReflectionClass $objOriginalReflectionClass )
    {
        return new CodeInstrumentationClass( $objOriginalReflectionClass->getName() );
    }

    /**
     * Replace the original reflection method by the
     * Code Instrumentation version of it
     *
     * @param ReflectionMethod $objOriginalReflectionMethod
     * @return CodeInstrumentationMethod
     */
    protected function createExtendedReflectionMethod( ReflectionMethod $objOriginalReflectionMethod )
    {
        return new CodeInstrumentationMethod( $this->getName() , $objOriginalReflectionMethod->getName() );
    }

    /**
     * Replace the origianl reflection function of the parameters by
     * the code instrumentation version of it
     *
     * @param ReflectionFunction $objOriginalReflectionFunction
     * @return CodeInstrumentationFunction
     */
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
