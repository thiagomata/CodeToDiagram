<?php
$strText = base64_encode( file_get_contents( "zoomOut.png" ) );

$j = 0;
print "<pre>'";
for( $i = 0; $i < strlen( $strText ) ; $i++ )
{
	$j++;
	if( $j > 0 && $j % 50 == 0)
	{
		print "'+\n'";
	}
	print $strText[$i];	
}
?>