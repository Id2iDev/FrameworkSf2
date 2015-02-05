$(document).on('change','.filterList', function(){

    var $element = $(this);
    var id = $element.val();
    var url = $element.attr('data-url');
    var params = $element.attr('data-params');
    var target = $element.attr('data-target');
    var async = true;
    if($element.attr('data-async') != undefined){
        async = $element.attr('data-async');
    }

    $.ajax({
        'url':url+"?id="+id,
        'type':'post',
        'dataType': 'html',
        'data': params,
        'success': function(htmlOption){
            $(target).html(htmlOption);
        },
        'async':async
    });
});


function validateForm(formElementStr){
    $.validate({
        form : formElementStr,
        scrollToTopOnError: false,
        validateOnBlur: false,
        errorMessagePosition: 'top',
        onSuccess : function() {
            //alert('The form is valid :)');
            //return false;
        },
        language : {
            errorTitle : 'Le formulaire contient des erreurs',
            requiredFields : 'Vous avez des champs requis non renseignés.',
            badTime : "Vous n'avez pas donné une heure correcte.",
            badEmail : "Vous n'avez pas renseigné un e-mail correct.",
            badTelephone : "Vous n'avez pas renseigné un numéro de téléphone correct.",
            badSecurityAnswer : "Vous n'avez pas donné une réponse correcte à la question de sécurité.",
            badDate : "Vous n'avez pas renseigné une date correcte",
            lengthBadStart : 'Vous devez donner une réponse entre',
            lengthBadEnd : ' caractères',
            lengthTooLongStart : 'You have given an answer longer than ',
            lengthTooShortStart : 'Vous avez donné une réponse plus longue que ',
            notConfirmed : "Les valeurs n'ont pas pu être confirmées",
            badDomain : 'Incorrect domain valueValeur de domaine incorrect',
            badUrl : "La réponse que vous avez donnée n'est pas une URL correcte",
            badCustomVal : 'Vous avez donné une réponse incorrecte',
            badInt : 'Vous avez renseigné un chiffre non autorisé',
            badSecurityNumber : 'Votre numéro de sécurité sociale est incorrecte',
            badUKVatAnswer : 'Mauvaise UK numéro de TVA',
            badStrength : "Le mot de passe n'est pas assez fort",
            badNumberOfSelectedOptionsStart : 'Vous devez choisir au moins ',
            badNumberOfSelectedOptionsEnd : ' réponses',
            badAlphaNumeric : 'La réponse que vous avez donnée doit contenir que des caractères alphanumériques ',
            badAlphaNumericExtra: ' and ',
            wrongFileSize : 'The file you are trying to upload is too large',
            wrongFileType : 'The file you are trying to upload is of wrong type',
            groupCheckedRangeStart : 'Please choose between ',
            groupCheckedTooFewStart : 'Please choose at least ',
            groupCheckedTooManyStart : 'Please choose a maximum of ',
            groupCheckedEnd : ' item(s)'
        }
    });
}