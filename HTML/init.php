<?php
session_start();

require_once 'functions.php';
if (!isset($_GET['r'])) {
    // self destruction
}
require_once 'config.php';
require_once 'mysql.php';

handle_user();
