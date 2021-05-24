<?php

    require_once 'dbconfig.php';
    session_start();
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);

    $idUtente = $_SESSION['_barberapp_cf'];
    $dateTime = $_POST['date'];
    $servizio = $_POST['servizio'];
    $salone = $_POST['salone'];

    if(isset($idUtente) == true && isset($dateTime) == true && isset($servizio) == true && isset($salone) == true){

        $query = "CALL prendiAppuntamento('$idUtente', '$salone', $servizio, '$dateTime')";
        $res = mysqli_query($conn, $query);
        
        if(strlen(mysqli_error($conn)) == 0){
            if($res == true)
            echo json_encode(array("Appuntamento inserito correttamente."));
        } else{
            echo json_encode(array(mysqli_error($conn)));
        }
    } else{
        echo json_encode(array("Inserisci tutti i campi del form"));
    }

    

?>