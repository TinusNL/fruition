<div class="main_login">
    <div class="left_login">
        <h1 class="login-text">Login</h1>
        <div class="login_error">
            <?php
            if (isset($_GET['error'])) {
                echo $_GET['error'];
            }
            ?>
        </div>
        <div class="form-login">
            <form action="authenticate" method="post" class="login-form"><br>
                <label for="email">Email</label><br>
                <input class="input-box" type="email" name="email" placeholder="    janedoe@mail.com">
                <br>
                <label for="password">Password</label><br>
                <input class="input-box" type="password" name="password" placeholder="  *******">
                <div class="account-signin">
                    <p>Don't have an account? <a href="register" class="sign-up">Sign up</a></p>
                    <input type="submit" name="login" class="sign-in" value="Sign in">
                </div>
                <div class="login_extra">
                    <a href="forgot">Forgot Password</a>
                </div>
            </form>
            <div class="socials">
                <img src="./assets/Discord.svg" alt="">
                <img src="./assets/Facebook.svg" alt="">
                <img src="./assets/Instagram.svg" alt="">
                <img src="./assets/Pinterest.svg" alt="">
            </div>
            <div class="logo-hidden-login">
            <img src="./assets/logo_light.png" alt="logo" class="logo-mobile">
            </div>
        </div>
    </div>
    <div class="right_login">
        <img src="./assets/logo.svg" alt="logo" class="logo">
        <h2>Free Food For All</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec molestie luctus tellus, at viverra purus pulvinar vitae. Vivamus vitae lobortis magna, mollis mollis orci.</p>
    </div>
</div>
