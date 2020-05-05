<?php

function routeExists($route)
{
    $routes = [
        'login',
        'logout',
        'register',
        'products',
        'add_auction',
        'when_added',
        'about',

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

function getRouteUrl($route)
{
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
    $pageTitle = '';
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
                        goHome();
                    } else {
                        addError('Wrong username/password combination');
                    }
                }
            }
            $pageTitle = 'Login';
            require_once 'templates/login_form.php';
            break;
        case 'logout':
            unset($_SESSION['username']);
            goHome();
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
                    goHome();
                } else {
                    $refill = [
                        'username' => $username,
                        'email' => $email,
                        'phone' => $phone,
                    ];
                }
            }
            $pageTitle = 'Register';
            require_once 'templates/register_form.php';
            break;
        case 'products':
            $pageTitle = 'Product list';
            require_once 'templates/products.php';
            break;
        case 'add_auction':
            guestGTFO();
            if (isset($_POST['add_auction'])) {
                try {
                    $added = addAuction($db, isSomething($_POST['title']), isSomething($_POST['description']), isSomething($_POST['startingbid']));
                    $image = addImage($db, $added, uploadImage());
                    if (!$image) {
                        deleteAuction($added);
                        $added = null;
                    }
                    if ($added) {
                        header('location: index.php?r=products');
                    }
                } catch (InvalidArgumentException $e) {
                    addError($e->getMessage());
                }
            }
            $pageTitle = 'Add auction';
            require_once 'templates/auction_add_form.php';
            break;
        case 'when_added':
            echo getTimeLeft($_GET['auction']);
            break;
        case 'about':
            $pageTitle = 'About page';
            require_once 'templates/about.php';
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
    return [];
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

function uploadImage()
{
    $target_dir = "uploads/";
    $target_file = $target_dir . rand(1, 10000000000000) . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            addError('File is an image - ' . $check["mime"] . '.');
            $uploadOk = 1;
        } else {
            addError('File is not an image.');
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        addError('Sorry, file already exists.');
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        addError('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        addError('Sorry, your file was not uploaded.');
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            addError('The file ' . basename($_FILES["fileToUpload"]["name"]) . ' has been uploaded.');
        } else {
            $uploadOk = 0;
            addError('Sorry, there was an error uploading your file.');
        }
    }

    return $uploadOk ? $target_file : null;
}

function getFirstAuctionImage($auction_id)
{
    global $db;
    $filename = getFirstImageFilenameByAuction($db, $auction_id);
    return $filename ?? 'images/house-1.jpg';
}

function deleteAuction($auction_id)
{
    global $db;
    return deleteAuctionRow($db, $auction_id);
}

function isSomething($input)
{
    if (!$input) {
        throw new InvalidArgumentException('NULL input');
    }
    return $input;
}

function goHome()
{
    header('location: index.php');
    exit;
}

function guestGTFO()
{
    if (!logged()) {
        goHome();
    }
}

function getTime($id)
{
    global $db;
    return getAuctionAdded($db, $id);
}

function getTimeLeft($auction_id) {
    $add = '1 DAY';
    $inserted_string = getTime($auction_id);
    return date('c', strtotime($inserted_string . ' ' . $add));
}

function addBid($auction_id) {
    guestGTFO();
    $bid_sum = mysqli_real_escape_string($db, $_POST['getuserbid']);
    

}