var CanvasExportXml = Class.create();

CanvasExportXml.Static = new Object();

CanvasExportXml.Static.recursiveXmlObject = function recursiveXmlObject( objElement , intTagDepper )
{
    var arrLines = Array();
 
    if( Object.isUndefined( intTagDepper ) )
    {
         intTagDepper = 0;
    }
    
    if( Object.isFunction( objElement.toSerialize ) )
    {
        objElement = objElement.toSerialize();   
    }
    
    if( typeof objElement == 'string' )
    {
        arrLines.push( str_repeat( "	" , intTagDepper ) + "" + objElement + "" );
        return arrLines;
    }
    
    
    for( var strAttribute in objElement )
    {
        if( ! Object.isFunction( objElement[ strAttribute ] ) && ! Object.isUndefined( objElement[ strAttribute ] ) && objElement[ strAttribute ] !== null )
        {
            arrLines.push(  str_repeat( "	" , intTagDepper ) + "<" + strAttribute + ">" );
            if( objElement[ strAttribute ].tagName !== undefined )
            {
                arrLines.push( str_repeat( "	" , intTagDepper + 1 ) + "" + objElement[ strAttribute ].id + "" );
            }
            else 
            {
                if(  ( typeof objElement[ strAttribute ] != "string"  ) && ( Object.isArray( objElement[ strAttribute ] ) ) )
                {
                    for( var intKeyChild in objElement[ strAttribute ] )
                    {
                        if( ! Object.isFunction( objElement[ strAttribute ][ intKeyChild ] ) && 
                            ! Object.isUndefined( objElement[ strAttribute ][ intKeyChild ] ) && 
                            objElement[ strAttribute ][ intKeyChild ] !== null )
                        {
                            arrLines.push( str_repeat( "	" , intTagDepper + 1 ) + "<item value=" + intKeyChild + ">" );

                            var arrChildLines = this.recursiveXmlObject( objElement[ strAttribute ][ intKeyChild ] , intTagDepper + 2 );
                            for( var intChild in arrChildLines )
                            {
                                if( 
                                    ! Object.isFunction( arrChildLines[ intChild ] ) && 
                                    ! Object.isUndefined( arrChildLines[ intChild ] ) && 
                                    arrChildLines[ intChild ] !== null 
                                )
                                {
                                    arrLines.push( arrChildLines[ intChild ] );
                                }
                            }
                        
                            arrLines.push( str_repeat( "	" , intTagDepper + 1 ) + "</item>" );
                            
                        }
                    }
                }
                else
                {
                    if( typeof objElement.strAttribute != 'object' )
                    {
                        arrLines.push( str_repeat( "	" , intTagDepper + 1 ) + "" + objElement[ strAttribute ] + "" );
                    }
                    else
                    {
                        var objRecursive = objElement[ strAttribute ];
                        if( Object.isFunction( objRecursive.toSerialize ) )
                        {
                            objRecursive = objRecursive.toSerialize();   
                        }
                        
                        var arrChildLines = this.recursiveXmlObject( objRecursive , intTagDepper + 1 );
                        for( var intChild in arrChildLines )
                        {
                            if( 
                                ! Object.isFunction( arrChildLines[ intChild ] ) && 
                                ! Object.isUndefined( arrChildLines[ intChild ] ) && 
                                arrChildLines[ intChild ] !== null 
                            )
                            {
                                arrLines.push( arrChildLines[ intChild ] );
                            }
                        }
                    }
                }
                arrLines.push(  str_repeat( "	" , intTagDepper ) + "</" + strAttribute + ">" );
            }
        }
    }
    return arrLines;
};   

CanvasExportXml.Static.showAsXml = function showAsXml( objElement )
{
    return implode( "\n" , CanvasExportXml.Static.recursiveXmlObject( objElement ) );
}
