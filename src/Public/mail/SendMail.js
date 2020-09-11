function _(id){return document.getElementById(id)}
function submitForm(){
    _("submitBtn").disabled = true;
    _("status").innerHTML = "Veuillez patientez ...";
    var formdata = new FormData();
    formdata.append("nom", _("nom").value);
    formdata.append("email", _("email").value);
    formdata.append("sujet", _("sujet").value);
    formdata.append("message", _("message").value);
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "SendMail.php");
    ajax.onreadystatechange = function (){
        if (ajax.readyState === 4 && ajax.status === 200){
            if (ajax.responseText === "Message envoyé !"){
                _("formContact").innerHTML = '<h4>Merci ' + _("name").value + 'pour votre message';
            }else{
                _("status").innerHTML = ajax.responseText;
                _("submitBtn").disabled = false;
            }
        }
    }
    ajax.send(formdata);
}