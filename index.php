<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Define allowed pages
$allowed_pages = ['home', 'assessment', 'results', 'resources', 'login', 'register', 'dashboard'];

// Include header
include 'includes/header.php';

// Include the requested page if it exists and is allowed
if (in_array($page, $allowed_pages) && file_exists("pages/$page.php")) {
    include "pages/$page.php";
} else {
    include 'pages/404.php';
}

// Include footer
include 'includes/footer.php';
?>
