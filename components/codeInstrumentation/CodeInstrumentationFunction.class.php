<?php
/**
 * CodeInstrumentationFunction create the changed code version
 * of the function
 * @package CodeInstrumentation
 *
 */

/**
 * Implement a code instrumentation into a function
 *
 * Make a call to some function what was apply the code
 * instrumentation make a message to some actor of the
 * code instrumentation receiver
 *
 * @todo This class need to make code instrumentation.
 * Today code instrumentation works only into objects
 * @question What will be the actor or object what will
 * be resposable by the functions as its methods
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class CodeInstrumentationFunction extends CodeReflectionFunction
{
    /**
     * This method is necessary to make the callers of the parameters
     * of the function bring CodeInstrumentationParameters
     *
     * @see ExtendedReflectionFunction::createExtendedReflectionParameter
     * @param ReflectionParameter $objReflectionParameter
     * @return CodeInstrumentationParameter
     */
    protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
    {
        return new CodeInstrumentationParameter( $this->getDeclaringClass()->getName() , $this->getName() , $objReflectionParameter->getName() );
    }

}

?>