<?php

    require_once 'dbconfig.php';
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    $idSalone = $_GET['idSalone'];
    $idCliente = $_GET['cf'];
    $query = "INSERT INTO saloni_preferiti(idCliente, idSalone) VALUES('$idCliente', '$idSalone')";
    $res = mysqli_query($conn, $query);

    if($res){
        echo json_encode(array('Insert ok'));
    } else{
        echo json_encode(array('Connessione al db non riusicta.'));
    }

?>