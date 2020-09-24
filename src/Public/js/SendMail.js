document.getElementById('js-submit-btn').addEventListener('click', function (){

    var nom = document.getElementById('nom').value
    var email = document.getElementById('email').value
    var sujet = document.getElementById('sujet').value
    var message = document.getElementById('message').value

    if(nom === "" || email === "" || sujet === "" || message === "")
    {
        document.getElementById('err-form').style.display = "block";
        document.getElementById('success-form').style.display = "none";
        document.getElementById('error').style.display = "none";
        document.getElementById('err-mail').style.display = "none";
    }
    else
    {
        var regexMail = /^((\w[^\W]+)[\.\-]?){1,}\@(([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        var checkMail = regexMail.test(email);

        if (checkMail === false){
            document.getElementById('err-form').style.display = "none";
            document.getElementById('success-form').style.display = "none";
            document.getElementById('error').style.display = "none";
            document.getElementById('err-mail').style.display = "block";
        }
        else
        {
            var formData = new FormData();

            formData.append('nom', nom);
            formData.append('email', email);
            formData.append('sujet', sujet);
            formData.append('message', message);

            $.ajax({
                url: '/blog/sendmail',
                data: formData,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function(){
                    document.getElementById('err-form').style.display = "none";
                    document.getElementById('success-form').style.display = "block";
                    document.getElementById('error').style.display = "none";
                    document.getElementById('err-mail').style.display = "none";

                    document.getElementById('nom').value = "";
                    document.getElementById('email').value = "";
                  document.getElementById('sujet').value = "";
                    document.getElementById('message').value = "";

                },
                error: function() {
                    document.getElementById('err-form').style.display = "none";
                    document.getElementById('success-form').style.display = "none";
                    document.getElementById('error').style.display = "block";
                    document.getElementById('err-mail').style.display = "none";
                }
            });
        }

    }
});
