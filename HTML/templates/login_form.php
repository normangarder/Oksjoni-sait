<?php
require_once 'header.php';
echo renderErrors();
?>
    <form method="POST">
        <div class="container">
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>

            <div class="clearfix">
                <button type="submit" class="loginbtn" name="login_user">Login</button>
                <button type="button" class="cancelbtn">Cancel</button>
            </div>
            <p>Not a user? Register <a href="<?= getRouteUrl('register') ?>">here</a>.</p>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
    </form>
<?php
require_once 'footer.php';
