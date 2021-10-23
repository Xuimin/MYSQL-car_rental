<?php

    require_once 'Controllers/AuthController.php';
    require_once 'Controllers/CarController.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $uri = basename($_SERVER['REQUEST_URI']); // 127.0.0.1:5000/web.php/logout
        // var_dump($uri);
        switch($uri) {
            case 'logout';
            logout();
            break;
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'];
        switch($action) {
            case 'register':
                // Do register function
                register($_POST);
                break;
            case 'login':
                login($_POST);
                break;
            case 'add_car':
                add_car($_POST);
                break;
            case 'rent_car':
                rent_car($_POST);
                break;
            case 'transaction':
                transaction($_POST);
                break;
            case 'status':
                change_status($_POST);
                break;
            case 'edit':
                edit_status($_POST);
                break;
        }
    }
?>