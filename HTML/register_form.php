<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS/register_style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <title>Register</title>
    </head>
    <form method="POST" action="register.php" style="border:1px solid #ccc">
        <div class="container">
          <h1>Sign Up</h1>
          <p>Please fill in this form to create an account.</p>
          <hr>

          <label for="username"><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="username" required>
      
          <label for="email"><b>Email</b></label>
          <input type="text" placeholder="Enter Email" name="email" required>

          <label for="phone"><b>Phone number</b></label>
          <input type="text" placeholder="Enter Phone number" name="phone" required>
      
          <label for="psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="psw" required>
      
          <label for="psw-repeat"><b>Repeat Password</b></label>
          <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

          <p>Already a user? Login <a href="./login_form.html">here</a>.</p>

          <div class="clearfix">
            <button type="button" class="cancelbtn" name="reg_user">Cancel</button>
            <button type="submit" class="signupbtn">Sign Up</button>
          </div>
        </div>
      </form>
</html>