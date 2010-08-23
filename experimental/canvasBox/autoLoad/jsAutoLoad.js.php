<?php
$strDir = __DIR__;
$arrDir = explode( "/" , $strDir );
array_pop( $arrDir );
$intDeep = isset( $_REQUEST['deep'] ) ? $_REQUEST['deep'] : 0;
$intBack = isset( $_REQUEST['back'] ) ? $_REQUEST['back'] : 0;

while( $intDeep-- )
{
    array_pop( $arrDir );
}
$strDir = implode( "/" , $arrDir );
for( $i = 0 ; $i < $intBack ; $i++ )
{
    array_pop( $arrDir );
}
$strBack = implode( "/" , $arrDir );

$arrFolders = array();
$arrFiles = ( describe_folder( $strDir , $strBack , $arrFolders ) );

function describe_folder( $strDir , $strParentDir = null , &$arrFolders = null)
{
    $arrFiles = array();
    if( $arrFolders == null )
    {
        $arrFolders = array();
    }
    
    if( $strParentDir == null )
    {
        $strParentDir = $strDir;
    }
    
    $arrDirFiles = scandir( $strDir );
    foreach( $arrDirFiles as $strFileName )
    {
        if( $strFileName[0] == "." )
        {
            continue;
        }
        $strDirFolder = $strDir . '/' . $strFileName;
        if( is_dir( $strDirFolder ) )
        {
            $strShortName = str_replace( array( "-" , '+' , ' ' , '.' ), "_" , $strFileName );
            $arrFolders[ $strShortName ] = $strDirFolder;
            $arrChildFiles = describe_folder( $strDirFolder , $strParentDir , $arrFolders );
            $arrFiles = array_merge( $arrFiles , $arrChildFiles );
        }
        else
        {
            $strType = ( substr( $strFileName , strpos( $strFileName , "." ) ) );
            if( $strType == ".js" )
            {
                $strPath = $strDirFolder;
                $strRelative = "." . str_replace( $strParentDir , "", $strPath );
                $strShortName = substr( $strFileName , 0 , -3 );
                $strShortName = str_replace( array( "-" , '+' , ' ' , '.' ), "_" , $strShortName );
                
                $arrFiles[ ucfirst( $strShortName ) ] = $strRelative;
            }
        }
    }
    return $arrFiles;
}
?>
window.autoload = function(){};

<?php foreach( $arrFiles as $strShortNameFile => $strPathFile ): ?>
window.autoload.<?php print "load" . $strShortNameFile ?> = function <?php print "load" . $strShortNameFile ?>()
{
    require_once( "<?php print str_repeat( "../", $intBack ) . $strPathFile ?>" );
    return <? print $strShortNameFile ?>;
}
window.autoload.<?php print "new" . $strShortNameFile ?> = function <?php print "new" . $strShortNameFile ?>( p1 , p2 , p3 , p4 , p5 , p6 )
{
    window.autoload.<?php print "load" . $strShortNameFile ?>();
    var objElement = new <?php print $strShortNameFile ?>( p1 , p2 , p3 , p4 , p5 , p6 );
    return objElement;
};

<? endforeach ?>
<?php foreach( $arrFolders as $strShort => $strFolder ): ?>
window.autoload.getPathOf<?php print ucfirst( $strShort ) ?> = function getPathOf<?php print ucfirst( $strShort ) ?>()
{
    return '<?php print  str_repeat( "../", $intBack ) . '.' . substr( $strFolder , strlen( $strDir ) ) ?>';
}
<? endforeach ?>
