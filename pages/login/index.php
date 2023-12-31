<?php
// If the user is already logged in, redirect to the homepage
if (isset($_SESSION['user_id'])) {
    header('Location: /' . URL_PREFIX . '/');
}
?>
<div class="main_authenticate">
    <div class="left_authenticate">
        <h1 class="login-text">Login</h1>
        <?php if (isset($_GET['error'])) { ?>
            <div class="login_error">
                <?= $_GET['error'] ?>
            </div>
        <?php } ?>
        <div class="form-authenticate">
            <form action="authenticate" method="post" class="login-form"><br>
                <label for="email">Email</label><br>
                <input type="email" name="email" placeholder="    janedoe@mail.com">
                <br>
                <label for="password">Password</label><br>
                <input type="password" name="password" placeholder="  *******">
                <input type="submit" name="login" class="authenicate_l" value="Login">
                <div class="account-authenticate">
                    <p>Don't have an account? <a href="signup" class="authenticate">Sign up</a></p>
                </div>
                <div class="login_extra">
                    <a href="forgot">Forgot Password</a>
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
