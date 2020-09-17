document.getElementById('js-submit-btn').addEventListener('click', function (){

    var nom = $('#nom');
    var email = $('#email');
    var sujet = $('#sujet');
    var message = $('#message');

    $.ajax({
        url: 'src/Controller/MailController.php',
        method: 'POST',
        dataType: 'json',
        data: {
            nom: nom.val(),
            email: email.val(),
            sujet: sujet.val(),
            message: message.val()
        }
    });

});
