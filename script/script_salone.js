//Event Listener
document.addEventListener("DOMContentLoaded", function(event) { 
    loadAppuntamenti();
    loadServizi();

    let temp = document.querySelectorAll('.header_mobile .fas');
    temp.forEach(element => {
        element.addEventListener('click', openMenu);
    })
    temp = document.querySelectorAll('.close i');
    temp.forEach(element => {
        element.addEventListener('click', closeMenu);
    })

    temp = document.querySelectorAll('.overlay_div > i');
    temp.forEach(element => {
        element.addEventListener('click', closeOverlay);
    })

    temp = document.querySelectorAll('header .menu > div');
    temp.forEach(element => {
        element.addEventListener('click', changePage);
    })

    document.querySelector('.addServizio > div').addEventListener('click', openAddServizio);

    document.querySelector('#addServizio').addEventListener('submit', addServizio);

    controlEmpty();
});

function controlEmpty(){
    let div = document.querySelectorAll('.div_appuntamento');
    if(div.length == 0){
        document.querySelector('#body_prenotazioni').classList.add('emptyImg');
        document.querySelector('.emptyDiv').classList.remove('hidden');
    } else{
        document.querySelector('.emptyDiv').classList.add('hidden');
        document.querySelector('#body_prenotazioni').classList.remove('emptyImg');
    }
}

function eliminaServizio(e){
    const idServizio = e.target.dataset.id;
    async function deleteData(){
        const url = "php/deleteServizio.php?id="+idServizio;

        var response = await fetch(url);

        return response.json();
    }

    deleteData().then(response => {
        if(response[0] == "ok"){
            e.target.parentElement.classList.add('hidden');
        }
    });
}

function loadServizi(){
    async function getData(){
        const url = "php/loadServiziSalone.php";

        var response = await fetch(url);

        return response.json();
    }
    

    getData().then(response => {
        if(response != "Connessione al db non riuscita."){
            response.forEach(element => {
                const table = document.querySelector('table tbody');
                let riga = document.createElement('tr');

                let arrayElement = [element[3], element[2], element[4], element[5]];
                
                for(let i=0 ; i<5 ; i++){
                    if(i == 1){
                        if(arrayElement[i] == 1){
                            let colonna = document.createElement('td');
                            let string = document.createTextNode("Capelli");
                            colonna.appendChild(string);
                            riga.appendChild(colonna);
                        } else{
                            let colonna = document.createElement('td');
                            let string = document.createTextNode("Barba");
                            colonna.appendChild(string);
                            riga.appendChild(colonna);
                        }
                    } else if(i == 4){
                        let colonna = document.createElement('td');
                        let string = document.createTextNode("Elimina");
                        colonna.dataset.id = element[0];
                        colonna.addEventListener('click', eliminaServizio);
                        colonna.appendChild(string);
                        riga.appendChild(colonna);
                    } else{
                        let colonna = document.createElement('td');
                        let string = document.createTextNode(arrayElement[i]);
                        colonna.appendChild(string);
                        riga.appendChild(colonna);
                    }
                }

                table.appendChild(riga);
            });
            
        }
    }) 
}

function addServizio(e){
    e.preventDefault();

    async function insertData(){
            const url = "php/addServizio.php";
            const form = e.target;
            const formData = new FormData(form);
            var div = document.querySelectorAll('#addServizio form input');
            div.forEach(element => {
                var name = element.name;
                var val = element.value;
                formData.append(name, val);
            });
            div = document.querySelector('#addServizio form select');
            formData.append(div.name, div.value);

            var response = await fetch(url, {
                method: "POST",
                body: formData,
            });

            return response.json();
    }
    

    insertData().then(response => {
        if(response.length > 1){
            const table = document.querySelector('table tbody');
            let riga = document.createElement('tr');
            
            for(let i=0 ; i<5 ; i++){
                if(i == 1){
                    if(response[i+1] == 1){
                        let colonna = document.createElement('td');
                        let string = document.createTextNode("Capelli");
                        colonna.appendChild(string);
                        riga.appendChild(colonna);
                    } else{
                        let colonna = document.createElement('td');
                        let string = document.createTextNode("Barba");
                        colonna.appendChild(string);
                        riga.appendChild(colonna);
                    }
                } else if(i == 4){
                    let colonna = document.createElement('td');
                    let string = document.createTextNode("Elimina");
                    colonna.dataset.id = response[i+1];
                    colonna.addEventListener('click', eliminaServizio);
                    colonna.appendChild(string);
                    riga.appendChild(colonna);
                } else{
                    console.log('ciao');
                    let colonna = document.createElement('td');
                    let string = document.createTextNode(response[i+1]);
                    colonna.appendChild(string);
                    riga.appendChild(colonna);
                }
            }

            table.appendChild(riga);
        }
    });
}

function openAddServizio(e){
    document.querySelector('#addServizio').classList.toggle('hidden');
}

function changePage(e){
    const pagina = e.currentTarget.dataset.page;
    const div = document.querySelectorAll('.body');
    const menu = document.querySelectorAll('header .menu > div');
    const url = window.location.href;
    const urlParam = window.location.search;

    if(urlParam.length == 0){
        let urlTemp = url + "?page=" + pagina;
        window.history.replaceState('', '', urlTemp);
    } else{
        let urlTemp = url.split('?');
        urlTemp = urlTemp[0] + "?page=" + pagina;
        window.history.replaceState('', '', urlTemp);
    }

    div.forEach(element => {
        if(element.dataset.page == pagina){
            element.classList.remove('hidden');
        } else{
            element.classList.add('hidden');
        }
    });

    menu.forEach(element => {
        if(element.dataset.page == pagina){
            element.classList.add('sel');
        } else{
            element.classList.remove('sel');
        }
    });

    controlEmpty();
}

function disdiciAppuntamento(e){
    const parentDiv = e.target.parentElement.parentElement;;
    const parentContainer = parentDiv.parentElement.parentElement;

    async function deleteData(){
        const data = parentDiv.querySelector('#dataApp').innerHTML;
        const cfCliente = parentDiv.parentElement.parentElement.querySelector('#nome').dataset.cf;

        const url = "php/disdettaAppSalone.php?data="+data+"&cliente="+cfCliente;

        var response = await fetch(url);

        return response.json();
    }
    

    deleteData().then(response => {
        if(response == "Appuntamento disdetto"){
            parentContainer.parentElement.classList.add('hidden');
        }
    });
}

function confermaDisdetta(e){
    let divParent = e.target.parentElement;
    e.currentTarget.classList.add('hidden');
    divParent.querySelector('.confirm').classList.remove('hidden');
    divParent.querySelector('.confirm').addEventListener('click', disdiciAppuntamento);
}

function loadAppuntamenti(){
    async function getData(){
        const url = "php/loadAppuntamentiSalone.php";

        var response = await fetch(url);

        return response.json();
    }
    

    getData().then(response => {
        if(response != "Connessione al db non riuscita."){
            response.forEach(element => {
                const dataInizio = element[0];
                const nomeCliente = element[1];
                const cognomeCliente = element[2];
                const mailCliente = element[3];
                const servizio = element[4];
                const durata = element[5];
                const prezzo = element[6];
                const cfCliente = element[7];
                const categoria = element[8];

                var template = document.querySelector("#template_appuntamento");
                var el;
                template = template.content.cloneNode(true);
        
                var p = template.querySelector(".nome_cliente");
                p.innerHTML += '<br>' + nomeCliente + ' ' + cognomeCliente;

                p = template.querySelector("#nome");
                p.textContent = nomeCliente;
                p.dataset.cf = cfCliente;
                
                p = template.querySelector("#cognome");
                p.textContent = cognomeCliente;
        
                p = template.querySelector("#mail");
                p.textContent = mailCliente;
        
                p = template.querySelector("#dataApp");
                p.textContent = dataInizio;

                p = template.querySelector("#servizioApp");
                p.textContent = servizio;

                p = template.querySelector("#durataApp");
                p.textContent = durata + 'min';

                p = template.querySelector("#prezzoApp");
                p.textContent = prezzo + '€';
        
                var arrayElement = template.querySelectorAll(".button-desc");
                arrayElement.forEach(element => {
                    element.addEventListener("click", dettagli);
                });

                if(categoria == 1){
                    template.querySelector('.div_appuntamento').style.backgroundImage = "url('img/tipi-forbici-beautyserviceanzio.jpeg')";
                } else if(categoria == 2){
                    template.querySelector('.div_appuntamento').style.backgroundImage = "url('img/rasoio_a_mano_libera.jpeg')";
                }

                template.querySelector(".disdettaApp > p").addEventListener("click", confermaDisdetta);
                
                document.querySelector(".body_all_appuntamenti").appendChild(template);

                controlEmpty();
            });
        }
    }) 
}

function loadSelectSaloniAddApp(){
    let form = document.querySelector('#addAppuntamento form');
    let selectSalone = form.querySelector('#salone');
    let selectServizi = form.querySelector('#servizioAddApp');
    let cf = document.querySelector('.addAppuntamento > div').dataset.cf;

    async function getPreferiti(){
        const url = "php/loadSaloniPreferiti.php?cf="+cf;

        var response = await fetch(url);

        return response.json();
    }

    getPreferiti().then(response => {
        if(response != "Connessione al db non riuscita."){
            response.forEach(element => {
                let optionSalone = selectSalone.querySelectorAll('option');
                let trovato = false;

                const iva = element[0];
                const nome = element[1];

                    optionSalone.forEach(element => {
                        if(element.value.localeCompare(iva) == 0){
                            trovato = true;
                        }
                    });
                
                if(trovato == false){
                    let option = document.createElement("option");
                    option.value = iva;
                    option.text = nome;
                    selectSalone.appendChild(option);
                }
            });
        }
    });
}

function loadSaloniPreferiti(){
    async function getData(){
        const cf = document.querySelector('.title p').dataset.cf;
        const url = "php/loadSaloniPreferiti.php?cf="+cf;

        var response = await fetch(url);

        return response.json();
    }

    getData().then(response => {
        if(response != "Connessione al db non riuscita."){
            response.forEach(element => {
                const pIva = element[0];
                const nome = element[1];
                const citta = element[2];
                const indirizzo = element[3];
                const sesso = element[5];
                const img = element[4];
    
                var template = document.querySelector("#template_allSaloni");
                var el;
                template = template.content.cloneNode(true);
        
                var p = template.querySelectorAll(".nome_salone");
                p.forEach(elements => {
                    elements.textContent = nome;
                });
                
                p = template.querySelector("#citta");
                p.textContent = citta;
        
                p = template.querySelector("#indirizzo");
                p.textContent = indirizzo;
        
                p = template.querySelector("#mappa");
                p.dataset.address = indirizzo + ", " + citta;
                p.addEventListener("click", initMap);
        
                p = template.querySelector("#sesso");
                p.textContent = sesso;
        
                var arrayElement = template.querySelectorAll(".button-desc");
                arrayElement.forEach(element => {
                    element.addEventListener("click", dettagliSalone);
                });
        
                arrayElement = template.querySelectorAll(".preferito");
                arrayElement.forEach(element => {
                    element.addEventListener("click", addPreferito);
                });
        
                template.querySelector('.div_salone').dataset.id = pIva;
                template.querySelector('.preferito').dataset.id = pIva;
                template.querySelector('.preferito').dataset.id_salone = pIva;
        
                template.querySelector('#qrCode').addEventListener('click', getQrCode);
                template.querySelector('#qrCode').dataset.dati = nome;
        
                template.querySelector(".div_salone").style.backgroundImage = "url('img/copertine_saloni/" + img + "')" ;
                template.querySelector('.preferito').dataset.preferito = true;
        
                document.querySelector('.body_preferiti').appendChild(template);
                
                var divPreferito = document.querySelector(".body_all_saloni .div_salone[data-id='"+pIva+"']");
                divPreferito.querySelector('.preferito').dataset.preferito = true;
            });
        }
    })
}

function dettagli(event){
    var parent = event.target.parentElement.parentElement.parentElement;
    parent.querySelector("#titleApp").classList.toggle("hidden");
    parent.querySelector("#descApp").classList.toggle("hidden");    
}

function dettagliSalone(event){
    var parent = event.target.parentElement.parentElement.parentElement;
    parent.querySelector("#title").classList.toggle("hidden");
    parent.querySelector("#desc").classList.toggle("hidden");    
}

function openMenu(){
    document.querySelector('header').style.display = "flex";
}

function closeMenu(){
    document.querySelector('header').style.display = "none";
}

function closeOverlay(events){
    let div = events.currentTarget.parentElement;
    div.classList.add('hidden');
}