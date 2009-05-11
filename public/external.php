<?php
/**
 * @package public
 * @subpackage CodeToDiagram
 */

/**
 * This is the started file for external access
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 */

/**
 * Active all the errors messages
 */
error_reporting( E_ALL | E_NOTICE | E_PARSE );
ini_set( 'display_errors', 'On' );

if( !isset( $strPublicPath  ) )
{
    #1. Define the public path
    $strPublicPath = str_replace( "\\" , "/" , str_replace( basename( __FILE__ ) , "" , __FILE__ ) );

    #2. Load the components of the code to diagram
    require_once( $strPublicPath . "../components/library/CorujaFileManipulation.class.php" );
    require_once( $strPublicPath . "../components/loader/_start.php" );

    Loader::getInstance()->setExternal( true );
    Loader::requireOnce( $strPublicPath . '../components/_start.php' );

    #3. redefine the error handler function to the code to diagram

    function error_handler($code, $message, $file, $line)
    {
        if (0 == error_reporting())
        {
            return;
        }

        throw new CodeToDiagramException($message, 0, $code, $file, $line);
    }

    #4. get the caller path
    $arrDebugBackTrace = debug_backtrace();

    $strPublicPath = "http://" . $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ];
    $strPublicPath = str_replace( "\\" , "/" , $strPublicPath );
    $strPublicPath = str_replace( basename( __FILE__ ) , "" , $strPublicPath );

    #7. init the code to diagram
//    print highlight_string( Loader::getInstance()->getClassContent() );
    print ( Loader::getInstance()->getClassContent() );
    print "
<?php
        CodeToDiagram::getInstance()->setPublicPath( '$strPublicPath' );
?>";
}
?>