jQuery(document).ready(function () {
    jQuery('.cep').mask('00000-000');
    jQuery('.cpf').mask('000.000.000-00', {
        reverse: true
    });
    jQuery('.telefone').mask('(00) 00000-0000');


    jQuery(document).on('click', '.btnAddInput', function (e) {
        e.preventDefault();

        var boxBody = jQuery(this).parents('.card').find('.card-body');
        var input = jQuery(this).parents('.card').find('.form-group').first().clone();

        jQuery(input).find('input[type=text]').val('');
        jQuery(input).find('input[type=radio]').prop('checked', false).val(jQuery(boxBody).find('input[type=radio]').length + 1);
        jQuery(input).find('.d-none').removeClass('d-none');
        jQuery(boxBody).append(input);
        jQuery('.telefone').mask('(00) 00000-0000');
    });
    jQuery(document).on('click', '.removeInput', function (e) {
        e.preventDefault();
        if (!confirm('Deseja continuar?')) {
            return false;
        }
        var boxBody = jQuery(this).parents('.card-body');
        jQuery(this).parents('.form-group').remove();
        jQuery(boxBody).find('input[type=radio]').each(function(key,val){
            jQuery(this).val(key+1);
        });

    });




    jQuery('#cep').on('change keyup',function () {
        var value = jQuery(this).val().replace(/[^0-9]/g,'');
        if(value.length<8){
            return false;
        }
        jQuery.ajax( {
            url: "https://viacep.com.br/ws/"+value+"/json/",
            dataType: "json",
            success: function( data ) {
                if(data.erro){
                    return false;
                }
                jQuery("#cidade").val(data.localidade);
                jQuery("#estado").val(data.uf);
                jQuery("#endereco").val(data.logradouro);
                jQuery("#bairro").val(data.bairro);

                jQuery('#numero').focus();
            }
        } );
    });

    $('#mainDemoInput').fileInput({
        iconClass: 'mdi mdi-fw mdi-upload'
    });

});