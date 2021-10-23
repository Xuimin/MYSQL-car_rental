<?php   
    $title = 'Catalog';
    // function doesn't work in a function
    require_once 'Controllers/connection.php';
    require_once 'Controllers/CarController.php';
    date_default_timezone_set('Asia/Kuala_Lumpur');

    function get_content() {
        $cars = get_cars();
        // var_dump($cars);
        // die();

        $query = "SELECT * FROM categories";
        $result = mysqli_query($GLOBALS['cn'], $query);
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container">
    <!-- SHOW ERROR MESSAGE -->
    <?php if(isset($_SESSION['message'])): ?>
            <div class="card-panel pulse <?php echo $_SESSION['class'] ?>">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['isAdmin']): ?>
    <div class="row">
        <!-- POST RENT CAR -->
        <div class="col m6 offset-m3">
            <form method="POST"
            action="/web.php"
            enctype="multipart/form-data">

                <input type="hidden" 
                name="action" 
                value="add_car">

                <div class="input-field">
                    <input type="text" 
                    name="car_name" 
                    id="car">
                    <label for="car"
                    class="purple-text">Car Name</label>
                </div>

                <div class="input-field">
                    <input type="text" 
                    name="type" 
                    id="type">
                    <label for="type"
                    class="purple-text">Car Type</label>
                </div>

                <div class="input-field file-field">
                    <div class="btn pink lighten-3">
                        <span>File</span>
                        <input type="file" 
                        name="fileUpload[]" 
                        id="car_img"
                        multiple>
                    </div>
                    <div class="file-path-wrapper">
                        <input type="text"
                        placeholder="Please upload at least 3 images"
                        class="file-path validate">
                    </div>
                </div>

                <div class="input-field">
                    <input type="number" 
                    name="quantity" 
                    id="quantity">
                    <label for="quantity"
                    class="purple-text">Quantity</label>
                </div>

                <div class="input-field">
                    <input type="number" 
                    name="price" 
                    id="price">
                    <label for="price"
                    class="purple-text">Price</label>
                </div>

                <div class="input-field">
                    <select name="category_id">
                        <option disabled selected>Choose how many seater</option>

                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['id']?>">
                                <?php echo $category['seater']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn">
                    Add Car
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="row">
        <!-- SHOW POST RENT CAR -->
        <?php foreach($cars as $car): ?>
        <?php if($car['isActive']): ?>
        <div class="col s6">
            <div class="card">
                <!-- FRONT CARD -->
                <div class="card-image">
                    <img src="<?php echo $car['image1']?>">
                    <img src="<?php echo $car['image2']?>">
                    <img src="<?php echo $car['image3']?>">
                </div>

                <div class="card-content">
                    <span class="card-title activator">
                        <?php echo $car['name']; ?>
                        <i class="material-icons right">more_vert</i>
                    </span>

                    <p>
                        <?php 
                            foreach($categories as $category) {
                                if($category['id'] == $car['category_id']) {
                                    echo $category['seater'];
                                }
                            }
                        ?> Seater
                    </p>

                    <!-- DATE TO RENT -->
                    <?php if($car['quantity'] > 0): ?>
                        <?php if(isset($_SESSION['user_data']) && !$_SESSION['user_data']['isAdmin']): ?>
                            
                        <a class="waves-effect waves-light btn modal-trigger"
                        href="#modal-<?php echo $car['id']?>">Rent this car</a>

                        <!-- MODAL DATE TO RENT -->
                        <div class="modal"
                        id="modal-<?php echo $car['id']?>">
                            <div class="modal-content">
                                <h4>Rental Date</h4>

                                <form method="POST"
                                action="/web.php">
                                    <input type="hidden" 
                                    name="action" 
                                    value="rent_car">

                                    <input type="hidden" 
                                    name="car_id" 
                                    value="<?php echo $car['id']?>">

                                    <input type="hidden" 
                                    name="price" 
                                    value="<?php echo $car['price']?>">

                                    <label for="">Start date: </label>
                                    <input type="date"
                                    name="start"
                                    min="<?php echo date('Y-m-d')?>">

                                    <label for="">End date: </label>
                                    <input type="date"
                                    name="end">

                                    <button class="btn">Confirm</button>

                                    <a href="#" 
                                    class="btn modal-close waves-pink btn-flat" 
                                    style="background-color: lightgrey">Close</a>
                                </form>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <span>Out of Stock</span>
                    <?php endif;?>
                    <a href="/Views/car_details.php?id=<?php echo $car['id'];?>">View Details</a>
                </div>

                <!-- BACK CARD -->
                <div class="card-reveal">
                    <span class="card-title">
                        <?php echo $car['name']; ?>
                        <i class="material-icons right">close</i>
                    </span>
                    
                    <p>Description: <?php echo $car['type']; ?></p>
                    <p>Price: RM <?php echo $car['price']; ?></p>
                    <p>Total Quantity Available: <?php echo $car['quantity']; ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php
    }
    require_once 'Views/layout.php'
?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let card = document.querySelector('.card-panel');
        setTimeout(() => {
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['class']); ?>
            card.classList.toggle('hide');
        }, 2000)

        let elems = document.querySelector('select');
        let instances = M.FormSelect.init(elems, {})
        
        let modals = document.querySelectorAll('.modal')
        let modalInstances = M.Modal.init(modals, {})
    })
</script>