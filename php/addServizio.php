<?php

    require_once 'dbconfig.php';
    session_start();
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);

    $ivaSalone = $_SESSION['_barberapp_iva'];
    $nomeServizio = $_POST['nomeServizio'];
    $categoria = $_POST['categoria'];
    $durata = $_POST['durata'];
    $prezzo = $_POST['prezzo'];

    if(isset($ivaSalone) == true && isset($nomeServizio) == true && isset($categoria) == true && isset($durata) == true 
        && isset($prezzo) == true){

        $query = "INSERT INTO servizi(idSalone, id_categoria, nome, durata, prezzo) 
                    VALUES('$ivaSalone', '$categoria', '$nomeServizio', '$durata', '$prezzo')";
        $res = mysqli_query($conn, $query);
        
        if($res){
            echo json_encode(array($ivaSalone, $nomeServizio, $categoria, $durata, $prezzo, mysqli_insert_id($conn)));
        } else{
            echo json_encode(array(mysqli_error($conn)));
        }
    } else{
        echo json_encode(array("Inserisci tutti i campi del form"));
    }

    

?>