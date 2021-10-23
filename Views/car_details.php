<?php
    $title = 'Car Details';

    function get_content() {
        require_once '../Controllers/connection.php';
        $id = $_GET['id'];
        // var_dump($id);
        $query = "SELECT * FROM cars WHERE id = $id";
        $car = mysqli_fetch_assoc(mysqli_query($cn, $query));

        $query2 = "SELECT * FROM categories";
        $result = mysqli_query($cn, $query2);
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
?>

<div class="container">
    <!-- SHOW ERROR MESSAGE -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="card-panel pulse <?php echo $_SESSION['class'] ?>" id="card-panel">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>

    <!-- SHOW IMAGE -->
    <div class="carousel">
        <a href="#one!" 
        class="carousel-item">
            <img src="<?php echo $car['image1']; ?>" alt="">
        </a>
        <a href="#two!" 
        class="carousel-item">
            <img src="<?php echo $car['image2']; ?>" alt="">
        </a>
        <a href="#three!" 
        class="carousel-item">
            <img src="<?php echo $car['image3']; ?>" alt="">
        </a>
    </div>
    <div class="card-panel pink lighten-4">
        <h4><?php echo $car['name']; ?></h4>
        <span><?php echo $car['type']; ?></span><br>

        <!-- EDIT BUTTON -->
        <button data-target="modalEdit"
        class="btn blue modal-trigger">Edit</button>

        <!-- DELETE/HIDE -->
        <form action="/web.php" 
        method="POST">
            <input type="hidden" 
            name="id" 
            value="<?php echo $car['id']?>">

            <input type="hidden" 
            name="action" 
            value="status">

            <button class="btn red darken-3">Delete</button>
        </form>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal" id="modalEdit">
    <div class="modal-content">
        <form action="../web.php"
        method="POST"
        enctype="multipart/form-data">
            <input type="hidden"
            name="action"
            value="edit">

            <input type="hidden"
            name="id" 
            value="<?php echo $car['id']?>">

            <div class="input-field">
                <input type="text" 
                name="car_name" 
                id="car"
                value=<?php echo $car['name']?>>
                <label for="car"
                class="purple-text">Car Name</label>
            </div>

            <div class="input-field">
                <input type="text" 
                name="type" 
                id="type"
                value="<?php echo $car['type'] ?>">
                <label for="type"
                class="purple-text">Car Type</label>
            </div>

            <div class="input-field file-field">
                <div class="btn pink lighten-3">
                    <span>File</span>
                    <input type="file" 
                    name="fileUpload[]" 
                    id="car_img">
                </div>
                <div class="file-path-wrapper">
                    <input type="text"
                    class="file-path validate"
                    placeholder="Image1"
                    name="image1"
                    value="<?php echo $car['image1'] ?>">
                </div>
            </div>

            <div class="input-field file-field">
                <div class="btn pink lighten-3">
                    <span>File</span>
                    <input type="file" 
                    name="fileUpload[]" 
                    id="car_img"
                    >
                </div>
                <div class="file-path-wrapper">
                    <input type="text"
                    class="file-path validate"
                    placeholder="Image2"
                    name="image2"
                    value="<?php echo $car['image2'] ?>">
                </div>
            </div>

            <div class="input-field file-field">
                <div class="btn pink lighten-3">
                    <span>File</span>
                    <input type="file" 
                    name="fileUpload[]" 
                    id="car_img">
                </div>
                <div class="file-path-wrapper">
                    <input type="text"
                    class="file-path validate"
                    placeholder="Image3"
                    name="image3"
                    value="<?php echo $car['image3'] ?>">
                </div>
            </div>

            <div class="input-field">
                <input type="number"                     
                name="quantity" 
                id="quantity"
                value="<?php echo $car['quantity'] ?>">
                <label for="quantity"
                class="purple-text">Quantity</label>
            </div>

            <div class="input-field">
                <input type="number" 
                name="price" 
                id="price"
                value="<?php echo $car['price'] ?>">
                <label for="price"
                class="purple-text">Price</label>
            </div>

            <label>Number of Seaters</label>
                <select class="browser-default" name="category_id">
                    <option value="<?php echo $car['category_id']?>" disabled selected>Choose your option</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?php echo $category['id']?>">
                            <?php echo $category['seater']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            <button class="btn blue lighten-1">Confirm</a>
        </form>
    </div>

    <div class="modal-footer">
        <a href="" class="modal-close btn-flat btn grey lighten-2">Close</a>
    </div>
</div>

<?php 
    }
    require_once 'layout.php'
?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        let elems = document.querySelectorAll('.carousel');
        let instances = M.Carousel.init(elems, {});

        let modals = document.querySelectorAll('.modal');
        let modalInstances = M.Modal.init(modals, {});

        let card = document.querySelector('#card-panel');
        setTimeout(() => {
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['class']); ?>
            card.classList.toggle('hide');
        }, 2000)
    })
</script>
