<?php
    
    require_once 'connection.php'; 
    date_default_timezone_set('Asia/Kuala_Lumpur');

    // ADD CARS
    function add_car($request) {
        global $cn;

        // var_dump($_FILES['fileUpload']);
        // die();

        // var_dump($request);

        $name = $request['car_name'];
        $type = $request['type'];
        $quantity = $request['quantity'];
        $price = $request['price'];
        $category_id = $request['category_id'];

        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $upload_dir = "/Public/";
        $image1 = '';
        $image2 = '';
        $image3 = '';

        $errors = 0;

        if(strlen($name) < 1) {
            echo 'Please input car name<br>';
            $errors++;
        }
        
        if(strlen($type) < 1) {
            echo 'Please input car type<br>';
            $errors++;
        }

        if(intval($price) < 1 || intval($quantity) < 1) {
            echo 'Please input more than 1<br>';
            $errors++;
        }

        if(!isset($category_id)) {
            echo 'Please select how many seaters<br>';
            $errors++;
        }

        if(count($_FILES['fileUpload']['name']) !== 3) {
            echo 'Please upload 3 images<br>';
            $errors++;
        } else {
            $image1 = $upload_dir.$_FILES['fileUpload']['name'][0];
            $image2 = $upload_dir.$_FILES['fileUpload']['name'][1];
            $image3 = $upload_dir.$_FILES['fileUpload']['name'][2];
            // /Public/121321425image.jpg;

            foreach($_FILES['fileUpload']['name'] as $i => $val) {
                $file_name = $_FILES['fileUpload']['name'][$i];
                $temp_name = $_FILES['fileUpload']['tmp_name'][$i];
                $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
                
                // $_SERVER['DOCUMENT_ROOT'] = 127.0.0.1
                if(in_array($file_type, $extensions)) {
                    move_uploaded_file($temp_name, $_SERVER['DOCUMENT_ROOT'].$upload_dir.$file_name);
                } else {
                    echo 'File type is not supported';
                    $errors++;
                }
            }
        }

        if($errors === 0) {
            $query = "INSERT INTO cars (name, type, image1, image2, image3, quantity, price, category_id)
            VALUES ('$name', '$type', '$image1', '$image2', '$image3', $quantity, $price, $category_id)";

            session_start();
            mysqli_query($cn, $query);
            mysqli_close($cn);

            $_SESSION['message'] = 'Car added successfully';
            $_SESSION['class'] = 'light-green lighten-4';
            header('Location: /');
        }
    }

    // SHOW CARS
    function get_cars() {
        global $cn;
        // echo '<pre>';
        // var_dump($GLOBALS);
        // echo '</pre>';
        // die();
        
        $query = "SELECT * FROM cars";
        $result = mysqli_query($cn, $query);
        $cars = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $cars;
    }

    // RENT CAR
    function rent_car($request) {
        global $cn;
        session_start();

        $car_id = $request['car_id'];
        $price = $request['price'];
        $start_date = $request['start'];
        $end_date = $request['end'];
        $user_id = $_SESSION['user_data']['id'];
        $amount = intval($price) * (strtotime($end_date) - strtotime($start_date)) / 86400;
        // strtotime return in seconds format one day have 86400 seconds


        if(strtotime($start_date) >= strtotime($end_date)) {
            echo 'Start date should not be greater than or equal to the end date';
            return;
        }

        $search = "SELECT * FROM cart WHERE user_id = $user_id AND isPaid = 0";
        $has_pending = mysqli_fetch_assoc(mysqli_query($cn, $search));

        // If there is a pending record (isPaid = 0) then dont allow the user to rent this car
        // else rent the car and add it on the cart table
        if(isset($has_pending)) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = "You are allowed to rent one car each time";
            header('Location: /');

        } else {
            $query = "INSERT INTO cart (user_id, car_id, date_from, date_to, amount) VALUES ($user_id, $car_id, '$start_date', '$end_date', $amount)";

            mysqli_query($cn, $query);
            mysqli_close($cn);
            
            $_SESSION['class'] = 'light-green lighten-4';
            $_SESSION['message'] = "Car rented successfully";
            header('Location: /');
        }
    }

    // TRANSACTION / PAYMENTT
    function transaction($request) {
        global $cn;
        $date = date('Y-m-d');
        $cart_id = $request['cart_id'];
        $car_id = $request['car_id'];
        $query1 = "UPDATE cart SET isPaid = 1 WHERE id = $cart_id";
        mysqli_query($cn, $query1);

        $query2 = "INSERT INTO transactions(cart_id, payment_date) VALUES ($cart_id, '$date')";
        mysqli_query($cn, $query2);

        $query3 = "UPDATE cars SET quantity = quantity - 1 WHERE id = $car_id";
        mysqli_query($cn, $query3);

        mysqli_close($cn);
        echo 'Transaction completed';
    }

    function change_status($request) {
        global $cn;
        $car_id = $request['id'];
        $query = "UPDATE cars SET isActive = 0 WHERE id = $car_id";

        mysqli_query($cn, $query);
        mysqli_close($cn);
        header('Location: /');
    }
    
    function edit_status($request) {
        global $cn;
        session_start();
        $id = $request['id'];
        // var_dump($id);

        $name = $request['car_name'];
        $type = $request['type'];
        $quantity = $request['quantity'];
        $price = $request['price'];
        $category_id = $request['category_id'];

        
        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $upload_dir = "/Public/";
        $image1 = '';
        $image2 = '';
        $image3 = '';

        $errors = 0;

        if(strlen($name) < 1 || strlen($type) < 1) {
            $_SESSION['class'] = "red lighten-4";
            $_SESSION['message'] = 'Please do not leave an empty input';
            $errors++;
            header('Location:' . $_SERVER['HTTP_REFERER']);
            
        } 
        if($price < 1 || intval($quantity < 1)) {
            $_SESSION['class'] = "red lighten-4";
            $_SESSION['message'] = 'Please input a value more than 1';
            $errors++;
            header('Location:' . $_SERVER['HTTP_REFERER']);

        } 
        if (!isset($category_id)) {
            $_SESSION['class'] = "red lighten-4";
            $_SESSION['message'] = 'Please select how many seater';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

        $image1 = $upload_dir.$_FILES['fileUpload']['name'][0];
        $image2 = $upload_dir.$_FILES['fileUpload']['name'][1];
        $image3 = $upload_dir.$_FILES['fileUpload']['name'][2];
        // var_dump($_FILES);
        // die();

        foreach($_FILES['fileUpload']['name'] as $i => $val) {
            $file_name = $_FILES['fileUpload']['name'][$i];
            $temp_name = $_FILES['fileUpload']['tmp_name'][$i];
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
            
            if(in_array($file_type, $extensions)) {
                move_uploaded_file($temp_name, $_SERVER['DOCUMENT_ROOT'].$upload_dir.$file_name);
            } else {
                $image1 = $request['image1'];
                $image2 = $request['image2'];
                $image3 = $request['image3'];
            }
        }

        var_dump($request);
        if($errors === 0) {
            $query = "UPDATE cars SET name = '$name', type = '$type', quantity = $quantity, price = $price, category_id = $category_id, image1 = '$image1', image2 = '$image2', image3 = '$image3' WHERE id = $id";
        
            mysqli_query($cn, $query);
            mysqli_close($cn);
        
            $_SESSION['class'] = 'light-green lighten-4';
            $_SESSION['message'] = 'Car was successfully edited';
        
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
?>
