<?php
include '../shared_includes/functions.php';
include 'includes/access.inc.php';

// Check if the user is logged in and user has role
if (!userIsLoggedIn()) {
    include 'includes/login.html.php';
    exit();
}

if (userHasRole('Account Administrator') || userHasRole('Site Administrator') || userHasRole('Content Editor')) {
    $quoteCount = countQuotes();
    $authorCount = countAuthors();
    $contactCount = countContact();

    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
    try {
        $result = $pdo->query("SELECT `id`, `name` FROM `category`");
    } catch (PDOException $e) {
        $error = "Error fetching categories " . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    // Count Quotes from each category table
    foreach ($result as $row) {
        $cattable = $row['name'];
        try {
            $qresult = $pdo->query("SELECT * FROM `$cattable`");
        } catch (PDOException $e) {
            $error = "Error counting categories ";
            include 'error.html.php';
            exit();
        }
        $num = $qresult->rowCount();
        $topCat[$cattable] += $num ;
    }
    // Sort arrays
    arsort($topCat);
    
    // Get Authors
    $authors = getAuthors();
    asort($authors);

    include 'home.php';
    exit();
}


header("location: /error");