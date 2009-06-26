<?php

class CorujaDebug
{
    /**
     * Char conversor to the xml debug
     * 
     * @param integer $num
     * @return char
     */
    private function privateXMLEntities($intNum)
    {
        $chars = array(
        128 => '&#8364;',   130 => '&#8218;',   131 => '&#402;',    132 => '&#8222;',
        133 => '&#8230;',   134 => '&#8224;',   135 => '&#8225;',   136 => '&#710;',
        137 => '&#8240;',   138 => '&#352;',    139 => '&#8249;',   140 => '&#338;',
        142 => '&#381;',    145 => '&#8216;',   146 => '&#8217;',   147 => '&#8220;',
        148 => '&#8221;',   149 => '&#8226;',   150 => '&#8211;',   151 => '&#8212;',
        152 => '&#732;',    153 => '&#8482;',   154 => '&#353;',    155 => '&#8250;',
        156 => '&#339;',    158 => '&#382;',    159 => '&#376;'
        );
        $num = ord($intNum);
        return (($intNum > 127 && $intNum < 160) ? $chars[$intNum] : "&#".$intNum.";" );
    }

    /**
     * When objects with recursive are export to string one error happen. This
     * code it is a work around to recusive object can be see. They recursive
     * call are replace to string with the "recursive" value
     *
     * @param object $mixExpression
     */
    private static function removeRecursiveProblem( $mixExpression )
    {
        $mixExpression = serialize( $mixExpression );
        $arrExpression = explode( ";" , $mixExpression );
        foreach( $arrExpression as $intKey => $strExpression )
        {
            $arrElement = explode( ":" , $strExpression );
            if( $arrElement[0] == "r" )
            {
                $arrElement[0] = "s";
                $arrElement[2] = '"<b>*recursive*</b>"';
                $arrElement[1] = strlen( $arrElement[2] ) - 2;
            }
            $arrExpression[ $intKey ] = implode( ":" , $arrElement );
        }

        $mixExpression = implode( ";" , $arrExpression );
        $mixExpression = unserialize( $mixExpression );

        $mixExpression = ( var_export( $mixExpression , 1 ) );
        $arrClasses = explode( "::" , $mixExpression );

        foreach( $arrClasses as $intKey => $strClass )
        {
            $arrClass = explode( " " , $strClass );
            $intLast =  sizeof( $arrClass ) - 1;
            $arrClass[ $intLast ] = '<b>'. $arrClass[ $intLast ] . '</b>';
            $strClass = implode( " " , $arrClass );
            $arrClasses[ $intKey ] = $strClass;
        }

        $mixExpression = implode( "::" , $arrClasses );

        return $mixExpression;

    }

    private static function highlightXml( $strXmlContent , $booCssInLine = true )
    {
        $booHasHeader = ( ( strpos( $strXmlContent , "<" . "?" . "xml" ) ) !== false );
        $strXmlContent = htmlentities( $strXmlContent , true );

        // the css must be on style attribute to not be lose into the //
        // e-mail send or something like                              //

        if( $booCssInLine )
        {
            $strStartTagStyle   = "color:olive;";
            $strNameTagStyle    = "color:olive";
            $strOutTagStyle     = "";
            $strInsideTagStyle  = "color:black";
            $strNextStyle       = "color:navy";
            $strValueTagStyle   = "color:red";
            $strNone            = "display:none";
            $strAttribute       = "span style=";
        }
        else
        {
            $strStartTagStyle   = "start_tag";
            $strNameTagStyle    = "name_tag";
            $strOutTagStyle     = "out_tag";
            $strInsideTagStyle  = "inside_tag";
            $strNextStyle       = "next_tag";
            $strValueTagStyle   = "value_tag";
            $strNone            = "none_tag";
            $strAttribute       = "span class=";
        }

        $strXmlContent = str_replace(
                Array(
                    "&gt;?" ,       //  < ?  start xml tag
                    "?&gt;" ,       //  ? >  out xml tag
                    "&lt;" ,        //  <   start tag
                    "/&gt;" ,       //  />  out tag
                    "&gt;" ,        //   >   content tag
                    " ",            //  change of word
                    "=",            //  attribute
                    "span_style",
               ),
                Array(
                    "</span></span><span_style'$strStartTagStyle'\n>&lt;<span_style'$strNameTagStyle'><span_style'$strNone'>&nbsp;</span>" ,
                    "</span>?&gt;</span><span_style'$strOutTagStyle'\n>",
                    // -2 +3 = +1 //
                    "</span></span><span_style'$strStartTagStyle'\n>&lt;<span_style'$strNameTagStyle'><span_style'$strNone'>&nbsp;</span><span>" ,
                    // -2 +1 = -1 //
                    "</span>/&gt;</span></span></span\n><span_style'$strOutTagStyle'\n>",
                    // -1 +1 = 0//
                    "</span>&gt;<span_style'$strInsideTagStyle'>",
                    // -1 +1 = 0//
                    "</span> <span_style'$strNextStyle'>",
                    // -1 +1 = 0//
                    "</span>=<span_style'$strValueTagStyle'>",
                    $strAttribute,
                ),
            $strXmlContent
        );

        $strXmlContent = "<div class='xml'><span><span>" . $strXmlContent;

        if( $booHasHeader )
        {
            $strXmlContent .= '</span></span>';
        }
        $strXmlContent .= "</span></span></div>";
        return $strXmlContent;
        
    }
    
    /**
     * Get the debug backtrace of the stack in the send deeper
     * 
     * @param integer $intDeeper
     * @return array
     */
    private static function getBackTraceCaller( $intDeeper = 0 )
    {
        $arrBackTrace = CorujaArrayManipulation::getArrayField( debug_backtrace() , $intDeeper );
        unset( $arrBackTrace[ "object" ] );
        return $arrBackTrace;
    }

    /**
     * Show the content and create the backtrace information into the html comment
     *
     * @param mixer $mExpression
     * @param boolean $boolExit
     */
    public static function show( $strExpression , $boolExit = FALSE )
    {
        $arrBacktraceCaller = self::getBackTraceCaller(2);
        print $strExpression;
        print "\n<!--";
        foreach( $arrBacktraceCaller as $strKey => $mixValue )
        {
            print $strKey . " = " . serialize($mixValue) . "\n";
        }
        print "--><br/>\n";
    }

    /**
     * Display the information and show the backtrace
     * 
     * @param mixer $mixExpression
     * @param boolean $boolExit
     */
    public static function debug( $mixExpression , $boolExit = FALSE )
    {
        self::display(  self::removeRecursiveProblem( $mixExpression ) ,$boolExit );
    }

    /**
     * Display a php code and show the backtrace
     * 
     * @param string $strPhpExpression
     * @param booelan $boolExit
     */
    public static function debugPhpCode( $strPhpExpression, $boolExit = FALSE )
    {
        if( substr( $strPhpExpression , 0 , 2 ) != "<?" )
        {
            $strPhpExpression = "<?php \n" . $strPhpExpression;
        }
        $strPhpExpression = highlight_string( $strPhpExpression , true );
        self::display( $strPhpExpression, $boolExit );

    }

    /**
     * Display the xml information and show the backtrace
     *
     * @param string $strXmlExpression
     * @param boolean $boolExit
     */
    public static function debugXmlCode( $strXmlExpression, $boolExit = FALSE )
    {
        $strXmlExpression = preg_replace('/[^\x09\x0A\x0D\x20-\x7F]/e', 'CorujaDebug::privateXMLEntities("$0")', $strXmlExpression);
        self::display( self::highlightXml( $strXmlExpression ) , $boolExit );
    }

    /**
     * Show the xml information and show the backtrace
     *
     * @param string $strXmlExpression
     * @param boolean $boolExit
     */
    public static function printXmlCode( $strXmlExpression, $boolCssInLine = FALSE, $boolExit = FALSE )
    {
        $strXmlExpression = preg_replace('/[^\x09\x0A\x0D\x20-\x7F]/e', 'CorujaDebug::privateXMLEntities("$0")', $strXmlExpression);
        self::prints( self::highlightXml( $strXmlExpression , $boolCssInLine ) , $boolExit );
    }

    /**
     * Display the html information and show the backtrace
     *
     * @param string $strHtmlExpression
     * @param boolean $boolExit
     */
    public static function debugHtmlCode( $strHtmlExpression, $boolExit = FALSE )
    {
        self::display( self::highlightXml( $strHtmlExpression ) , $boolExit );
    }

    /**
     * Display the received information, case the second parameter be true
     * throw one fake exception.
     * 
     * @param mixer $mixExpression
     * @param boolean $boolExit
     */
	public static function display( $mixExpression , $boolExit = FALSE)
	{
        $arrBacktraceCaller = self::getBackTraceCaller(2);
		$strMessage = "/*";
		$strMessage .= "<fieldset><legend><font color=\"#007000\">debug</font></legend><pre>" ;
		foreach( $arrBacktraceCaller as $strAttribute => $mixValue )
		{
			$strMessage .= "<b>" . $strAttribute . "</b>: ". $mixValue ."\n";
		}

        $strMessage .= "<div style='background-color: #F0F0F0; float:left'>";
		$strMessage .= $mixExpression;
        $strMessage .= "</div>";
	
		$strMessage .= "</pre>";
		$strMessage .= "</fieldset> */";

        print $strMessage;
        
		if( $boolExit )
		{
			print "<br /><font color=\"#700000\" size=\"4\"><b>D I E</b></font>";
			throw new CorujaException( var_export( $mixExpression , 1 )  );
		}
	}

    /**
     * Display the received information, case the second parameter be true
     * throw one fake exception.
     *
     * @param mixer $mixExpression
     * @param boolean $boolExit
     */
	public static function prints( $mixExpression , $boolExit = FALSE)
	{
		$strMessage = "";
		$strMessage .= $mixExpression;

		$strMessage .= "";

        print $strMessage;

		if( $boolExit )
		{
			print "<br /><font color=\"#700000\" size=\"4\"><b>D I E</b></font>";
			throw new Exception( var_export( $mixExpression , 1 )  );
		}
	}
}
?>
