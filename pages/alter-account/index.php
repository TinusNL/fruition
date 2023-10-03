<?php
    session_start();
    $_SESSION['user_id'] = 1;
    $_SESSION['user_first_name'] = 'Emirhan';
    $_SESSION['user_last_name'] = 'Boyacı';
    $_SESSION['username'] = 'emirhanbyc';
    $_SESSION['user_password'] = '123456';
    $_SESSION['user_email'] = 'emirhanbyc12@gmail.com';
    $_SESSION['user_role'] = 'user';

    function sanitizeInput($input) {
        $input = trim($input);
        $input = htmlspecialchars($input);
        $input = stripslashes($input);
        return $input;
    }

    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['submit'])) {
            if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['confirm-password']) && !empty($_POST['email'])) {
                $firstname = $_SESSION['user_first_name'];
                $lastname = $_SESSION['user_last_name'];
                $username = $_SESSION['username'];
                $password = $_SESSION['user_password'];
                $email = $_SESSION['user_email'];

                $newFirstname = sanitizeInput($_POST['firstname']);
                $newLastname = sanitizeInput($_POST['lastname']);
                $newUsername = sanitizeInput($_POST['username']);
                $newPassword = sanitizeInput($_POST['password']);
                $newPasswordConfirm = sanitizeInput($_POST['confirm-password']);
                $newEmail = sanitizeInput($_POST['email']);

                if($firstname != $newFirstname || $lastname != $newLastname || $username != $newUsername || $password != $newPassword || $email != $newEmail && $newPassword == $newPasswordConfirm) {
                    $_SESSION['user_first_name'] = $newFirstname;
                    $_SESSION['user_last_name'] = $newLastname;
                    $_SESSION['username'] = $newUsername;
                    $_SESSION['user_password'] = $newPassword;
                    $_SESSION['user_email'] = $newEmail;
                } else {
                    echo 'You did not change anything.';
                }

                echo '<pre>';
                print_r($_SESSION);
                echo '</pre>';
            }
        }
    }

?>

<style>
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    label {
        margin-top: 1rem;
    }

    input {
        margin-top: 0.5rem;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 20rem;
    }

    button {
        margin-top: 1rem;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 20rem;
        background-color: #ccc;
        cursor: pointer;
    }

    button:hover {
        background-color: #ddd;
    }

    .alter-account {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

</style>
<main class="main">
    <div class="alter-account">
        <div class="form">
            <form action="" method="post">
                <input type="hidden" name="user_id" data-value="<?= $_SESSION['user_id'] ?>">

                <label for="firstname">First name</label>
                <input type="text" name="firstname" id="firstname" data-value="<?php echo $_SESSION['user_first_name'] ?>">

                <label for="lastname">Last name</label>
                <input type="text" name="lastname" id="lastname" data-value="<?php echo $_SESSION['user_last_name'] ?>">

                <label for="username">Username</label>
                <input type="text" name="username" id="username" data-value="<?php echo $_SESSION['username'] ?>">

                <label for="password">Password</label>
                <input type="password" name="password" id="password" data-value="<?php echo $_SESSION['user_password'] ?>">

                <label for="confirm-password">Confirm password</label>
                <input type="password" name="confirm-password" id="confirm-password">
                
                <label for="email">Email</label>
                <input type="email" name="email" id="email" data-value="<?php echo $_SESSION['user_email'] ?>">

                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>
</main>