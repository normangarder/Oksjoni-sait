<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS/register_style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <title>Register</title>
    </head>
    <?= renderErrors() ?><form method="POST" style="border:1px solid #ccc">
        <div class="container">
            <label for="title"><b>Title</b></label>
            <input type="text" placeholder="Enter Title" name="title" required>

            <label for="description"><b>Description</b></label>
            <input type="text" placeholder="Enter Description" name="description" required>

            <label for="startingbid"><b>Starting bid</b></label>
            <input type="number"  min="0" placeholder="Enter Starting Bid" name="startingbid" required>

          <div class="clearfix">
            <button type="button" class="cancelbtn">Cancel</button>
            <button type="submit" class="signupbtn" name="add_auction">Sign Up</button>
          </div>
        </div>
      </form>
</html>
