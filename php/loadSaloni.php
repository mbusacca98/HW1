<?php

    require_once 'dbconfig.php';
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    $query = "SELECT * FROM salone";
    $res = mysqli_query($conn, $query);

    if(mysqli_num_rows($res) > 0){

        echo json_encode(mysqli_fetch_all($res));

    } else{
        echo json_encode(array('Connessione al db non riuscita.'));
    }

?>