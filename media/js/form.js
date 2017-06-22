function getScript(url, success) {
    var script = document.createElement('script');
    script.src = url;
    var head = document.getElementsByTagName('head')[0],
            done = false;
    // Attach handlers for all browsers
    script.onload = script.onreadystatechange = function () {
        if (!done && (!this.readyState
                || this.readyState == 'loaded'
                || this.readyState == 'complete')) {
            done = true;
            success();
            script.onload = script.onreadystatechange = null;
            head.removeChild(script);
        }
    };
    head.appendChild(script);
}
jQuery.noConflict();
jQuery(document).ready(function ($) {

    // Filtro os termos por letras do Alfabeto
    $(".filtra-letra").click(function () {
        var attr = $(this).attr("id");
        $(".letras").hide();
        $("." + attr).show();
    });

    // Campo de Busca
    $(".buscar-termos").keypress(function (e) {
        // Pega o valor do texto digitado
        var texto = $(this).val();
        // Pega a tecla apertada no campo
        var tecla = e.keyCode;
        $("#termos div").css("display", "block");
        $("#termos div").each(function () {
            // Verifica se o texto não foi encontrado
            if ($(this).text().toUpperCase().indexOf(texto.toUpperCase()) < 0) {
                // Caso o texto digitado não seja encontrado e for apertado a tecla Enter, div é escondida
                if (tecla == 13) {
                    $(this).css("display", "none");
                }
            } else {
                //$( "div:contains('John')" ).css( "text-decoration", "underline" );
                if (tecla == 13) {
                    //$( "div:contains('"+texto+"')" ).css( "text-decoration", "underline" );
                }
            }
        });
    });

    // Quando clica no botão pesquisar
    $(".btn-buscar-termos").click(function () {

        // Pega o valor do texto digitado
        var texto = $(".buscar-termos").val();
        $("#termos div").css("display", "block");
        $("#termos div").each(function () {

            // Verifica se o texto não foi encontrado
            if ($(this).text().toUpperCase().indexOf(texto.toUpperCase()) < 0) {
                // Caso o texto informado não seja encontrado, div é escondida
                $(this).css("display", "none");
            }
        });
    });

    // Quando aperta o enter com o foco no botão pesquisar
    $(".btn-buscar-termos").keypress(function (e) {
        // Pega a tecla apertada no campo
        var tecla = e.keyCode;
        // Pega o valor do texto digitado
        var texto = $(".buscar-termos").val();
        $("#termos div").css("display", "block");
        $("#termos div").each(function () {
            // Verifica se o texto não foi encontrado
            if ($(this).text().toUpperCase().indexOf(texto.toUpperCase()) < 0) {
                // Caso to texto digitado não seja encontrado e for apertado a tecla Enter, div é escondida
                if (tecla == 13) {
                    $(this).css("display", "none");
                }
            }
        });
    });

});
