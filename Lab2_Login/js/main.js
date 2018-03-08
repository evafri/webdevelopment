/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: main.js
 * Desc: main JavaScript file for Laboration 2
 *
 * Eva Frisell
 * evmo1600
 * evmo1600@student.miun.se
 ******************************************************************************/
var xhr = new XMLHttpRequest();

function byId(id) {
    return document.getElementById(id);
}

function main() {

    byId("loginButton").addEventListener('click', doLogin, false);
    byId("logoutButton").addEventListener('click', doLogout, false);

    // Stöd för IE7+, Firefox, Chrome, Opera, Safari
    try {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            // code for IE6, IE5
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        else {
            throw new Error('Cannot create XMLHttpRequest object');
        }

    } catch (e) {
        alert('"XMLHttpRequest failed!' + e.message);
    }
}

window.addEventListener("load", main, false); // Connect the main function to window load event

function doLogin() {

    if (byId('uname').value != "" && byId('psw').value != "") {
        var url = "login.php";
        var uname = byId("uname").value;
        var psw = byId("psw").value;
        var vars = "username=" + uname + "&password=" + psw;

        xhr.addEventListener('readystatechange', processLogin, false);
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(vars);
    }
}

function doLogout() {

    var url = "logout.php";
    xhr.addEventListener('readystatechange', processLogout, false);
    xhr.open('POST', url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(null);
}

function processLogin() {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {

        var myResponse = JSON.parse(this.responseText);

        var message = myResponse.msg;
        if (message.toLowerCase().indexOf("Successful".toLowerCase()) !== -1) {
            if (myResponse.link_array != null) {

                debugger;
                var link1 = myResponse.link_array["Gästbok"];
                var link2 = myResponse.link_array["Medlemssida"];
/*
                var storedLink1 = sessionStorage.getItem("link1");
                var storedLink2 = sessionStorage.getItem("link2");

                debugger;
                if (!(storedLink1 && storedLink2)) {
                    sessionStorage.setItem("link1", JSON.stringify(link1));
                    sessionStorage.setItem("link2", JSON.stringify(link2));
                }

                debugger;
                var listElement = byId("link1");
                var link = document.createElement('a');
                //link.setAttribute('href', link1);
                var tmplink = JSON.parse(storedLink1);
                link.setAttribute('href', tmplink);
                link.innerHTML = "Gästbok";
                listElement.appendChild(link);

                var listElement2 = byId("link2");
                var link3 = document.createElement('a');
                //link3.setAttribute('href', link2);
                var tmplink2 = JSON.parse(storedLink2);
                link3.setAttribute('href', tmplink2);
                link3.innerHTML = "Medlemssida";
                listElement2.appendChild(link3);
*/


                if (sessionStorage.length == 0) {
                    debugger;

                    sessionStorage.setItem("link1", JSON.stringify(link1));
                    sessionStorage.setItem("link2", JSON.stringify(link2));

                    var listElement = byId("link1");
                    var link = document.createElement('a');
                    //link.setAttribute('href', link1);
                    var tmplink = JSON.parse(sessionStorage.getItem("link1"));
                    link.setAttribute('href', tmplink);
                    link.innerHTML = "Gästbok";
                    listElement.appendChild(link);

                    debugger;

                    var listElement2 = byId("link2");
                    var link3 = document.createElement('a');
                    //link3.setAttribute('href', link2);
                    var tmplink2 = JSON.parse(sessionStorage.getItem("link2"));
                    link3.setAttribute('href', tmplink2);
                    link3.innerHTML = "Medlemssida";
                    listElement2.appendChild(link3);
                }
                else {
                    debugger;
                    var listElement = byId("link1");
                    var link = document.createElement('a');
                    //link.setAttribute('href', link1);
                    var tmplink3 = JSON.parse(sessionStorage.getItem("link1"));
                    link.setAttribute('href', tmplink3);
                    link.innerHTML = "Gästbok";
                    listElement.appendChild(link);

                    var listElement2 = byId("link2");
                    var link3 = document.createElement('a');
                    //link3.setAttribute('href', link2);
                    var tmplink4 = JSON.parse(sessionStorage.getItem("link2"));
                    link3.setAttribute('href', tmplink4);
                    link3.innerHTML = "Medlemssida";
                    listElement2.appendChild(link3);
                }

                byId('logout').style.display = "block";
                byId('login').style.display = "none";

                var logoutlink = byId('logoutlink');
                if (logoutlink !== undefined && logoutlink.hasChildNodes()) {
                    logoutlink.removeChild(logoutlink.firstChild);
                }
            }
        }

        byId("status").innerHTML = message;
        //First we must remove the registered event since we use the same xhr object for login and logout
        xhr.removeEventListener('readystatechange', processLogin, false);

    }
}

function processLogout() {
    var message;
    var logoutlink;
    var link;

    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        var myResponse = JSON.parse(this.responseText);

        if (myResponse.link_array != null) {
            if (logoutlink !== null) {
                logoutlink = myResponse.link_array["Gästbok"];
                var listElement = byId("logoutlink");
                link = document.createElement('a');
                link.setAttribute('href', logoutlink);
                debugger;
                link.innerHTML = "Gästbok";
                listElement.appendChild(link);
            }
        }
        if (message != "") {
            message = myResponse.msg;
            byId("status").innerHTML = message;
        }
        //First we most remove the registered event since we use the same xhr object for login and logout
        xhr.removeEventListener('readystatechange', processLogout, false);

        byId('login').style.display = "block";
        byId('logout').style.display = "none";

        var link1 = byId('link1');
        if (link1 !== undefined && link1 !== null && link1.hasChildNodes()) {
            link1.removeChild(link1.firstChild);
        }
        var link2 = byId('link2');
        if (link2 !== undefined && link2 !== null && link2.hasChildNodes()) {
            link2.removeChild(link2.firstChild);
        }
        var username = document.getElementById("uname");
        username.value = "";
        var psw = document.getElementById("psw");
        psw.value = "";
    }

    var page;
    page = window.location.pathname;
    if (page.toLowerCase().indexOf("members".toLowerCase()) !== -1) {
        location.reload(true);
    }
    if (page.toLowerCase().indexOf("guestbook".toLowerCase()) !== -1) {
        location.reload(true);
    }
}
