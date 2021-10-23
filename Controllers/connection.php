<?php

    $cn = mysqli_connect('localhost', 'root', '', 'car_rental');

    if(mysqli_connect_errno()) {
        echo 'Failed to connect to MYSQL' . mysqli_connect_error();
        die();
    }
?>