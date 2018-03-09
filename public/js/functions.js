//shortcut
function getObj(byId) {return document.getElementById(byId);}
    
/* notification bar functions */
function shake() {
    let x = getObj("notification-content");
    if (x.className.indexOf("shake") !== -1) x.className.replace("shake", "");
    let newone = x.cloneNode(true);
    x.parentNode.replaceChild(newone, x);
    newone.className += " shake";
}

let ttl = new Date().getTime();
function show() {
    if (getObj("notification").style.display === "none") {
        $("#notification").fadeIn("slow");
    } else shake();

    ttl = new Date().getTime() + 3500;
    setTimeout("close()", 3500);
}

function close() {
    if (new Date().getTime() - ttl > 0) {
        $("#notification").fadeOut("slow");
    } else {
        setTimeout("close()", 1000);
    }
}

function notify(msg) {
    getObj("notification-content").innerHTML = msg;
    getObj("notification").style.background = "#7ab500";
    show();
}

function warning(msg) {
    getObj("notification-content").innerHTML = msg;
    getObj("notification").style.background = "#ff8e41";
    show();
}

function error(msg) {
    getObj("notification-content").innerHTML = msg;
    getObj("notification").style.background = "#ff5050";
    show();
}