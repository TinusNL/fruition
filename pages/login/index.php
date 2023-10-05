<div class="login_form">
    <div class="login_error">
        <?php
        if (isset($_GET['error'])) {
            echo $_GET['error'];
        }
        ?>
    </div>

    <form action="authenticate" method="post">
        <input type="email" name="email" placeholder="Email" />
        <input type="password" name="password" placeholder="Password" />
        <input type="submit" name="login" value="Login" />
    </form>

    <div class="login_extra">
        <a href="register">Register</a>
        <a href="forgot">Forgot Password</a>
    </div>
</div>