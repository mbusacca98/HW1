<?php

    require_once 'dbconfig.php';
    session_start();
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
    if(isset($_SESSION['_barberapp_iva']) == true && isset($_GET['id'])){
        $idServizio = $_GET['id'];

        $query = "DELETE FROM servizi WHERE id=$idServizio";
        $res = mysqli_query($conn, $query);

        if($res){
            echo json_encode(array('ok'));

        } else{
            echo json_encode(array('Connessione al db non riuscita.'));
        }
    }

?>