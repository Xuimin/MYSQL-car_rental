<?php

    $title = 'My Cart';

    function get_content() {

        require_once '../Controllers/connection.php';

        $query = "SELECT cart.id, cart.date_from, cart.date_to, cart.amount, cars.id AS car_id, cars.name, cars.type, categories.seater FROM cart 
        JOIN cars ON cart.car_id = cars.id
        JOIN categories ON cars.category_id = categories.id
        WHERE user_id = {$_SESSION['user_data']['id']} 
        AND isPaid = 0";

        $cart_item = mysqli_fetch_assoc(mysqli_query($cn, $query));
        // var_dump($cart_item);
        // die();
?>

<div class="container">
    <!-- ITEM IN CART -->
    <?php if(isset($cart_item)): ?>
    <div class="card purple lighten-4">
        <div class="card-content">
            <h5>
                <b><?php echo $cart_item['name']; ?></b>
            </h5>
            <p>Description: <?php echo $cart_item['type']; ?></p>
            <p><?php echo $cart_item['seater']; ?> Seaters</p>

            <p>Start date: <?php echo $cart_item['date_from']; ?></p>
            <p>End date: <?php echo $cart_item['date_to']; ?></p>
            <strong>Amount to pay: RM<?php echo $cart_item['amount']; ?></strong> <br>
            
            <a class="btn-small purple lighten-2">Delete</a>
        </div>
    </div>

    <div id="paypal-button-container" class="center-align">

    </div>

    <?php else: ?>
        <!-- NO ITEM IN CART -->
        <h3>No rented car</h3>
        <a href="/"> << Go back to homepage << </a>

    <?php endif; ?>
</div>


<script src="https://www.paypal.com/sdk/js?client-id=AXMsxlEQq6iy5YtKQllktMzh7eZtYZ6yH5bUO4D2h45dzV_t0CiNILtzPD6sSaRD8OOfXKVi0rRQ29_n"></script>

<script type="text/javascript">
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo number_format($cart_item['amount'], 2); ?>
                    }
                }]
            })
        },
        onApprove: function(data, actions) {
			return actions.order.capture().then( function(details) {
				alert("Transaction completed by " + details.payer.name.given_name);
                
                // Creating a form using javascript
                let formData = new FormData();
                formData.append('cart_id', <?php echo $cart_item['id'] ?>);
                formData.append('action', 'transaction');
                formData.append('car_id', <?php echo $cart_item['car_id']; ?>)

                fetch('../web.php', {
                    method: "POST",
                    body: formData
                }) 
                .then(res => res.text())
                .then(message => alert(message));
			})
		}
    }).render('#paypal-button-container');
</script>

<?php
    }
    require_once 'layout.php';
?>