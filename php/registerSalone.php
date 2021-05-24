<?php
    require_once('dbconfig.php');
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);

    if (!empty($_POST["iva"]) && !empty($_POST["nomeSalone"]) && !empty($_POST["citta"]) && !empty($_POST["indirizzo"]) && 
    !empty($_POST["sesso"]) && !empty($_POST["mail"]) && !empty($_POST["pass"])){
        $query = "";
        $error = array();

        # USERNAME
        // Controlla che l'username rispetti il pattern specificato
        if(!preg_match('/^[a-z0-9]+$/i', $_POST['iva'])) {
            $error[] = "Codice fiscale non valido";
        } else {
            $iva = mysqli_real_escape_string($conn, strtolower($_POST['iva']));
            // Cerco se l'username esiste già o se appartiene a una delle 3 parole chiave indicate
            $query = "SELECT Iva FROM salone WHERE Iva = '$iva'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Codice fiscale già utilizzato";
            }
        }
        # PASSWORD
        if (strlen($_POST["pass"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        } 

        # EMAIL
        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $mail = mysqli_real_escape_string($conn, strtolower($_POST['mail']));
            $res = mysqli_query($conn, "SELECT mail FROM salone WHERE mail = '$mail'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }

        if(count($error) == 0){
                $iva = mysqli_real_escape_string($conn, $_POST['iva']);
                $nomeSalone = mysqli_real_escape_string($conn, $_POST['nomeSalone']);
                $citta = mysqli_real_escape_string($conn, $_POST['citta']);
                $indirizzo = mysqli_real_escape_string($conn, $_POST['indirizzo']);
                $sesso = mysqli_real_escape_string($conn, $_POST['sesso']);

                $password = mysqli_real_escape_string($conn, $_POST['pass']);
                $password = password_hash($password, PASSWORD_BCRYPT);

                $fileName = $_FILES['file']['name'];
                if(!empty($fileName)){
                    $fileEstensioneArray = explode('.', $fileName);
                    $estensioneFile = $fileEstensioneArray[1]; 
                    $img = $iva . '.' . $estensioneFile;
                    $query = "INSERT INTO salone(Iva, nome, citta, indirizzo, sesso, mail, password, img) 
                        VALUES('$iva', '$nomeSalone', '$citta', '$indirizzo', '$sesso', '$mail', '$password', '$img')";
                } else{
                    $query = "INSERT INTO salone(Iva, nome, citta, indirizzo, sesso, mail, password) 
                        VALUES('$iva', '$nomeSalone', '$citta', '$indirizzo', '$sesso', '$mail', '$password')";
                }
            
            if(mysqli_query($conn, $query)){
                if(!empty($fileName)){
                    $uploadDir = '../img/copertine_saloni';
                    move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir.'/'.$img);
                }         
                echo json_encode(array('Registrazione riuscita'));
            }else{
                echo json_encode(array('Connessione al database fallita'));
            }
        }else{
            echo json_encode($error);
        }

        
    } else{
        $error = array('Riempi tutti i campi');
        echo json_encode($error);
    }

    mysqli_close($conn);
?>