function getExtension(fileName){
    var parts = fileName.split('.');
    return parts[parts.length - 1];
}

function IsImage(fileName){
    var ext = getExtension(fileName);
    switch(ext){
        case 'jpg':
        case 'jpeg':
        case 'png':
            return true;
            break;
        default:
            return false;
    }

}

function checkFile(){
    var Form = document.forms["FileExt"];
    var fileName = Form["ProPhoto"].value;

    if(IsImage(fileName)){
        document.getElementById("PhoErr").textContent = "";
    }else{
        document.getElementById("PhoErr").textContent = "The file should be .jpg, .jpeg or .png file.";
    }
}

function checkNumber(){
    var Form = document.forms["FileExt"];
    var CtNo = Form["ContactNo"].value;

    if(Math.floor(CtNo / 1000000000) != 0 && Math.floor(CtNo/10000000000) === 0){
        document.getElementById("NoErr").textContent = "";
    }else{
        document.getElementById("NoErr").textContent = "Invalid phone number";
    }
}

function checkFin(){
    var Form = document.forms["FileExt"];
    var fileName = Form["ProPhoto"].value;
    var CtNo = Form["ContactNo"].value;

    if((!(IsImage(fileName))) || !(Math.floor(CtNo / 1000000000) != 0 && Math.floor(CtNo/10000000000) === 0)){
        alert("Invalid Uploads.");
        return false;
    }else{
        alert("OK");
        return true;
    }
}

setInterval(function(){
    checkFile();
    checkNumber();
}, 100);