<?php
    $title = 'Login';
    function get_content() {
?>

<div class="container">
    <div class="row">
        <div class="col m6 offset-m3">
            <form method="POST"
            action="/web.php">
                <input type="hidden"
                name="action"
                value="login">
    
                <div class="input-field">
                    <input type="text" 
                    name="username"
                    id="username">
                    <label for="username"
                    class="purple-text">Username</label>
                </div>
    
                <div class="input-field">
                    <input type="password" 
                    name="password"
                    id="password">
                    <label for="password"
                    class="purple-text">Password</label>
                </div>
    
                <button class="btn">
                    Login
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>
</div>

<?php
    }
    require_once 'layout.php'
?>