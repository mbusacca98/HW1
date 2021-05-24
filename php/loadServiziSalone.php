<?php

    require_once 'dbconfig.php';
    session_start();
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    if(!isset($_SESSION['_barberapp_iva'])){
        $idSalone = $_GET['iva'];
    }else{
        $idSalone = $_SESSION['_barberapp_iva'];
    }
    
    $query = "SELECT * FROM servizi WHERE idSalone = '$idSalone'";
    $res = mysqli_query($conn, $query);

    if(mysqli_num_rows($res) > 0){
        echo json_encode(mysqli_fetch_all($res));

    } else{
        echo json_encode(array('Connessione al db non riuscita.'));
    }

?>