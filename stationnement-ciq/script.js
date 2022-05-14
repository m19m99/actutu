function SetDate()
{
let date = new Date();

let day = date.getDate();
let month = date.getMonth() + 1;
let year = date.getFullYear();

year++;

if (month < 10) month = "0" + month;
if (day < 10) day = "0" + day;

let today = year + "-" + month + "-" + day;


document.getElementById('date').value = today;
document.getElementById('date').min = today;

}


function verif(evt) {
    let keyCode = evt.which ? evt.which : evt.keyCode;
    let accept = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789&àéèêç,'@-/ ";
    if (accept.indexOf(String.fromCharCode(keyCode)) >= 0) {
        return true;
    } else {
        return false;
    }
}

function verif1(evt) {
    let keyCode = evt.which ? evt.which : evt.keyCode;
    let accept = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZéàè'ùêœç&- ";
    if (accept.indexOf(String.fromCharCode(keyCode)) >= 0) {
        return true;
    } else {
        return false;
    }
}
