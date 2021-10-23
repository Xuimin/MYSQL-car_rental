<?php
    $title = 'Transactions';

    function get_content() {
        require_once '../Controllers/connection.php';
        $query = "SELECT transactions.*, cart.car_id, cart.date_from, cart.date_to, cart.amount, cars.name 
        FROM transactions 
        JOIN cart ON transactions.cart_id = cart.id 
        JOIN cars ON cart.car_id = cars.id
        WHERE cart.user_id = {$_SESSION['user_data']['id']}";
        $result = mysqli_query($cn, $query);
        $transaction = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // var_dump($transaction);
?>

<div class="container">
    <?php foreach($transaction as $transaction): ?>
    <div class="card-panel purple lighten-4">
        <h4><?php echo $transaction['name']; ?></h4>
        <h6>Date Start: <?php echo $transaction['date_from']; ?></h6>
        <h6>Date End: <?php echo $transaction['date_to']; ?></h6>

        <strong>Amount: RM<?php echo $transaction['amount']; ?></strong> <br>
        <small>Payment Date: <?php echo $transaction['payment_date']; ?></small>
    </div>
    <?php endforeach; ?>
</div>

<?php
    }
    require_once 'layout.php'
?>
