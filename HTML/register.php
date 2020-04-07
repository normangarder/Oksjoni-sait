<?php
    session_start();

    //connection to the database
    $db = mysqli_connect('enos.itcollege.ee', 'maaash', 'pGISE6YZav', 'WT7');

    //user registration
    if(isset($_POST['reg_user'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $phone = mysqli_real_escape_string($db, $_POST['phone']);
        $password = mysqli_real_escape_string($db, $_POST['psw']);
        $password_repeat = mysqli_real_escape_string($db, $_POST['psw-repeat']);
        
        //check if all the fields are filled
        if (empty($username)) { array_push($errors, "Username is required"); }
        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password_1)) { array_push($errors, "Password is required"); }
        if ($password_1 != $password_2) {
	    array_push($errors, "The two passwords do not match");
        }

        //check if user does'nt exist already in the database
        $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
        $result = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($result);
  
        if ($user) { // if user exists
            if ($user['username'] === $username) {
                array_push($errors, "Username already exists");
            }

            if ($user['email'] === $email) {
                array_push($errors, "email already exists");
            }
        }

        //registration finalization
        if (count($errors) == 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username, email, phone, password) 
  			    VALUES('$username', '$email', '$phone', '$password')";
  	        mysqli_query($db, $query);
  	        $_SESSION['username'] = $username;
  	        $_SESSION['success'] = "You are now logged in";
  	        header('location: index.html');
        }
    }

    //user login
    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
      
        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }
      
        if (count($errors) == 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $results = mysqli_query($db, $query);
            if (mysqli_num_rows($results) == 1) {
              $_SESSION['username'] = $username;
              $_SESSION['success'] = "You are now logged in";
              header('location: index.html');
            }else {
                array_push($errors, "Wrong username/password combination");
            }
        }
      }
?>