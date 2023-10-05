<?php
// Check for POST submit
if (empty($_POST)) {
    header('Location: ' . URL_PREFIX . '/login');
    exit();
}

// Check for login
if (isset($_POST['login'])) {
    // Sanitize POST data
    $_POST = filter_input_array(INPUT_POST);

    // Init data
    $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'error' => '',
    ];

    // Validate email
    if (empty($data['email'])) {
        $data['error'] = 'Please make sure both fields are filled out';
    }

    // Validate password
    if (empty($data['password'])) {
        $data['error'] = 'Please make sure both fields are filled out';
    }

    // Check for user/email
    if (empty($data['error'])) {
        if (!User::findUserByEmail($data['email'])) {
            $data['error'] = 'No user found';
        }
    }

    // Make sure errors are empty
    if (empty($data['error'])) {
        // Check and set logged-in user
        $loggedInUser = User::login($data['email'], $data['password']);

        if ($loggedInUser) {
            // Create Session
            User::createUserSession($loggedInUser);
        } else {
            $data['error'] = 'Password incorrect';

            header('Location: ' . URL_PREFIX . '/login?error=' . $data['error']);
        }
    } else {
        header('Location: ' . URL_PREFIX . '/login?error=' . $data['error']);
    }
}

// Check for register
if (isset($_POST['register'])) {
    // Sanitize POST data
    $_POST = filter_input_array(INPUT_POST);

    // Init data
    $data = [
        'email' => trim($_POST['email']),
        'username' => trim($_POST['username']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'error' => '',
    ];

    // Validate email
    if (empty($data['email'])) {
        $data['error'] = 'Please make sure all fields are filled out';
    }

    // Validate username
    if (empty($data['username'])) {
        $data['error'] = 'Please make sure all fields are filled out';
    }

    // Validate password
    if (empty($data['password'])) {
        $data['error'] = 'Please make sure all fields are filled out';
    }

    // Validate confirm password
    if (empty($data['confirm_password'])) {
        $data['error'] = 'Please make sure all fields are filled out';
    }

    // Check for user/email
    if (empty($data['error'])) {
        if (User::findUserByEmail($data['email'])) {
            $data['error'] = 'Email is already taken';
        }
    }

    // Make sure errors are empty
    if (empty($data['error'])) {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Register user
        if (User::register($data)) {
            header('Location: ' . URL_PREFIX . '/login');
        } else {
            $data['error'] = 'Something went wrong';

            header('Location: ' . URL_PREFIX . '/login?error=' . $data['error']);
        }
    } else {
        header('Location: ' . URL_PREFIX . '/login?error=' . $data['error']);
    }
}