<html>
	<head>
		<title>
			Generate the base64 from one of the icons
		</title>
	</head>
	<body>
<?php
$strFile = @$_REQUEST[ 'file_selected' ];
print $strFile;
if( $strFile )
{ 
	$strText = base64_encode( file_get_contents( $strFile ) );

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
}
else
{
	$arrDirFiles = scandir( __DIR__ );
	array_shift( $arrDirFiles ); // remove .
	array_shift( $arrDirFiles ); // remove ..
	?>
		<form action="" method="post">
			<select name="file_selected">
				<?php foreach( $arrDirFiles as $strFile ): ?>
					<option><?php print $strFile ?></option>
				<?php endforeach ?>
			</select>
			<input type="submit"/>
		</form>
	<?php
}
?>
	</body>
</html>
