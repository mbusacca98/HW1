//Event Listener
document.addEventListener("DOMContentLoaded", function(event) { 
    document.querySelector('header .hamb i').addEventListener("click", apriPcMenu);
    document.querySelector('header .close i').addEventListener("click", closePcMenu);

    document.querySelector('#reg_button').addEventListener("click", open_reg);
    document.querySelector('#registerUser .buttonForm .close').addEventListener('click', closeFormRegister);

    document.querySelector('#login_button').addEventListener("click", open_login);
    document.querySelector('#loginUser .buttonForm .close').addEventListener('click', closeFormLogin);

    document.querySelector('#loginUser .mail input').addEventListener('blur', checkMailLogin);
    document.querySelector('#loginUser .password input').addEventListener('blur', checkPasswordLogin);

    document.querySelector('#registerUser .nome input').addEventListener('blur', checkName);
    document.querySelector('#registerUser .cognome input').addEventListener('blur', checkName);
    document.querySelector('#registerUser .mail input').addEventListener('blur', checkMail);
    document.querySelector('#registerUser .cf input').addEventListener('blur', checkCf);
    document.querySelector('#registerUser .password input').addEventListener('blur', checkPassword);
    document.querySelector('#registerUser .ivaSalone input').addEventListener('blur', checkName);
    document.querySelector('#registerUser .citta input').addEventListener('blur', checkName);
    document.querySelector('#registerUser .nomeSalone input').addEventListener('blur', checkName);
    document.querySelector('#registerUser .indirizzo input').addEventListener('blur', checkName);

    document.querySelector('#registerUser').addEventListener('submit', register);
    document.querySelector('#loginUser').addEventListener('submit', login);
    document.querySelector('.logout > i').addEventListener('click', logout);

    document.querySelector('#reg_overlay form div.utente select').addEventListener('blur', selectRegister);

});

function login(e){
    const user = e.target.querySelector('select').value;
    e.preventDefault;
    console.log(user);
    if(user.localeCompare('Cliente') == 0){
        loginUser(e);
    } else{
        loginSalone(e);
    }
}

function register(e){
    const user = e.target.querySelector('select').value;
    e.preventDefault;
    if(user.localeCompare('Cliente') == 0){
        registerUser(e);
    } else{
        registerSalone(e);
    }
}

function loginSalone(event){
    event.preventDefault();
    const form = event.currentTarget;
    if(checkFormLogin){
        async function postData(){
            const url = "php/loginSalone.php";
            const formData = new FormData(form);
            var div = document.querySelectorAll('#loginUser input');
            div.forEach(element => {
                var name = element.name;
                var val = element.value;
                formData.append(name, val);
            });
            div = document.querySelector('#loginUser select');
            formData.append(div.name, div.value);

            var response = await fetch(url, {
                method: "POST",
                body: formData,
            });

            return response.json();
        }
        

        postData().then(response => {
            document.querySelector('#loginUser').classList.add('hidden');
            document.querySelector('#login_overlay .response').classList.remove('hidden');
            document.querySelector('#login_overlay .response').textContent = response[0];

            if(response[0] === "Login riuscito"){
                setTimeout(reloadHome, 3000);
            } else{
                setTimeout(reloadForm, 3000);
            }

            function reloadForm(){
                document.querySelector('#loginUser').classList.remove('hidden');
                document.querySelector('#login_overlay .response').classList.add('hidden');
            }

            function reloadHome(){
                location.reload();
            }
        }) 
    }
}

function registerSalone(event){
    event.preventDefault();
    const form = event.currentTarget;
    //checkForm('Salone')
    if(1){
        async function postData(){
            document.querySelector('#registerUser .submit').value = "Registrazione in corso..."
            const url = "php/registerSalone.php";
            let formData = new FormData(form);
            var div = document.querySelectorAll('#registerUser input');
            div.forEach(element => {
                if(element.type == 'file'){
                    var name = 'file';
                    var val = element.files[0];
                    formData.append(name, val);
                } else{
                    var name = element.name;
                    var val = element.value;
                    formData.append(name, val);
                }
            });
            console.log(formData);
            div = document.querySelectorAll('#registerUser select');
            div.forEach(element => {
                formData.append(element.name, element.value);
            });
            var response = await fetch(url, {
                method: "POST",
                body: formData,
            });

            return response.json();
        }
        

        postData().then(response => {
            document.querySelector('#registerUser').classList.add('hidden');
            document.querySelector('#reg_overlay .response').classList.remove('hidden');
            document.querySelector('#reg_overlay .response').textContent = response[0];

            if(response[0] === "Registrazione riuscita"){
                setTimeout(reloadHome, 3000);
            } else{
                setTimeout(reloadForm, 3000);
            }

            function reloadForm(){
                document.querySelector('#registerUser').classList.remove('hidden');
                document.querySelector('#reg_overlay .response').classList.add('hidden');
            }

            function reloadHome(){
                location.reload();
            }
        }) 
    }
    
}

function selectRegister(e){
    const formDiv = document.querySelector('#reg_overlay form');
    if(e.target.value.localeCompare('Cliente') == 0){
        formDiv.querySelector('.nome').classList.remove('hidden');
        formDiv.querySelector('.cognome').classList.remove('hidden');
        formDiv.querySelector('.cf').classList.remove('hidden');
        formDiv.querySelector('.ivaSalone').classList.add('hidden');
        formDiv.querySelector('.nomeSalone').classList.add('hidden');
        formDiv.querySelector('.imgSalone').classList.add('hidden');
        formDiv.querySelector('.indirizzo').classList.add('hidden');
        formDiv.querySelector('.citta').classList.add('hidden');
        formDiv.querySelector('.sesso').classList.add('hidden');
    } else if(e.target.value.localeCompare('Salone') == 0){
        formDiv.querySelector('.nome').classList.add('hidden');
        formDiv.querySelector('.cognome').classList.add('hidden');
        formDiv.querySelector('.cf').classList.add('hidden');
        formDiv.querySelector('.ivaSalone').classList.remove('hidden');
        formDiv.querySelector('.nomeSalone').classList.remove('hidden');
        formDiv.querySelector('.imgSalone').classList.remove('hidden');
        formDiv.querySelector('.indirizzo').classList.remove('hidden');
        formDiv.querySelector('.citta').classList.remove('hidden');
        formDiv.querySelector('.sesso').classList.remove('hidden');
    }

    let inputForm = formDiv.querySelectorAll('input');
    inputForm.forEach(element => {
        if(element.value.localeCompare('Chiudi') != 0 && element.value.localeCompare('registrati') != 0){
            element.value = "";
            element.classList.remove('ok');
            element.classList.remove('error');
            formStatus = {};
        }
    });
    
}

function logout(){
    window.location.href = 'php/logout.php';
}

function loginUser(event){
    event.preventDefault();
    const form = event.currentTarget;
    if(checkFormLogin){
        async function postData(){
            const url = "php/loginUser.php";
            const formData = new FormData(form);
            var div = document.querySelectorAll('#loginUser input');
            div.forEach(element => {
                var name = element.name;
                var val = element.value;
                formData.append(name, val);
            });
            div = document.querySelector('#loginUser select');
            formData.append(div.name, div.value);

            var response = await fetch(url, {
                method: "POST",
                body: formData,
            });

            return response.json();
        }
        

        postData().then(response => {
            document.querySelector('#loginUser').classList.add('hidden');
            document.querySelector('#login_overlay .response').classList.remove('hidden');
            document.querySelector('#login_overlay .response').textContent = response[0];

            if(response[0] === "Login riuscito"){
                setTimeout(reloadHome, 3000);
            } else{
                setTimeout(reloadForm, 3000);
            }

            function reloadForm(){
                document.querySelector('#loginUser').classList.remove('hidden');
                document.querySelector('#login_overlay .response').classList.add('hidden');
            }

            function reloadHome(){
                location.reload();
            }
        }) 
    }
    
}

function checkPasswordLogin(event){
    const input = event.currentTarget;
    var pass = input.value;
    var typeUser = document.querySelector('#loginUser .utente select').value;

        var testPattern = /[a-z]/g;
        var testPattern1 = /[A-Z]/g;    
        var testPattern2 = /[0-9]/g;

        if(testPattern.test(pass) && testPattern1.test(pass) && testPattern2.test(pass) && pass.length >= 8){
            input.classList.add('ok');
            input.classList.remove('error');
            formStatus[input.name] = true;
        } else{
            alert('Password non valida, deve contenere almeno: una lettera maiuscola, una lettera minuscola, un numero ed essere almeno 8 caratteri'); 
            input.classList.add('error');
            input.classList.remove('ok');
            formStatus[input.name] = false;
        }
    checkFormLogin();
}

function checkFormLogin(){
    if(Object.keys(formStatusLogin).length == 2){
        if(!Object.keys(formStatusLogin).includes(false)){
            document.querySelector('#loginUser .submit').disabled = false;
            return true;
        }
    }
}

function checkMailLogin(event){
    var emailPattern = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
    const input = event.currentTarget;
    var mail = input.value;
    var typeUser = document.querySelector('#loginUser .utente select').value;

        if(!emailPattern.test(mail)){
            alert('Email non valida');
            input.classList.add('error');
            input.classList.remove('ok');
            formStatusLogin[input.name] = false;
        } else{
            input.classList.remove('error');
            input.classList.add('ok');
            formStatusLogin[input.name] = true;
        }
    checkFormLogin();
}

function closeFormLogin(e){
    document.querySelector('#login_overlay').classList.add('hidden');
}

function open_login(){
    document.querySelector('#login_overlay').classList.remove('hidden');
    closePcMenu();
}

function closeFormRegister(e){
    document.querySelector('#reg_overlay').classList.add('hidden');
}

function registerUser(event){
    event.preventDefault();
    const form = event.currentTarget;
    if(checkForm('Cliente')){
        async function postData(){
            document.querySelector('#registerUser .submit').value = "Registrazione in corso..."
            const url = "php/registerUser.php";
            let formData = new FormData(form);
            var div = document.querySelectorAll('#registerUser input');
            div.forEach(element => {
                var name = element.name;
                var val = element.value;
                formData.append(name, val);
            });
            div = document.querySelector('#registerUser select');
            formData.append(div.name, div.value);
            console.log(formData);
            var response = await fetch(url, {
                method: "POST",
                body: formData,
            });

            return response.json();
        }
        

        postData().then(response => {
            document.querySelector('#registerUser').classList.add('hidden');
            document.querySelector('#reg_overlay .response').classList.remove('hidden');
            document.querySelector('#reg_overlay .response').textContent = response[0];

            if(response[0] === "Registrazione riuscita"){
                setTimeout(reloadHome, 3000);
            } else{
                setTimeout(reloadForm, 3000);
            }

            function reloadForm(){
                document.querySelector('#registerUser').classList.remove('hidden');
                document.querySelector('#reg_overlay .response').classList.add('hidden');
            }

            function reloadHome(){
                location.reload();
            }
        }) 
    }
    
}

var formStatus = {};
var formStatusLogin = {};

function checkForm(typeUser){
    if(typeUser.localeCompare('Salone') == 0){
        if(Object.keys(formStatus).length == 6){
            if(!Object.keys(formStatus).includes(false)){
                document.querySelector('#registerUser .submit').disabled = false;
                return true;
            }
        }
    } else if(typeUser.localeCompare('Cliente') == 0){
        if(Object.keys(formStatus).length == 5){
            if(!Object.keys(formStatus).includes(false)){
                document.querySelector('#registerUser .submit').disabled = false;
                return true;
            }
        }
    }
}

function checkName(event){
    const input = event.currentTarget;

    if(input.value.length > 0){
        formStatus[input.name] = true;
        input.classList.remove('error');
        input.classList.add('ok');
    } else{
        formStatus[input.name] = false;
        input.classList.add('error');
        input.classList.remove('ok');
        alert('Il campo ' + input.name + ' non può essere vuoto');
    }
    checkForm(document.querySelector('#registerUser .utente select').value);
}

function checkMail(event){
    var emailPattern = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
    const input = event.currentTarget;
    var mail = input.value;
    var typeUser = document.querySelector('#registerUser .utente select').value;

    if(1){
        if(!emailPattern.test(mail)){
            alert('Email non valida');
            input.classList.add('error');
            input.classList.remove('ok');
            formStatus[input.name] = false;
        } else{
            const checkMailVar = fetch("php/check_email.php?typeUser=" + encodeURIComponent(typeUser.toLowerCase()) + "&email=" + encodeURIComponent(mail.toLowerCase()))
                .then(fetchResponse)
                .then(checkJsonEmail);

            const ifCheckMail = async () => {
                const result = await checkMailVar;

                if(result){
                    input.classList.add('ok');
                    input.classList.remove('error');
                    formStatus[input.name] = true;
                } else{
                    alert("E' già presente un cliente con questa mail");
                    input.classList.add('error');
                    input.classList.remove('ok');
                    formStatus[input.name] = false;
                } 
            }

            ifCheckMail();
        }
    }
    checkForm(document.querySelector('#registerUser .utente select').value);
}

function checkCf(event){
    const input = event.currentTarget;
    var cf = input.value;
    var cfPattern = /^[a-z0-9]+$/i;
    var typeUser = document.querySelector('#registerUser .utente select').value;

    if(typeUser == "Cliente"){
        if(!cfPattern.test(cf)){
            alert('Codice Fiscale non valido, può contenere solo caratteri alfanumerici');
            input.classList.add('error');
            input.classList.remove('ok');
            formStatus[input.name] = false;
        } else{
            const checkCfVar = fetch("php/check_cf.php?typeUser=" + encodeURIComponent(typeUser.toLowerCase()) + "&cf=" + encodeURIComponent(cf.toLowerCase()))
                .then(fetchResponse)
                .then(checkJsonCf);
            
            const ifCheckCf = async () => {
                const result = await checkCfVar;

                if(result){
                    input.classList.add('ok');
                    input.classList.remove('error');
                    formStatus[input.name] = true;
                } else{
                    alert("E' già presente un cliente con questo codice fiscale");
                    input.classList.add('error');
                    input.classList.remove('ok');
                    formStatus[input.name] = false;
                } 
            }

            ifCheckCf();
        }
    }
    checkForm(document.querySelector('#registerUser .utente select').value);
}

function checkPassword(event){
    const input = event.currentTarget;
    var pass = input.value;
    var typeUser = document.querySelector('#registerUser .utente select').value;

    if(1){
        var testPattern = /[a-z]/g;
        var testPattern1 = /[A-Z]/g;
        var testPattern2 = /[0-9]/g;

        if(testPattern.test(pass) && testPattern1.test(pass) && testPattern2.test(pass) && pass.length >= 8){
            input.classList.add('ok');
            input.classList.remove('error');
            formStatus[input.name] = true;
        } else{
            alert('Password non valida, deve contenere almeno: una lettera maiuscola, una lettera minuscola, un numero ed essere almeno 8 caratteri'); 
            input.classList.add('error');
            input.classList.remove('ok');
            formStatus[input.name] = false;
        }
    }
    checkForm(document.querySelector('#registerUser .utente select').value);
}

async function checkJsonCf(json){
    if(json.exist){
        //alert("E' già presente un cliente con questo codice fiscale");
        return false;
    } else{
        return true;
    }
}

async function fetchResponse(response){
    if(!response.ok) return null;
    return response.json();
}

async function checkJsonEmail(json){
    if(json.exist){
        //alert("E' già presente un cliente con questa mail");
        return false;
    } else{
        return true;
    }
}

function open_reg(){
    document.querySelector('#reg_overlay').classList.remove('hidden');
    closePcMenu();
}

function apriPcMenu(){
    document.querySelector('header .title').style.display = 'none';
    document.querySelector('header .hamb').classList.add('hidden');
    document.querySelector('header .pc-menu').classList.add('pc-menu-showMobile');
}

function closePcMenu(){
    document.querySelector('header .title').style.display = 'flex';
    document.querySelector('header .hamb').classList.remove('hidden');
    document.querySelector('header .pc-menu').classList.remove('pc-menu-showMobile');
}