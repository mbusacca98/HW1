<?php

    require_once 'dbconfig.php';
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    $idSalone = $_GET['idSalone'];
    $query = "SELECT nome FROM servizi WHERE idSalone='$idSalone'";
    $res = mysqli_query($conn, $query);

    if(mysqli_num_rows($res) > 0){

        echo json_encode(mysqli_fetch_all($res));

    } else{
        echo json_encode(array('Connessione al db non riusicta.'));
    }

?>