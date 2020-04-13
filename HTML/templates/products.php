<?php
require_once 'header.php';
?>
<table class="products">
    <tr><th>image</th><th>user name</th><th>product</th><th>description</th><th>starting bid</th></tr>
    <?php
    foreach (getAuctions($db) as $row) {
        echo '<tr><td><img src="' . getFirstAuctionImage($row['id']) . '"/></td><td>' . $row['username'] . '</td><td>' . $row['title'] . '</td><td>' . $row['desc'] . '</td><td>' . $row['startingbid'] . '</td></tr>';
    }
    ?>
</table>
<?php
require_once 'footer.php';
