<?php
/**
 * CorujaFileManipulation - Class for manipulation of files
 * @package library
 */

/**
 * Class for manipulation of files
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */
class CorujaFileManipulation
{
    /**
     * Returns a path to a folder relative from another folder. Both parameters
     * must be absolute.
     *
     * - check for valid parameters
     * - in case paths are equal return './'
     * - explode parameters using '/'
     * - remove similar base folders
     * - make final address
     *
     * @param String $strFileFrom Base from the path. This must be an absolute path.
     * @param String $strFileTo Destination of the path. This must be an absolute path.
     * @param Boolean $booValidPath Use false if you don't want to check for valid folders.
     * @throws InvalidArgumentException In case of invalid values
     *
     * @example $path = CorujaStringManipulation::getRelativePath( "/www/folder/", "/www/another/big/" ); // "../another/big/"
     *
     * @assert ( "/www/folder/", "/www/another/big/", false ) == "../another/big/"
     * @assert ( "", "" ) throws InvalidArgumentException
     * @assert ( "hello", "" ) throws InvalidArgumentException
     * @assert ( "", "hello" ) throws InvalidArgumentException
     * @assert ( "cool", "hello" ) throws InvalidArgumentException
     * @assert ( "/cool/", "hello" ) throws InvalidArgumentException
     * @assert ( "cool", "/hello/" ) throws InvalidArgumentException
     * @assert ( "/cool/", "/hello/", false ) == "../hello/"
     * @assert ( "/cool/", "/hello/", false ) == "../hello/"
     * @assert ( "/cool/", "/cool/", false ) == "./"
     * @assert ( "/cool/more/", "/other/", false ) == "../../other/"
     * @assert ( "/cool/", "/other/more/", false ) == "../other/more/"
     */
    public static function getRelativePath( $strFileFrom, $strFileTo, $booValidPath = true )
    {
        // check for valid parameters

        $strFileFrom = str_replace( "\\" , "/" , $strFileFrom );
        $strFileTo = str_replace( "\\" , "/" , $strFileTo );

        if( $booValidPath
            && ( ! is_dir( $strFileFrom ) || ! is_dir( $strFileTo ) )
        )
        {
            throw new InvalidArgumentException("Invalid parameter: strFileFrom: ".$strFileFrom." strFileTo: ".$strFileTo);
        }

        // special case: equal paths
        if( $strFileFrom == $strFileTo )
        {
             $strReturnPath = './';
        }
        else
        {
            // explode parameters using '/'
            $arrFileFrom = explode( '/', $strFileFrom );
            $arrFileTo   = explode( '/', $strFileTo );

            // remove similar base folders
            while(
                current( $arrFileFrom ) == current( $arrFileTo )
                && count( $arrFileFrom ) > 0
            )
            {
                array_shift( $arrFileFrom );
                array_shift( $arrFileTo );
            }

            $arrReturnPath = array();

            // make final address
            foreach( $arrFileFrom as $strFolder )
            {
                if( $strFolder != "" ) {
                    $arrReturnPath[] = "..";
                }
            }

            foreach( $arrFileTo as $strFolder )
            {
                $arrReturnPath[] = $strFolder;
            }

            $strReturnPath = implode( '/', $arrReturnPath );
        }
        return $strReturnPath;
    }

    /**
     * Check if a address is relative
     *
     * @assert( "c:\www\temp.php" ) == false
     * @assert( "d:/www/temp.php" ) == false
     * @assert( "temp.php" ) == true
     * @assert( "./temp.php" ) == true
     * @assert( "/www/something.php" ) == false
     * @assert( "./www/something.php" ) == true
     * @assert( ".\www\something.php" ) == true
     * @assert( "..\www\something.php" ) == true
     * @assert( "..\www\something.php" ) == true
     *
     */
    public static function isRelativePath( $strFile )
    {
        $strFile = str_replace( "\\", "/", $strFile);
        if(
            ( strpos( $strFile, "./") === 0 )
            or
            ( strpos( $strFile, "../") === 0 )
         )
        {
            return true;
        }
        elseif( strpos( $strFile, "/") === false )
        {
            return true;
        }
        else
        {
            return false;
        }
   }
   
   /**
    * Get the path of the file
    * 
    * @param string $strFile
    * @return string 
    */
    public static function getPathOfFile( $strFile )
    {
        return str_replace( "\\" , "/" , str_replace( basename( $strFile ) , "" , $strFile ) );
    }
}
?>