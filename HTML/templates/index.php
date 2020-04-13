<?php
require_once 'header.php';
?>
        <!--Content of the webpage-->
        <div class="caption">
            <h1>Auction<span style="color:lightseagreen">Time</span></h1>
        </div>
        <div class="subcaption">
            <h2>We are the number one real estate auction site<?php
                if (!logged()) {
                    echo '<a href="?r=register" class="register">Register</a></h2>';
                }
                ?>
        </div>
        <!--Offers-->
        <div class="grid-caption">
            <h2>Some Great Properties</h2>
        </div>
        <div id="p-grid">
            <?php
            foreach (getAuctions($db) as $item) {
                echo '<div class="p-grid"><div class="p-grid-in">
              <img class="p-img" src="' . getFirstAuctionImage($item['id']) . '"/>
              <div class="p-name">' . $item['title'] . '</div>
              <div class="p-price">Starting bid: ' . $item['startingbid'] . '€</div>
              <div class="p-desc">' . $item['desc'] . '</div>
              <button class="p-add">Bid</button>
            </div></div>';
            }
            ?>
          </div>
<?php
require_once 'footer.php';
