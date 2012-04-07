<html>
    <head>
            <style type="text/css">
            .header
            {
                width: 100%;
                min-height: 10%;
            }
            .content
            {
                width: 100%;
            }
            .leftbox , rightbox
            {
                width: 50%;
                height: 80%;
                float: left;
            }
            #code , .CodeMirror-scroll , .CodeMirror
            {
                
                height: 400px !important;
            }
            .leftbox textarea   , .CodeMirror
            {
                border-top: 1px solid #eee; border-bottom: 1px solid #eee;                
                width: 100%;
                height: 80%;
            }
            .CodeMirror
            {
                height: 800px;
            }
            .CodeMirror-scroll
            {
                height: auto; overflow: visible; 
            }
            .rightbox iframe
            {
                width: 49%;
                height: 400px;
            }
            #errors_footer
            {
                float: left;
                width: 100%;
            }
            body
            {
                max-width: 100% !important;
            }
            #link
            {
                display: block;
                height: 20px;
                text-overflow: ellipsis;
                overflow: hidden;
            }
        </style>
        <link rel="stylesheet" href="../codemirror/lib/codemirror.css">
		<script src="../codemirror/lib/codemirror.js"></script>
		<script src="../codemirror/lib/util/closetag.js"></script>
		<script src="../codemirror/mode/xml/xml.js"></script>
		<script src="../codemirror/mode/javascript/javascript.js"></script>
		<script src="../codemirror/mode/css/css.js"></script>
		<script src="../codemirror/mode/htmlmixed/htmlmixed.js"></script>
		<link rel="stylesheet" href="../codemirror/doc/docs.css">
		<script type="text/javascript">
                    
                function str_replace (search, replace, subject, count) {
                    // Replaces all occurrences of search in haystack with replace  
                    // 
                    // version: 1109.2015
                    // discuss at: http://phpjs.org/functions/str_replace
                    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                    // +   improved by: Gabriel Paderni
                    // +   improved by: Philip Peterson
                    // +   improved by: Simon Willison (http://simonwillison.net)
                    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
                    // +   bugfixed by: Anton Ongson
                    // +      input by: Onno Marsman
                    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                    // +    tweaked by: Onno Marsman
                    // +      input by: Brett Zamir (http://brett-zamir.me)
                    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                    // +   input by: Oleg Eremeev
                    // +   improved by: Brett Zamir (http://brett-zamir.me)
                    // +   bugfixed by: Oleg Eremeev
                    // %          note 1: The count parameter must be passed as a string in order
                    // %          note 1:  to find a global variable in which the result will be given
                    // *     example 1: str_replace(' ', '.', 'Kevin van Zonneveld');
                    // *     returns 1: 'Kevin.van.Zonneveld'
                    // *     example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars');
                    // *     returns 2: 'hemmo, mars'
                    var i = 0,
                        j = 0,
                        temp = '',
                        repl = '',
                        sl = 0,
                        fl = 0,
                        f = [].concat(search),
                        r = [].concat(replace),
                        s = subject,
                        ra = Object.prototype.toString.call(r) === '[object Array]',
                        sa = Object.prototype.toString.call(s) === '[object Array]';
                    s = [].concat(s);
                    if (count) {
                        this.window[count] = 0;
                    }

                    for (i = 0, sl = s.length; i < sl; i++) {
                        if (s[i] === '') {
                            continue;
                        }
                        for (j = 0, fl = f.length; j < fl; j++) {
                            temp = s[i] + '';
                            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
                            s[i] = (temp).split(f[j]).join(repl);
                            if (count && s[i] !== temp) {
                                this.window[count] += (temp.length - s[i].length) / f[j].length;
                            }
                        }
                    }
                    return sa ? s : s[0];
                }                    
                    
                function updateDiagram()
                {
                    var strContentDiagram = window.editor.getValue();
                    strContentDiagram = str_replace( "&lt;" , "<" , strContentDiagram );
                    strContentDiagram = str_replace( "&gt;" , ">" , strContentDiagram );
                    strContentDiagram = str_replace( "\n" , "" , strContentDiagram );
                    strContentDiagram = str_replace( "\t" , "" , strContentDiagram );
                    var objDomParser = new DOMParser();
                    var arrErrors = new Array();
                    try{
                        var objXml = objDomParser.parseFromString( strContentDiagram , "text/xml" );
                        var arrParserErrors = ( objXml.getElementsByTagName("parsererror") );
                        for( var i = 0 ; i < arrParserErrors.length ; i++ )
                        {
                            var objError = arrParserErrors[ i ];
                            arrErrors.push( objError.textContent );
                        }
                    }catch( e )
                    {
                        arrErrors.push( e.message );
                    }
                    
                    document.getElementById( "errors_footer" ).innerHTML = "";
                    
                    if( arrErrors.length > 0 )
                    {
                        var objList = document.createElement( "ul" );
                        for( var j = 0 ; j < arrErrors.length ; j++ )
                        {
                            var objItem = document.createElement( "li" );
                            objItem.textContent = arrErrors[ j ];
                            objList.appendChild( objItem );
                        }
                        document.getElementById( "errors_footer" ).appendChild( objList );
                    }
                    else
                    {
                        window.objXml = objXml;
                        var objDiagram = document.getElementById( "diagram" );
                        var objLink = document.getElementById( "link" );
                        objDiagram.src = "class.php?zoom=100&xml=" + strContentDiagram;
                        objLink.href = objDiagram.src;
                        objLink.innerHTML = objDiagram.src;
                    }
                }
                    
                function init()
                {
                    if( arguments.callee.done ) return;
                    window.editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                        
                        onChange: updateDiagram ,
                    
                        mode: 'text/html',
                        //mode: 'xmlpure',

                        //closeTagEnabled: false, // Set this option to disable tag closing behavior without having to remove the key bindings.
                        //closeTagIndent: false, // Pass false or an array of tag names to override the default indentation behavior.

                        extraKeys: {
                                "'>'": function(cm) { cm.closeTag(cm, '>'); },
                                "'/'": function(cm) { cm.closeTag(cm, '/'); }
                        },

                        wordWrap: true
                    });
                    updateDiagram();
                }
                
                if( document.addEventListener )
                {
                    document.addEventListener( "DOMContentLoaded" , init , false );
                }
                else
                {
                    document.body.onLoad = "init()";
                }
                
		</script>
	</head>
	<body>
        <div class="header">
            <h1> Code to Diagram - Class Diagram Editor </h1>
            <div class="buttons">
                <a href="#" id="link">
                    #
                </a>
            </div>
        </div>
        <div class="content">
            <div class="leftbox">
		<form><textarea onchange="javascript:updateDiagram()" id="code" name="code"><?php print file_get_contents( "../examples/xmls/class1.xml" ) ?>    </textarea></form>
            </div>
            <div class="rightbox">
                <iframe id="diagram"></iframe>
            </div>
        </div>
        <div id="errors_footer">
        </div>  
    </body>
</html>