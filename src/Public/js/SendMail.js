document.getElementById('js-submit-btn').addEventListener('click', function (){

    //Get the value of the form input
    var nom = document.getElementById('nom').value
    var email = document.getElementById('email').value
    var sujet = document.getElementById('sujet').value
    var message = document.getElementById('message').value

    //Verify if the value is not empty
    if(nom === "" || email === "" || sujet === "" || message === "")
    {
        //Display error if an input is empty
        document.getElementById('err-form').style.display = "block";
        document.getElementById('success-form').style.display = "none";
        document.getElementById('error').style.display = "none";
        document.getElementById('err-mail').style.display = "none";
    }
    else
    {
        //Regex to check if a mail is valid
        var regexMail = /^((\w[^\W]+)[\.\-]?){1,}\@(([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        var checkMail = regexMail.test(email);

        if (checkMail === false){
            //If the mail is not valid we display an error
            document.getElementById('err-form').style.display = "none";
            document.getElementById('success-form').style.display = "none";
            document.getElementById('error').style.display = "none";
            document.getElementById('err-mail').style.display = "block";
        }
        else
        {
            //Put all the value in FormData
            var formData = new FormData();

            formData.append('nom', nom);
            formData.append('email', email);
            formData.append('sujet', sujet);
            formData.append('message', message);

            $.ajax({
                //Send the data to the controller
                url: '/blog/sendmail',
                data: formData,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function(){
                    //Display a message of success
                    document.getElementById('err-form').style.display = "none";
                    document.getElementById('success-form').style.display = "block";
                    document.getElementById('error').style.display = "none";
                    document.getElementById('err-mail').style.display = "none";
                    //We make the input empty if it's a success
                    document.getElementById('nom').value = "";
                    document.getElementById('email').value = "";
                    document.getElementById('sujet').value = "";
                    document.getElementById('message').value = "";
                },
                error: function() {
                    //Display an error
                    document.getElementById('err-form').style.display = "none";
                    document.getElementById('success-form').style.display = "none";
                    document.getElementById('error').style.display = "block";
                    document.getElementById('err-mail').style.display = "none";
                }
            });
        }
    }
});
