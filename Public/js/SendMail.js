document.getElementById('js-submit-btn').addEventListener('click', function (){

    //Get the value of the form input
    let nom = document.getElementById('nom').value,
        email = document.getElementById('email').value,
        sujet = document.getElementById('sujet').value,
        message = document.getElementById('message').value,
        cssErrForm = document.getElementById('err-form').style,
        cssSuccessForm = document.getElementById('success-form').style,
        cssError = document.getElementById('error').style,
        cssErrMail = document.getElementById('err-mail').style;


    function isNotEmpty() {
        //Display error if an input is empty
        if(nom === "" || email === "" || sujet === "" || message === "")
        {
            cssErrForm.display = "block";
            cssSuccessForm.display = "none";
            cssError.display = "none";
            cssErrMail.display = "none";

            return false;
        }

        return true;
    }

    function checkMail() {
        //Regex to check if a mail is valid
        var regexMail = /^((\w[^\W]+)[\.\-]?){1,}\@(([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        var rgxMail = regexMail.test(email);

        //If the mail is not valid we display an error
        if (rgxMail === false) {
            cssErrForm.display = "none";
            cssSuccessForm.display = "none";
            cssError.display = "none";
            cssErrMail.display = "block";

            return false;
        }

        return true;
    }
    
    if (isNotEmpty() && checkMail()){

        const formData = new FormData();

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
                cssErrForm.display = "none";
                cssSuccessForm.display = "block";
                cssError.display = "none";
                cssErrMail.display = "none";
                //We make the input empty if it's a success
                document.getElementById('nom').value = "";
                document.getElementById('email').value = "";
                document.getElementById('sujet').value = "";
                document.getElementById('message').value = "";
            },
            error: function() {
                //Display an error
                cssErrForm.display = "none";
                cssSuccessForm.display = "none";
                cssError.display = "block";
                cssErrMail.display = "none";
            }
        });
    }
});
