<?php
require_once("../_start.php");
echo "(bool)false = " . serialize((bool)"false");
echo "<br />";
echo "strToBool(null) = " . serialize(CorujaStringManipulation::strToBool(null));
?>