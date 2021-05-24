<?php

    require_once 'dbconfig.php';
    session_start();
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    $ivaSalone = $_SESSION['_barberapp_iva'];
    $data = $_GET['data'];
    $cfCliente = $_GET['cliente'];
    $query = "CALL disdiciAppuntamento('$cfCliente', '$ivaSalone', '$data')";
    $res = mysqli_query($conn, $query);

    if($res){

        echo json_encode(array('Appuntamento disdetto'));

    } else{
        echo json_encode(array('Connessione al db non riuscita.'));
    }

?>