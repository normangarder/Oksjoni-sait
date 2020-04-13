<?php
require_once 'header.php';
echo renderErrors();
?>
    <form method="POST" style="border:1px solid #ccc" enctype="multipart/form-data">
        <div class="container">
            <label for="title"><b>Title</b></label>
            <input type="text" placeholder="Enter Title" name="title" required>

            <label for="description"><b>Description</b></label>
            <input type="text" placeholder="Enter Description" name="description" required>

            <label for="fileToUpload"><b>Image</b></label>
            <input type="file" name="fileToUpload" id="fileToUpload" accept='image/*'>

            <label for="startingbid"><b>Starting bid</b></label>
            <input type="number" min="0" placeholder="Enter Starting Bid" name="startingbid" required>

            <div class="clearfix">
                <button type="button" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn" name="add_auction">Add</button>
            </div>
        </div>
    </form>
<?php
require_once 'footer.php';
