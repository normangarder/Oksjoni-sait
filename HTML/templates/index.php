<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS/styles.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <title>Real Estate Auction Site</title>
    </head>
    <body>
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
              <div class="p-price">' . $item['startingbid'] . '</div>
              <div class="p-desc">' . $item['desc'] . '</div>
              <button class="p-add">Bid</button>
            </div></div>';
            }
            ?>
          </div>
          <footer class="footer-distributed">
          
                <div class="footer-left">
          
                  <h3>Auction<span>Time</span></h3>
          
                  <p class="footer-links">
                    <a href="index.php" class="link-1">Home</a>
                    
                    <a href="../about.html">About</a>
                    
                    <a href="mailto:info@itcollege.ee">Contact</a>
                  </p>
          
                  <p class="footer-company-name">AuctionTime © 2020</p>
                </div>
          
                <div class="footer-center">
          
                  <div>
                    <i class="fa fa-map-marker"></i>
                    <p><span>444 S. Cedros Ave</span> Solana Beach, California</p>
                  </div>
          
                  <div>
                    <i class="fa fa-phone"></i>
                    <p>+1.555.555.5555</p>
                  </div>
          
                  <div>
                    <i class="fa fa-envelope"></i>
                    <p><a href="mailto:support@company.com">info@itcollege.ee</a></p>
                  </div>
          
                </div>
          
                <div class="footer-right">
          
                  <p class="footer-company-about">
                    <span>About our service</span>
                    We are one of the top leading real estate auction sites in the world.
                  </p>
          
                  <div class="footer-icons">
          
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-linkedin"></i></a>
          
                  </div>
          
                </div>
          
              </footer>
    </body>
</html>