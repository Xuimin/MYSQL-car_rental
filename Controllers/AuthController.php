<?php

    require_once 'connection.php';

    // Register
    function register($request) {
        global $cn;
        // var_dump($request);
        // die();

        $errors = 0;
        $fullname = $request['fullname'];
        $username = $request['username'];
        $password = $request['password'];
        $password2 = $request['password2'];

        if(strlen($username) < 8) {
            echo 'Username must be greater than 8 characters';
            $errors++;
        }

        if(strlen($password) < 8) {
            echo 'Password must be greater than 8 characters';
            $errors++;
        }

        if($password != $password2) {
            echo 'Password do not match';
            $errors++;
        }

        if($username) {
            $query = "SELECT username FROM users WHERE username = '$username'";
            $result = mysqli_fetch_assoc(mysqli_query($cn, $query));
            if($result) {
                echo 'Usename is already taken';
                $errors++;
                mysqli_close($cn);
            }
        }
        
        if($errors === 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (fullname, username, password) 
            VALUES ('$fullname', '$username', '$password')";
            mysqli_query($cn, $query);
            mysqli_close($cn);
            header('Location: /');
        }
    }

    // Login
    function login($request) {
        global $cn;
        $username = $request['username'];
        $password = $request['password'];

        $query = "SELECT * FROM users WHERE username = '$username'";
        $user = mysqli_fetch_assoc(mysqli_query($cn, $query));
        // var_dump($user);
        session_start();

        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_data'] = $user;
            $_SESSION['message'] = 'Logged in Successfully!';
            $_SESSION['class'] = 'light-green lighten-4';
            mysqli_close($cn);
            header('Location: /');
        } else {
            $_SESSION['message'] = 'Invalid Credentials!';
            $_SESSION['class'] = 'red lighten-4';
            header('Location: /');
        }
    }

    // Logout
    function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /');
    }

?>