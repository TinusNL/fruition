
<body>
<div class="login-container">
        <div class="login-form">
            <div class="login-title">Login</div>
            <form method="post" action="login.php">
                <div class="input-container">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Your email" required>
                </div>
                <div class="input-container">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Your password" required>
                </div>
                <button type="submit" class="login-button">Log In</button>
            </form>
            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign Up</a>
            </div>
        </div>
    </div>
    <div class="logosvg"> 
    <img src="./assets/logo.svg" alt="logo">
</div>
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