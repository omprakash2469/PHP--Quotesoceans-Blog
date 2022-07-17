<!-- Header Section -->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/functions.php';
$categories = getCategories();
// Header content variables
$title = "QuotesOceans || About Us";
$stylesheet = "/css/about.css";
$script = "";

// Display about information
include 'about.html.php';