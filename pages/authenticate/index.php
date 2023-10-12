<?php
// Check for POST submit
if (empty($_POST)) {
    header('Location: /' . URL_PREFIX . '/login');
    exit();
}

// Check for login
if (isset($_POST['login'])) {
    // Check if ip has too many login attempts
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $failed_attempts = User::getFailedAttempts($ip_address);
    if ($failed_attempts >= MAX_LOGIN_ATTEMPTS) {
        $still_locked = User::checkLastAttempt($ip_address);

        if ($still_locked) {
            $data['error'] = 'Too many failed login attempts. Please try again later.';
            header('Location: /' . URL_PREFIX . '/login?error=' . $data['error']);
            exit();
        }
    }

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

    // If trying to log in as no-reply@fruition.city
    if ($data['email'] == 'no-reply@fruition.city') {
        $data['error'] = 'No user found';
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
            // Add a failed attempt to db
            $ip_address = $_SERVER['REMOTE_ADDR'];
            User::addFailedAttempt($ip_address);

            header('Location: /' . URL_PREFIX . '/login?error=' . $data['error']);
        }
    } else {
        header('Location: /' . URL_PREFIX . '/login?error=' . $data['error']);
    }
}

// Check for register
if (isset($_POST['signup'])) {
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
    } else {
        // Check email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['error'] = 'Please enter a valid email';
        }
    }

    // Validate username
    if (empty($data['username'])) {
        $data['error'] = 'Please make sure all fields are filled out';
    } else {
        // Check username
        if (!preg_match('/^[a-zA-Z0-9]{6,12}+$/', $data['username'])) {
            $data['error'] = 'Please enter a valid username <span class="details">(6-12 characters, letters and numbers only)</span>';
        }
    }

    // Validate password
    if (empty($data['password'])) {
        $data['error'] = 'Please make sure all fields are filled out';
    } else {
        // Check password
        if (!password_strength_check($data['password'])) {
            $data['error'] = 'Please enter a valid password <span class="details">(8-70 characters, at least 1 lowercase letter, 1 uppercase letter, 1 number, and 1 symbol)</span>';
        }
    }

    // Validate confirm password
    if (empty($data['confirm_password'])) {
        $data['error'] = 'Please make sure all fields are filled out';
    } else {
        // Check confirm password
        if ($data['password'] != $data['confirm_password']) {
            $data['error'] = 'Passwords do not match';
        }
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
            header('Location: /' . URL_PREFIX . '/login');
        } else {
            $data['error'] = 'Something went wrong';

            header('Location: /' . URL_PREFIX . '/login?error=' . $data['error']);
        }
    } else {
        header('Location: /' . URL_PREFIX . '/signup?error=' . $data['error']);
    }
}

function password_strength_check($password, $min_len = 8, $max_len = 70, $req_digit = 1, $req_lower = 1, $req_upper = 1, $req_symbol = 1): bool
{
    // Build regex string depending on requirements for the password
    $regex = '/^';
    if ($req_digit == 1) { $regex .= '(?=.*\d)'; }              // Match at least 1 digit
    if ($req_lower == 1) { $regex .= '(?=.*[a-z])'; }           // Match at least 1 lowercase letter
    if ($req_upper == 1) { $regex .= '(?=.*[A-Z])'; }           // Match at least 1 uppercase letter
    if ($req_symbol == 1) { $regex .= '(?=.*[^a-zA-Z\d])'; }    // Match at least 1 character that is none of the above
    $regex .= '.{' . $min_len . ',' . $max_len . '}$/';

    if(preg_match($regex, $password)) {
        return TRUE;
    } else {
        return FALSE;
    }
}