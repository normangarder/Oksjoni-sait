<?php
require_once 'header.php';
$replace_ids = [];
?>
<table class="products">
    <tr><th>image</th><th>user name</th><th>product</th><th>description</th><th>starting bid</th><th>time left</th><th>Last bid</th><th></th></tr>
    <?php
    foreach (getAuctions($db) as $row) {
        echo '<tr><td><img src="' . getFirstAuctionImage($row['id']) . '"/></td><td>' . $row['username'] . '</td><td>' . $row['title'] . '</td><td>' . $row['desc'] . '</td><td>' . $row['startingbid'] . '€</td><td id="timeleft-' . $row['id'] . '">0</td></tr>';
        $replace_ids[] = $row['id'];
    }
    ?>
</table>
<script>
    <?php
            foreach ($replace_ids as $rid) {
                echo 'loadEndTime('. $rid .');' . "\n";
            }
    ?>
</script>
<?php
require_once 'footer.php';
