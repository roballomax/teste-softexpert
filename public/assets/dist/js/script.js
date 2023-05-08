$(function(){
    $('.dinheiro').mask('000.000.000.000.000,00', {reverse: true});
    $('.porcentagem').mask('000,00', {reverse: true});

    var enviarFormulario = true;
    //verifica os envios de formulários para validar as informações
    $(document).on('submit', 'form', function(e){

        var count_erros = 0;

        $(this).find('.obrigatorio').each(function(index, element) {
            let campo = $(this).find('[name]');

            if(campo.val().length == 0)
            {
                $(this).addClass('form-erro');
                count_erros++;
                enviarFormulario = false;
            }
            else
            {
                $(this).removeClass('form-erro');
            }
        });

        if(count_erros == 0) {
            enviarFormulario = true;
        }
        
        if(!enviarFormulario) {
            e.preventDefault();
        }
    });

});