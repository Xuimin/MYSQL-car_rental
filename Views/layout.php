<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" 
        rel="stylesheet">

        <!-- Bootstrap CSS
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
        crossorigin="anonymous"> -->

        <!-- Materialize CSS -->
        <link rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

        <!-- Google Form -->
        <link rel="preconnect" 
        href="https://fonts.googleapis.com">
        <link rel="preconnect" 
        href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@300&display=swap" 
        rel="stylesheet">

        <!-- Own CSS -->
        <link rel="stylesheet" type="text/css" href="/Asset/Css/style.css">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" 
        content="width=device-width, initial-scale=1.0"/>

        <title>Car Rental | <?php echo $title; ?></title>
    </head>

    <body>
        <?php require_once 'Template/nav.php'; ?> 
        
        <div class="container">
            <?php if(isset($_SESSION['user_data'])): ?>
            <p><?php echo $_SESSION['user_data']['username']; ?> 's Account</p>
            <?php else: ?>
                <?php echo '<p>Please login/create an account</p>'?>
            <?php endif; ?>

            <h2 class="text-center center-align">
                <b><?php echo $title; ?></b>
            </h2>
        </div>

        <main>
            <?php echo get_content(); ?>
        </main>

        <?php require_once 'Template/footer.php'; ?> 
        
        <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js">
        </script>
    </body>
</html>
