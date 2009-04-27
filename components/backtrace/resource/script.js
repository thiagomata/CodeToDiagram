/**
 * Exibe ou oculta um elemento HTML.
 *
 * It show or hide an HTML element.
 *
 * Caso o elemento esteja visível o oculta, e caso contrário o exibi. O nome
 * _TRACE_FUNCTION_ é utilizado para que a classe responsável por gerar o HTML
 * de detalhamento crie uma função javascript por rastramento. O que garante a
 * existência e a não redeclaração dessa função não importando quantas vezes o
 * detalhamento é acionado e impresso.
 *
 * @param string identificador do item a ser exibido ou ocultado
 * @return void
 */
function _TRACE_FUNCTION_( psId )
{
    var loDiv = document.getElementById( psId );
    var lsDisplay = "";
    if ( loDiv.currentStyle )
    {
        lsDisplay = loDiv.currentStyle["display"];
    }
    else if ( window.getComputedStyle )
    {
    	if ( window.defaultView && document.defaultView.getComputedStyle )
    	{
    		lsDisplay = document.defaultView.getComputedStyle( loDiv, null ).getPropertyValue( "display" );
    	}
	}
    loDiv.style.display = lsDisplay == "none" ? "block" : "none";
}