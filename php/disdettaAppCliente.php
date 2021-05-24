<?php

    require_once 'dbconfig.php';
    session_start();
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    $cfCliente = $_SESSION['_barberapp_cf'];
    $data = $_GET['data'];
    $salone = $_GET['salone'];
    $query = "CALL disdiciAppuntamento('$cfCliente', '$salone', '$data')";
    $res = mysqli_query($conn, $query);

    if($res){

        echo json_encode(array('Appuntamento disdetto'));

    } else{
        echo json_encode(array('Connessione al db non riuscita.'));
    }

?>