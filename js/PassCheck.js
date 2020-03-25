function cmpPass(){
    var Form = document.forms['ChngPass'];

    if(Form["nPass"].value == ""){
        document.getElementById("PasswordErr").textContent = "";
    }else if(Form["nPass"].value.length <= 8){
        document.getElementById("PasswordErr").textContent = "Please set a password having more than 8 characters";
    }else{
        document.getElementById("PasswordErr").textContent = "";
    }

    if(Form["nPass"].value != Form["CnfnPass"].value){
        document.getElementById("ConfirmErr").textContent = "Passwords don't match";
    }else{
        document.getElementById("ConfirmErr").textContent = "";
    }
}

setInterval(function(){
    cmpPass();
}, 100);

function Validate(){
    var Form = document.forms['ChngPass'];
    if(Form["nPass"].value.length <= 8 || Form["CnfnPass"].value.length <= 8){
        alert("Password must have at least 8 characters");
        location.reload();
        return false;
    }
    
    if(Form["nPass"].value != Form["CnfnPass"].value){
        alert("Passwords don't match");
        location.reload();
        return false;
    }else{
        return true;
    }
}