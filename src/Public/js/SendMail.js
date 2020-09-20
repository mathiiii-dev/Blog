console.log(document.getElementById('js-submit-btn'));
document.getElementById('js-submit-btn').addEventListener('click', function (){

    var nom = $('#nom');
    var email = $('#email');
    var sujet = $('#sujet');
    var message = $('#message');

    $.ajax({
        url: '/sendMail',
        method: 'POST',
        dataType: 'json',
        data: {
            nom: nom.val(),
            email: email.val(),
            sujet: sujet.val(),
            message: message.val()
        }
    });

    console.log('test');

});
