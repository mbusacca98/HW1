<?php
    session_start();

    function checkAuth() {
        // Se esiste già una sessione, la ritorno, altrimenti ritorno 0
        if(isset($_SESSION['_barberapp_mail'])) {
            /*$mail = $_SESSION['_barberapp_mail'];
            $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
            $query = "SELECT * FROM cliente WHERE mail='$mail'";
            $res = mysqli_query($conn, $query);

            if(mysqli_num_rows($res) > 0){
                $entry = mysqli_fetch_assoc($res);
                mysqli_close($conn);
                return $entry);
                exit;
            }*/
            return $_SESSION['_barberapp_mail'];
        } else 
            return 0;
    }
?>