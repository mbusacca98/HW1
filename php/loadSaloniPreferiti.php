<?php

    require_once 'dbconfig.php';
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    $idUtente = $_GET['cf'];
    $query = "SELECT s.Iva, s.nome, s.citta, s.indirizzo, s.img, s.sesso 
        FROM salone s 
        INNER JOIN saloni_preferiti sp 
        WHERE s.Iva = sp.idSalone
        AND sp.idCliente = '$idUtente'";
    $res = mysqli_query($conn, $query);

    if(mysqli_num_rows($res) > 0){
        echo json_encode(mysqli_fetch_all($res));

    } else{
        echo json_encode(array('Connessione al db non riuscita.'));
    }

?>