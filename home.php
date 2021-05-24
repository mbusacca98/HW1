<?php
    require_once 'php/checkSession.php';
    require_once 'php/dbconfig.php';
    if ($userMail = checkAuth()) {
        $logged = true;
        if($_SESSION['_barberapp_typeUser'] == "Cliente"){
            $conn1 = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
            $query1 = "SELECT * FROM cliente WHERE mail='$userMail'";
            $res1 = mysqli_query($conn1, $query1);

            if(mysqli_num_rows($res1) > 0){
                $userInfo = mysqli_fetch_assoc($res1);
                mysqli_close($conn1);
            }
        } else{
            $conn1 = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
            $query1 = "SELECT * FROM salone WHERE mail='$userMail'";
            $res1 = mysqli_query($conn1, $query1);

            if(mysqli_num_rows($res1) > 0){
                $userInfo = mysqli_fetch_assoc($res1);
                mysqli_close($conn1);
            }
        }
            
    } else{
        $logged = false;
    }
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
    <link rel="stylesheet" href="css/mhw1.css">
    <script src="script/script_home.js"></script>

</head> 
<body>
        <header>
            <div class="" id="container_header">
                <div class="title">
                    <i class="fas fa-cut"></i>
                    <p class="">BarberApp</p>
                </div>
                <div class="pc-menu">
                    <div class="close">
                        <i class="far fa-times-circle"></i>
                    </div>
                    <div>
                        <a href="#">Home</a>
                    </div>
                    <div>
                        <a href="#">Prezzi</a>
                    </div>
                    <div>
                        <a href="#">Servizi</a>
                    </div>
                    <div>
                        <a href="#">Contatti</a>
                    </div>
                    <div class="<?php if($logged===true) echo 'hidden'; ?>" id="login_button">
                        <a href="#">Login</a>
                    </div>
                    <div class="<?php if($logged===true) echo 'hidden'; ?>" id="reg_button">
                        <a href="#">Registrati</a>
                    </div>
                    <div class="username <?php if($logged===false) echo 'hidden'; ?>">
                        <i class="fas fa-user"></i>
                        <a class="<?php echo $_SESSION['_barberapp_typeUser'] == "Salone" ? "hidden" : "";?>" href="user.php"><?php if(isset($userInfo['Nome'])) echo $userInfo['Nome'];?></a>
                        <a class="<?php echo $_SESSION['_barberapp_typeUser'] == "Cliente" ? "hidden" : "";?>" href="salone.php"><?php if(isset($userInfo['nome'])) echo $userInfo['nome'];?></a>
                    </div> 
                    <div class="logout <?php if($logged===false) echo 'hidden'; ?>">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                </div>
                <div class="hamb">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </header>

        
    
        <div id="body">

            <div class="body_header">
                <div class="image_header">
                    <div class="overlay_image_header">
                        <div>
                            <i class="fas fa-calendar-check"></i>
                            <p class="desc">Aumenta la produttività del tuo salone, <br> iscriviti ora e gestisci tutti i tuoi appuntamenti da qui.</p>
                            <p class="button">ISCRIVITI ORA</p>
                        </div>
                    </div> 
                </div> 
            </div>

            <div class="offerta">
                <div>
                    <div class="image_offerta image1">
                        <div>
                            <i class="fas fa-user"></i>
                            <p>Semplicità</p>
                        </div>
                    </div>
                    <div class="desc">
                        <p>Gestisci tutto da un'unica piattaforma, <br>dagli appuntamenti al calcolo dello stipendio dei tuoi dipendenti, <br>tutto in modo facile e veloce.</p>
                        <p class="button">ISCRIVITI ORA</p>
                    </div>
                </div>
                <div>
                    <div class="image_offerta image2">
                        <div>
                            <i class="fas fa-palette"></i>
                            <p>Personalizzabile</p>
                        </div>
                    </div>
                    <div class="desc">
                        <p>Personalizzabile in ogni dettaglio, <br>aggiungi e personalizza i servizi da te offerti in base alle tue esigenze</p>
                        <p class="button">INIZIA SUBITO</p>
                    </div>
                </div>
                <div>
                    <div class="image_offerta image3">
                        <div>
                            <i class="fas fa-lock"></i>
                            <p>Sicuro</p>
                        </div>
                    </div>
                    <div class="desc">
                        <p>I tuoi dati sono al sicuro con noi!<br>Tutti i dati che inserirai nella nostra piattaforma sono protetti e criptati nei nostri database</p>
                        <p class="button">AFFIDATI A NOI</p>
                    </div>
                </div>
            </div>

            <footer>
                <div>
                    <div class="key">
                        <div>
                            <i class="fas fa-briefcase"></i>
                            <p>Professionalità</p>
                        </div>
                        <div>
                            <i class="fas fa-lock-open"></i>
                            <p>Trasparenza</p>
                        </div>
                        <div>
                            <i class="fas fa-money-bill-wave"></i>
                            <p>Economico</p>
                        </div>
                        <div>  
                            <i class="fas fa-comments"></i>
                            <p>Assistenza 24/7</p>
                        </div>
                    </div>
                    <p class="title-footer"><i class="fas fa-cut"></i> BarberApp</p>
                    <p>Matteo Busacca</p>
                    <p>Matricola: O46002032</p>
                </div>
            </footer>
        </div>

        <div class="user_overlay hidden" id="reg_overlay">
            <div>
                <p class="response hidden"></p>
                <form class="" action="php/registerSalone.php" id="registerUser" autocomplete='off' method='post' enctype="multipart/form-data">
                    <p>Registrazione</p>
                    
                    <div class="utente">
                        <p>Utente:</p>
                        <select name="utente" >
                            <option value="Cliente">Cliente</option>
                            <option value="Salone">Salone</option>
                        </select>
                    </div>

                    <div class="nome">
                        <p>Nome:</p>
                        <input type="text" name="nome">
                    </div>
                        
                    <div class="cognome">
                        <p>Cognome:</p>
                        <input type="text" name="cognome" >
                    </div>

                    <div class="ivaSalone hidden">
                        <p>Iva:</p>
                        <input type="text" name="iva">
                    </div>

                    <div class="nomeSalone hidden">
                        <p>Nome:</p>
                        <input type="text" name="nomeSalone" >
                    </div>

                    <div class="citta hidden">
                        <p>Città:</p>
                        <input type="text" name="citta">
                    </div>

                    <div class="indirizzo hidden">
                        <p>Indirizzo:</p>
                        <input type="text" name="indirizzo">
                    </div>

                    <div class="sesso hidden">
                        <p>Sesso:</p>
                        <select name="sesso" id="sesso">
                            <option value="uomo">uomo</option>
                            <option value="donna">donna</option>
                            <option value="Uomo/Donna">Uomo e Donna</option>
                        </select>
                    </div>

                    <div class="mail">
                        <p>Mail:</p>
                        <input type="text" name="mail" >
                    </div>

                    <div class="cf">
                        <p>CF:</p>
                        <input type="text" name="cf" >
                    </div>

                    <div class="password">
                        <p>Password:</p>
                        <input type="password" name="pass">
                    </div>
                    
                    <div class="imgSalone file hidden">
                        <p>Immagine:</p>
                        <input type="file" name="file" id="file" accept="image/*">
                    </div>

                    <div class="buttonForm">
                        <input class="submit" type="submit" name="submit" value="registrati" >
                        <input type="button" class="close" value="Chiudi">
                    </div>
                    
                </form>
            </div>    
        </div>
        
        <div class="user_overlay hidden" id="login_overlay">
            <div>
                <p class="response hidden"></p> 
                <form action="" id="loginUser" autocomplete='off' method='post' enctype="multipart/form-data">
                    <p>Login</p>
                    <div class="mail">
                        <p>Mail:</p>
                        <input type="text" name="mail" > 
                    </div>

                    <div class="password">
                        <p>Password:</p>
                        <input type="password" name="pass">
                    </div>
                    
                    <div class="utente">
                        <p>Utente:</p>
                        <select name="utente" >
                            <option value="Cliente">Cliente</option>
                            <option value="Salone">Salone</option>
                        </select>
                    </div>

                    <div class="buttonForm">
                        <input class="submit" type="submit" name="submit" value="login" >
                        <input type="button" class="close" value="Chiudi">
                    </div>
                    
                </form>
            </div>    
        </div>


</body>
</html>