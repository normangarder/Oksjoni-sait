<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="CSS/form_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <title>Real Estate Auction Site</title>
</head>
<body>
<!--Upper navigation menu section-->
<div class="header">
    <nav>
        <ul>
            <li style="background-color:lightskyblue"><a class="menu" href="index.php">Home</a></li>
            <li class="dropdown"><a class="menu icon" href="<?= getRouteUrl('products') ?>">All products</a>
                <div class="dropdown-content">
                    <a href="?r=add_auction">Add</a>
                </div></li>
            <!--navigation menu item with a dropdown list-->
            <?php
            $user = logged();
            if ($user) {
                echo '<li class="right dropdown"><a class="menu icon" href="#">' . $user .  '</a>
                        <div class="dropdown-content">
                            <a href="' . getRouteUrl('logout') . '">Log out</a>
                        </div>
                    </li>';
            } else {
                echo '<li class="right dropdown"><a class="menu icon" href="#">User</a>
                        <div class="dropdown-content">
                            <a href="?r=login">Log in</a>
                            <a href="?r=register">Register</a>
                        </div>
                    </li>';
            }
            ?>
        </ul>
    </nav>
</div>