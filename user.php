<?php
    require_once 'php/checkSession.php';
    require_once 'php/dbconfig.php';
    if ($userMail = checkAuth()) {
        if($_SESSION['_barberapp_typeUser'] !== 'Cliente'){
            header("location: home.php");
            exit;
        }
        $logged = true;
            $conn1 = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
            $query1 = "SELECT * FROM cliente WHERE mail='$userMail'";
            $res1 = mysqli_query($conn1, $query1);

            if(mysqli_num_rows($res1) > 0){
                $userInfo = mysqli_fetch_assoc($res1);
                mysqli_close($conn1);
            }
    } else{
        $logged = false;
        header("location: home.php");
        exit;
    }

    $hidden = "hidden";
    $empty = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BarberApp</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e1493c9ba5.js" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="css/user.css">
    <script src="script/script.js"></script>
    <script src="script/content.js"></script>

    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFlOKR1gNmS5gsyI6ha3j_IdL7WG9wxK4">
    </script>

</head>
<body>
    
    <header>
        
        <div>
            <div class="container-close">
                <div class="title">
                    <i class="fas fa-cut"></i>
                    <a href="home.php" class="">BarberApp</a>
                </div>

                <div class="close">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            
            
            
            <div class="title">
                <i class="fas fa-user"></i>
                <p data-cf="<?php echo $_SESSION['_barberapp_cf']?>">Ciao, <?php echo $userInfo['Nome'].' '.$userInfo['Cognome'];?></p>
            </div>
    
            <div class="menu">
                <div class="<?php echo ($_GET['page'] != 'prenotazioni' && $_GET['page'] != '') ? '' : 'sel';?>" data-page="prenotazioni">
                    <i class="fas fa-shopping-cart"></i>
                    <a>Prenotazioni</a>
                </div>
                <div class="<?php echo ($_GET['page'] != 'saloni') ? '' : 'sel';?>" data-page="saloni">
                    <i class="fas fa-star"></i>
                    <a>Saloni</a>
                </div>
            </div>
        </div>
    </header>


    <div class="body <?php echo ($_GET['page'] != 'saloni') ? $hidden : $empty;?>" id="body_saloni" data-page="saloni">
        <div class="header_mobile">
            <i class="fas fa-bars"></i>
        </div>

        <div class="all">
            <div class="title">
                <h1>Tutti i Saloni</h1>
                <div class="search">
                    <i class="fas fa-search"></i>
                    <input type="text">
                </div>
                <div class="geolocation-search">
                    <div>
                        <i class="fas fa-map-pin"></i>
                        <p>Cerca quelli vicino a te</p>
                    </div>
                    <i class="fas fa-times hidden"></i>
                </div>
            </div>
            
            <div class="body_all_saloni">

                <template id="template_allSaloni">
                    <div class="div_salone" data-id="">
                        <div class="container">
                            <div class="overlay" id="title">
                                <p class="nome_salone" id="nome_salone"></p>
                                <div class="separator"></div>
                                <p class="button-desc" id="click_dettagli">Dettagli</p>
                            </div>
                
                            <div class="overlay hidden" id="desc">
                                <p class="nome_salone"></p>
                                <div class="separator"></div>
                                <div class="desc">
                                    <div>
                                        <p>Città:</p>
                                        <p id="citta"></p>
                                    </div>
                                    <div>
                                        <p>Indirizzo:</p>
                                        <p id="indirizzo"></p>
                                    </div>
                                    <div>
                                        <p>Mappa:</p>
                                        <p data-address="" id="mappa">Clicca qui</p>
                                    </div>
                                    <div>
                                        <p>Sesso:</p>
                                        <p id="sesso"></p>
                                    </div>
                                    <div>
                                        <p>Condividi:</p>
                                        <p id="qrCode">Qr Code</p>
                                    </div>
                
                                    <div class="container-separator">
                                        <div class="separator"></div>
                                    </div>
                
                                    <p class="button-desc" id="click_nascondi_dettagli">Nascondi dettagli</p>
                                </div>
                            </div>

                            <i data-preferito="false" data-id="" class="far fa-star preferito"></i>
                        </div>
                    </div>
                </template>

            </div>
        </div>

        <div class="preferiti">
            <div class="title">
                <h1>Preferiti</h1>
            </div>

            <div class="body_preferiti">

            </div>
        </div>
    </div>

    <div class="body emptyImg <?php echo ($_GET['page'] != 'prenotazioni' && $_GET['page'] != '') ? $hidden : $empty;?>" id="body_prenotazioni" data-page="prenotazioni">
        <div class="header_mobile">
            <i class="fas fa-bars"></i>
        </div>

        <div class="all">
            <div class="title">
                <h1>Tutti i tuoi appuntamenti</h1>
            </div>

            <div class="addAppuntamento">
                <div data-cf="<?php echo $_SESSION['_barberapp_cf']?>">
                    <h1>Prendi un nuovo appuntamento <i class="fas fa-plus-square"></i></h1>
                </div>
            </div>
            
            <div class="hidden" id="addAppuntamento">
                <form action="">
                    <div>
                        <p>Saloni preferiti</p>
                        <select name="salone" id="salone" required>
                            <option value="desc">Selezione un salone</option>
                        </select>
                    </div>
                    <div>
                        <p>Data e ora</p>
                        <input type="datetime-local" name="date" id="dateAddApp" required>
                    </div>
                    <div>
                        <p>Servizio</p>
                        <select name="servizio" id="servizioAddApp" required>

                        </select>
                    </div>
                    <div>
                        <p>Prenota</p>
                        <input type="submit" name="submit" id="submitAddApp" required>
                    </div>
                </form>
                <div class="errorDiv hidden">
                    <p></p>
                </div>
            </div>

            <div class="body_all_appuntamenti" >

                <div class="emptyDiv">
                    <p>Non hai appuntamenti</p>
                </div>

                <template id="template_appuntamento">
                    <div class="div_appuntamento" data-id="">
                        <div class="container">
                            <div class="overlay" id="titleApp">
                                <p class="nome_salone" id="nome_saloneApp">apputamento presso </p>
                                <div class="separator"></div>
                                <p class="button-desc" id="click_dettagli">Dettagli</p>
                            </div>
                
                            <div class="overlay hidden" id="descApp">
                                <p class="nome_salone"></p>
                                <div class="separator"></div>
                                <div class="desc">
                                    <div>
                                        <p>Città:</p>
                                        <p id="cittaApp"></p>
                                    </div>
                                    <div>
                                        <p>Indirizzo:</p>
                                        <p id="indirizzoApp"></p>
                                    </div>
                                    <div>
                                        <p>Mappa:</p>
                                        <p data-address="" id="mappaApp">Clicca qui</p>
                                    </div>
                                    <div>
                                        <p>Servizio:</p>
                                        <p id="servizioApp"></p>
                                    </div>
                                    <div>
                                        <p>Data:</p>
                                        <p id="dataApp"></p>
                                    </div>
                                    <div>
                                        <p>Durata:</p>
                                        <p id="durataApp"></p>
                                    </div>
                                    <div>
                                        <p>Prezzo:</p>
                                        <p id="prezzoApp"></p>
                                    </div>
                                    <div class="disdettaApp">
                                        <p class="pDisdici">Disdici appuntamento</p>
                                        <p class="hidden confirm">Vuoi disdire davvero?</p>
                                    </div>
                
                                    <div class="container-separator">
                                        <div class="separator"></div>
                                    </div>
                
                                    <p class="button-desc" id="click_nascondi_dettagli">Nascondi dettagli</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </template>

            </div>
        </div>
    </div>

    <div id="maps_overlay" class="hidden overlay_div">
        <div>
            
        </div>
        <i class="far fa-times-circle"></i>
    </div>

    <div id="qrCode_overlay" class="overlay_div hidden"> 
        <img src="" alt="">
        <i class="far fa-times-circle"></i>
    </div>

</body>

</html>