<?php
# 1. Load the component exceptiop
require_once( "CorujaComponentException.class.php" );

# 2. load the components manager
require_once( PATH_CORUJA_COMPONENT . "/componentsManager/_start.php" );

# 3. load the debug execution component
CorujaComponentsManager::getInstance()->import( "library" );
CorujaComponentsManager::getInstance()->import( "debugExecution" );

?>
