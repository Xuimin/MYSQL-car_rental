<nav class="pink lighten-2">
    <div class="nav-wrapper container">
        <a href="/" 
        class="brand-logo">
            Car Rental
        </a>
        <a href="#" 
        data-target="mobile-menu"
        class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>
        <ul class="right hide-on-med-and-down">
            <li><a href="/">Home</a></li>

            <?php if(!isset($_SESSION['user_data'])): ?>
                <li><a href="/Views/register.php">Register</a></li>
                <li><a href="/Views/login.php">Login</a></li>
            <?php endif; ?> 
            
            <?php if(isset($_SESSION['user_data']) && !$_SESSION['user_data']['isAdmin']): ?>
                <li><a href="/Views/cart.php">Cart</a></li>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['user_data'])): ?>
                <li><a href="/Views/transactions.php">Transactions</a></li>
                <li><a href="/web.php/logout">Logout</a></li>
            <?php endif; ?> 
        </ul>
    </div>
</nav>

<!-- MOBILE VIEW -->
<ul class="sidenav" id="mobile-menu">
    <li><a href="/">Home</a></li>

    <?php if(!isset($_SESSION['user_data'])): ?>
        <li><a href="/Views/register.php">Register</a></li>
        <li><a href="/Views/login.php">Login</a></li>
    <?php endif; ?>

    <?php if(isset($_SESSION['user_data']) && !$_SESSION['user_data']['isAdmin']): ?>
        <li><a href="/Views/cart.php">Cart</a></li>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['user_data'])): ?>
        <li><a href="/Views/transactions.php">Transactions</a></li>
        <li><a href="/web.php/logout">Logout</a></li>
    <?php endif; ?>
</ul>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        let elems = document.querySelectorAll('.sidenav');
        let instances = M.Sidenav.init(elems, {});
    });
</script>