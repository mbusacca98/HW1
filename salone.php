<?php
    require_once 'php/checkSession.php';
    require_once 'php/dbconfig.php';

    if ($userMail = checkAuth()) {
        if($_SESSION['_barberapp_typeUser'] !== 'Salone'){
            header("location: home.php");
            exit;
        }
        $logged = true;
            $conn1 = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
            $query1 = "SELECT * FROM salone WHERE mail='$userMail'";
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
    <link rel="stylesheet" href="css/salone.css">
    <script src="script/script_salone.js"></script>
    <script src="script/content.js"></script>

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
                <p data-cf="<?php echo $_SESSION['_barberapp_cf']?>">Ciao, <?php echo $userInfo['nome'];?></p>
            </div>
    
            <div class="menu">
                <div class="<?php echo ($_GET['page'] != 'prenotazioni' && $_GET['page'] != '') ? '' : 'sel';?>" data-page="prenotazioni">
                    <i class="fas fa-shopping-cart"></i>
                    <a>Prenotazioni</a>
                </div>
                <div class="<?php echo ($_GET['page'] != 'servizi') ? '' : 'sel';?>" data-page="servizi">
                    <i class="fas fa-concierge-bell"></i>
                    <a>Servizi Offerti</a>
                </div>
            </div>
        </div>
    </header>

    <div class="body emptyImg <?php echo ($_GET['page'] != 'prenotazioni' && $_GET['page'] != '') ? $hidden : $empty;?>" id="body_prenotazioni" data-page="prenotazioni">
        <div class="header_mobile">
            <i class="fas fa-bars"></i>
        </div>

        <div class="all">
            <div class="title">
                <h1>Tutti i tuoi appuntamenti</h1>
            </div>

            <div class="body_all_appuntamenti" >

                <div class="emptyDiv">
                    <p>Non hai appuntamenti</p>
                </div>

                <template id="template_appuntamento">
                    <div class="div_appuntamento" data-id="">
                        <div class="container">
                            <div class="overlay" id="titleApp">
                                <p class="nome_cliente" id="nome_cliente">apputamento di </p>
                                <div class="separator"></div>
                                <p class="button-desc" id="click_dettagli">Dettagli</p>
                            </div>
                
                            <div class="overlay hidden" id="descApp">
                                <p class="nome_salone"></p>
                                <div class="separator"></div>
                                <div class="desc">
                                    <div>
                                        <p>Nome:</p>
                                        <p id="nome"></p>
                                    </div>
                                    <div>
                                        <p>Cognome:</p>
                                        <p id="cognome"></p>
                                    </div>
                                    <div>
                                        <p>eMail:</p>
                                        <p data-address="" id="mail">Clicca qui</p>
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
                                        <p class="pDisdici">Annulla appuntamento</p>
                                        <p class="hidden confirm">Vuoi annullarlo davvero?</p>
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

    <div class="body <?php echo ($_GET['page'] != 'servizi') ? $hidden : $empty;?>" id="body_servizi" data-page="servizi">
        <div class="header_mobile">
            <i class="fas fa-bars"></i>
        </div>

        <div class="all">
            <div class="title">
                <h1>Tutti i servizi offerti da te</h1>
            </div>

            <div class="addServizio addAppuntamento">
                <div data-cf="<?php echo $_SESSION['_barberapp_iva']?>">
                    <h1>Aggiungi un servizio <i class="fas fa-plus-square"></i></h1>
                </div>
            </div>
            
            <div class="hidden" id="addServizio">
                <form action="">
                    <div>
                        <p>Nome</p>
                        <input type="text" name="nomeServizio" id="nomeServizio">
                    </div>
                    <div>
                        <p>Categoria</p>
                        <select name="categoria" id="categoria">
                            <option value="1">Capelli</option>
                            <option value="2">Barba</option>
                        </select>
                    </div>
                    <div>
                        <p>Durata (minuti)</p>
                        <input type="number" name="durata" id="durata"> 
                    </div>
                    <div>
                        <p>Prezzo (euro)</p>
                        <input type="number" name="prezzo" id="prezzo"> 
                    </div>
                    <div>
                        <p>Aggiungi</p>
                        <input type="submit" name="submit" id="submit">
                    </div>
                </form>
                <div class="errorDiv hidden">
                    <p></p>
                </div>
            </div>

            <div class="body_all_servizi" >

                <table>
                    <tr>
                        <th>Nome Servizio</th>
                        <th>Categoria</th>
                        <th>Durata</th>
                        <th>Prezzo</th>
                        <th>Elimina</th>
                    </tr>
                </table>

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