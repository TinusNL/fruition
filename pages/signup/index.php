<div class="main_authenticate">
    <div class="left_authenticate">
        <h1 class="login-text">Sign Up</h1>
        <div class="login_error">
            <?php
            if (isset($_GET['error'])) {
                echo $_GET['error'];
            }
            ?>
        </div>
        <div class="form-authenticate">
            <form action="authenticate" method="post" class="login-form"><br>
                <label for="email">Email</label><br>
                <input class="input-box" type="email" name="email">
                <br>
                <label for="username">Username</label><br>
                <input class="input-box" type="text" name="username">
                <br>
                <label for="password">Password</label><br>
                <input class="input-box" type="password" name="password">
                <br>
                <label for="confirm_password">Confirm password</label><br>
                <input class="input-box" type="password" name="confirm_password">
                <input type="submit" name="signup" class="authenicate_l" value="Sign Up">
                <div class="account-authenticate">
                    <p>Already have an account? <a href="login" class="authenticate">Sign in</a></p>
                </div>
                <div class="login_extra">
                    <a href="/<?= URL_PREFIX ?>/">Back to home</a>
                </div>
            </form>
            <div class="socials">
                <img src="assets/Google.svg" alt="Google" class="img_g" >
                <img src="assets/Discord.svg" alt="Discord" class="img_g" >
                <img src="assets/Facebook.svg" alt="Facebook" class="img_g" >
                <img src="assets/Instagram.svg" alt="Instagram" class="img_g" >
                <img src="assets/Pinterest.svg" alt="Pinterest" class="img_g" >
            </div>
            <div class="logo-hidden-authenticate">
                <img src="./assets/logo_light.png" alt="logo" class="logo-mobile">
            </div>
        </div>
    </div>
    <div class="right_authenticate">
        <img src="./assets/logo.svg" alt="logo" class="logo">
        <h2>Free Food For All</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec molestie luctus tellus, at viverra purus pulvinar vitae. Vivamus vitae lobortis magna, mollis mollis orci.</p>
    </div>
</div>
