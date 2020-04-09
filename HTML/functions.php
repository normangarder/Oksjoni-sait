<?php

function routeExists($route)
{
    $routes = [
        'login',
        'logout',
        'register',
        'products',
    ];
    if (in_array($route, $routes, true)) {
        return $route;
    }
    die('siin peaks selgelt politsei sekkuma');
}

function getActualRoute()
{
    if (!isset($_GET['r'])) {
        return null;
    }
    $route = $_GET['r'];
    if (routeExists($route)) {
        return $route;
    }
}

function getRouteUrl($route) {
    return '?r=' . routeExists($route); // vaata yle kui routeExists muutub...
}

/**
 * @return string|null
 */
function logged()
{
    if (isset($_SESSION['username'])) {
        return $_SESSION['username'];
    }
    return null;
}

function handle_user()
{
    global $conf, $db;
    switch (getActualRoute()) {
        case 'login':
            //user login
            if (isset($_POST['login_user'])) {
                $username = mysqli_real_escape_string($db, $_POST['uname']);
                $password = mysqli_real_escape_string($db, $_POST['psw']);
                $password = password_hash($password, PASSWORD_DEFAULT, ['salt' => $conf['password_salt']]);

                if (empty($username)) {
                    addError('Username is required');
                }
                if (empty($password)) {
                    addError('Password is required');
                }

                $errors = errors();
                if (count($errors) == 0) {
                    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
                    $results = mysqli_query($db, $query);
                    if (mysqli_num_rows($results) == 1) {
                        $_SESSION['username'] = $username;
                        $_SESSION['success'] = "You are now logged in";
                        header('location: index.php');
                    } else {
                        addError('Wrong username/password combination');
                    }
                }
            }
            require_once 'templates/login_form.php';
            break;
        case 'logout':
            unset($_SESSION['username']);
            header('location: index.php');
            break;
        case 'register':
            //user registration
            if (isset($_POST['reg_user'])) {
                $username = mysqli_real_escape_string($db, $_POST['username']);
                $email = mysqli_real_escape_string($db, $_POST['email']);
                $phone = mysqli_real_escape_string($db, $_POST['phone']);
                $password = mysqli_real_escape_string($db, $_POST['psw']);
                $password_repeat = mysqli_real_escape_string($db, $_POST['psw-repeat']);

                //check if all the fields are filled
                if (empty($username)) {
                    addError('Username is required');
                }
                if (empty($email)) {
                    addError('Email is required');
                }
                if (empty($password)) {
                    addError('Password is required');
                }
                if ($password != $password_repeat) {
                    addError('The two passwords do not match');
                }

                //check if user doesn't exist already in the database
                $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
                $result = mysqli_query($db, $user_check_query);
                $user = mysqli_fetch_assoc($result);

                if ($user) { // if user exists
                    if ($user['username'] === $username) {
                        addError('Username already exists');
                    }

                    if ($user['email'] === $email) {
                        addError('email already exists');
                    }
                }

                $errors = errors();
                //registration finalization
                if (count($errors) === 0) {
                    $password = password_hash($password, PASSWORD_DEFAULT, ['salt' => $conf['password_salt']]);

                    $query = "INSERT INTO users (username, email, phone, password) 
  			    VALUES('$username', '$email', '$phone', '$password')";
                    mysqli_query($db, $query);
                    $_SESSION['username'] = $username;
                    $_SESSION['success'] = "You are now logged in";
                    header('location: index.php');
                } else {
                    $refill = [
                        'username' => $username,
                        'email' => $email,
                        'phone' => $phone,
                    ];
                }
            }
            require_once 'templates/register_form.php';
            break;
        case 'products':
            require_once 'templates/products.php';
            break;
        default:
            require_once 'templates/index.php';
    }
}

/**
 * @return string[]|null
 */
function errors()
{
    if (isset($_SESSION['errors'])) {
        return $_SESSION['errors'];
    }
    return null;
}

function clearErrors()
{
    $_SESSION['errors'] = [];
}

function addError($error)
{
    if (!isset($_SESSION['errors'])) {
        $_SESSION['errors'] = [];
    }
    $_SESSION['errors'][] = $error;
}

function renderErrors()
{
    $return = '';
    foreach (errors() as $error) {
        $return .= '<p class="error">' . $error . '</p>' . "\n";
    }
    clearErrors();
    return $return;
}

function refillValue($field)
{
    if (isset($_POST[$field])) {
        return ' value="' . $_POST[$field] . '"';
    } else {
        return '';
    }
}
