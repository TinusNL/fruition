<div class="register_form">
    <div class="register_error">
        <?php
        if (isset($_GET['error'])) {
            echo $_GET['error'];
        }
        ?>
    </div>

    <form action="authenticate" method="post">
        <input type="email" name="email" placeholder="Email" />
        <input type="username" name="username" placeholder="Username" />
        <input type="password" name="password" placeholder="Password" />
        <input type="password" name="confirm_password" placeholder="Confirm Password" />
        <input type="submit" name="register" value="Register" />
    </form>

    <div class="register_extra">
        <a href="login">Login</a>
    </div>
</div>