<?php
    require_once('dbconfig.php');
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    if (!empty($_POST["nome"]) && !empty($_POST["cognome"]) && !empty($_POST["mail"]) && !empty($_POST["cf"]) && 
    !empty($_POST["pass"])){
        $query = "";
        $error = array();

        # USERNAME
        // Controlla che l'username rispetti il pattern specificato
        if(!preg_match('/^[a-z0-9]+$/i', $_POST['cf'])) {
            $error[] = "Codice fiscale non valido";
        } else {
            $cf = mysqli_real_escape_string($conn, strtolower($_POST['cf']));
            // Cerco se l'username esiste già o se appartiene a una delle 3 parole chiave indicate
            $query = "SELECT cf FROM cliente WHERE cf = '$cf'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Codice fiscale già utilizzato";
            }
        }
        # PASSWORD
        if (strlen($_POST["pass"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        } 
        /*if(!preg_match('/[a-z]+$/', $_POST['pass'])){
            $error[] = "Password non valida, deve contenere almeno: una lettera maiuscola, una lettera minuscola, un numero ed essere almeno 8 caratteri";
        }
        if(!preg_match('/[A-Z]+$/', $_POST['pass'])){
            $error[] = "Password non valida, deve contenere almeno: una lettera maiuscola, una lettera minuscola, un numero ed essere almeno 8 caratteri";
        }
        if(!preg_match('/[0-9]+$/', $_POST['pass'])){
            $error[] = "Password non valida, deve contenere almeno: una lettera maiuscola, una lettera minuscola, un numero ed essere almeno 8 caratteri";
        }*/
        # EMAIL
        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $mail = mysqli_real_escape_string($conn, strtolower($_POST['mail']));
            $res = mysqli_query($conn, "SELECT mail FROM cliente WHERE mail = '$mail'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }

        if(count($error) == 0){
            $typeUser = mysqli_real_escape_string($conn, $_POST['utente']);

            if($typeUser == 'Cliente'){
                $nome = mysqli_real_escape_string($conn, $_POST['nome']);
                $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
                
                $password = mysqli_real_escape_string($conn, $_POST['pass']);
                $password = password_hash($password, PASSWORD_BCRYPT);

                $query = "INSERT INTO cliente(CF, Nome, Cognome, Mail, Password) 
                    VALUES('$cf', '$nome', '$cognome', '$mail', '$password')";
            }
            
            if(mysqli_query($conn, $query)){
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