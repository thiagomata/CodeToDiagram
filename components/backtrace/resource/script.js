/**
 * Exibe ou oculta um elemento HTML.
 *
 * It show or hide an HTML element.
 *
 * Caso o elemento esteja vis�vel o oculta, e caso contr�rio o exibi. O nome
 * _TRACE_FUNCTION_ � utilizado para que a classe respons�vel por gerar o HTML
 * de detalhamento crie uma fun��o javascript por rastramento. O que garante a
 * exist�ncia e a n�o redeclara��o dessa fun��o n�o importando quantas vezes o
 * detalhamento � acionado e impresso.
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