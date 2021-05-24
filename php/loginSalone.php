<?php
    require_once('dbconfig.php');
    session_start();
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    if ( !empty($_POST["mail"]) && !empty($_POST["pass"])){
        $query = "";
        $error = array();

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
        }

        if(count($error) == 0){
            $typeUser = mysqli_real_escape_string($conn, $_POST['utente']);

            if($typeUser == 'Salone'){                
                $password = mysqli_real_escape_string($conn, $_POST['pass']);

                $query = "SELECT * FROM salone WHERE mail='$mail'";
            }
            
            $res = mysqli_query($conn, $query);

            if(mysqli_num_rows($res) > 0){
                $entry = mysqli_fetch_assoc($res);
                if(password_verify($_POST['pass'], $entry['password'])){
                    $_SESSION["_barberapp_mail"] = $entry['mail'];
                    $_SESSION["_barberapp_iva"] = $entry['Iva'];
                    $_SESSION["_barberapp_typeUser"] = $typeUser;

                    mysqli_free_result($res);
                    echo json_encode(array('Login riuscito'));
                } else{
                    echo json_encode(array('Password errata'));
                }
            }else{
                echo json_encode(array('Username errata'));
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