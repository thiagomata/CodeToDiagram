<?php
class CodeInstrumentationFunction extends CodeReflectionFunction
{
    protected function createExtendedReflectionParameter( ReflectionParameter $objReflectionParameter )
    {
        return new CodeInstrumentationParameter( $this->getDeclaringClass()->getName() , $this->getName() , $objReflectionParameter->getName() );
    }

}
?>
