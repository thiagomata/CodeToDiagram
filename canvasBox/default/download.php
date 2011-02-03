<?php
$strFileName = $_REQUEST[ 'fileName' ];
$strB64Content = $_REQUEST[ 'base64Content' ];
$strImageType = $_REQUEST[ 'imageType' ];
$strB64Content = substr( $strB64Content , strpos( $strB64Content , "," ) + 1 );
$strContent = base64_decode( $strB64Content );
header("Content-type: application/$strImageType/force-download");
header('Content-Disposition: attachment; filename="' . $strFileName . '"');
print $strContent;
