<?php
    require_once('dbconfig.php');

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);

    $email = mysqli_real_escape_string($conn, $_GET['cf']);
    $typeUser = mysqli_real_escape_string($conn, $_GET['typeUser']);

    $query = "";

    if($typeUser == 'cliente'){
        $query = "SELECT cf FROM cliente WHERE cf = '$email'";
    }

    $res = mysqli_query($conn, $query);

    $json = json_encode(array('exist' => mysqli_num_rows($res) > 0 ? true : false));

    echo $json;

    mysqli_close($conn);
?>