<?php

    require_once 'dbconfig.php';
    session_start();
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    $cfCliente = $_SESSION['_barberapp_cf'];
    $query = "SELECT * FROM cliente WHERE CF='$cfCliente'";
    $res = mysqli_query($conn, $query);

    if(mysqli_num_rows($res) > 0){

        echo json_encode(mysqli_fetch_all($res));

    } else{
        echo json_encode(array('Connessione al db non riuscita.'));
    }

?>