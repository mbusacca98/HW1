<?php
    $typeUser = $_SESSION['_barberapp_typeUser'];
    function checkTypeUser($page){
        if($page == "salone"){
            if($typeUser != "Salone"){
                header("location: user.php");
            } 
        }
    }
?>