<?php

    require_once 'dbconfig.php';
    session_start();
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    $ivaSalone = $_SESSION['_barberapp_iva'];
    $query = "CALL appSalone('$ivaSalone')";
    $res = mysqli_query($conn, $query);

    if(mysqli_num_rows($res) > 0){

        echo json_encode(mysqli_fetch_all($res));

    } else{
        echo json_encode(array('Connessione al db non riuscita.'));
    }

?>