function validateEmail(elementValue){      
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(elementValue); 
}

function validate(){
    var Form = document.forms["SignUpForm"];

    if(validateEmail(Form["SUemail"].value) == false){
        alert("Invalid Email");
        location.reload();
        return false;
    }

    if(Form["SignUpPass"].value.length <= 8 || Form["SignUpPassCnf"].value.length <= 8){
        alert("Password must have at least 8 characters");
        location.reload();
        return false;
    }
    
    if(Form["SignUpPass"].value != Form["SignUpPassCnf"].value){
        alert("Passwords don't match");
        location.reload();
        return false;
    }else{
        return true;
    }
}

setInterval(function(){
    var Form = document.forms["SignUpForm"];
    if(Form["SUemail"].value == ""){
        document.getElementById("EmailErr").textContent = "";
    }else if(validateEmail(Form["SUemail"].value) == false){
        document.getElementById("EmailErr").textContent = "Please check your email";
    }else{
        document.getElementById("EmailErr").textContent = "";
    }

    if(Form["SignUpPass"].value == ""){
        document.getElementById("PasswordErr").textContent = "";
    }else if(Form["SignUpPass"].value.length <= 8){
        document.getElementById("PasswordErr").textContent = "Please set a password having more than 8 characters";
    }else{
        document.getElementById("PasswordErr").textContent = "";
    }

    if(Form["SignUpPass"].value != Form["SignUpPassCnf"].value){
        document.getElementById("ConfirmErr").textContent = "Passwords don't match";
    }else{
        document.getElementById("ConfirmErr").textContent = "";
    }
}, 100);

function dupUser(uname){
    if(uname != ""){
        var xmlHTTP = new XMLHttpRequest();
        xmlHTTP.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("UserNameErr").textContent = this.responseText;
            }
        };
        xmlHTTP.open("GET", "../php/dupUser.php?uname="+uname, true);
        xmlHTTP.send();
    }else{
        document.getElementById("UserNameErr").textContent = "";
        return;
    }

}

function dupEmail(email){
    
    if(email != ""){
        var xmlHTTP = new XMLHttpRequest();
        xmlHTTP.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("DupEmailErr").textContent = this.responseText;
            }
        };
        xmlHTTP.open("GET", "../php/dupUser.php?email="+email, true);
        xmlHTTP.send();
    }else{
        document.getElementById("DupEmailErr").textContent = "";
        return;
    }
}