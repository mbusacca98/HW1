<?php

    require_once 'dbconfig.php';
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    $idUtente = $_GET['cf'];
    $idSalone = $_GET['idSalone'];
    
    $query = "DELETE FROM saloni_preferiti WHERE idSalone='$idSalone' AND idCliente='$idUtente'";

    $res = mysqli_query($conn, $query);

    if($res){

        echo json_encode(array('Deleted'));

    } else{
        echo json_encode(array('Connessione al db non riusicta.'));
    }

?>