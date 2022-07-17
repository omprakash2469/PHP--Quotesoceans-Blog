<?php
include  $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/functions.php';
// Build list of categories
$categories = getCategories();

// Quotes Content Section
if (isset($_GET['category']) && !empty($_GET['category'])) {
    // Establishing Database Connection
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';

    // Check if the category exists
    $category = $_GET['category'];
    try {
        $sql = "SELECT * FROM `category` WHERE `name` = :name";
        $result = $pdo->prepare($sql);
        $result->bindValue(':name', $category);
        $result->execute();
    } catch (PDOException $e) {
        $error = "Failed to Fetch Categories ";
        include 'error.html.php';
        exit();
    }
    $rowcount = $result->rowCount();
    // Fetch Quotes if the category exists
    if ($rowcount == 1) {
        $num = $result->fetch();

        // Fetch Id and Category Name from category table
        $category = strtolower($num['name']);
        // Fetching Quotes of the given category
        try {
            $sql = "SELECT `quoteid`, `quotetext`, `name` FROM `$category` INNER JOIN `author` ON `authorid` = author.id ORDER BY `quoteid` DESC";
            $result = $pdo->query($sql);
        } catch (PDOException $e) {
            $error = "Failed to fetch Quotes";
            include 'error.html.php';
            exit();
        }

        // Get url of Images in array
        foreach ($result as $row) {
            $quotes[] = array(
                'id' => $row['quoteid'],
                'quote' => $row['quotetext'],
                'author' => $row['name']
            );
        }
        $count = count($quotes);
        $heading = $count . ' Quotes Found On "' . ucwords($category) . '" >>';
        $urls = displayImages($category, count($quotes));

        // Header content variables
        $title = "Quotes On " . $category;
        $stylesheet = "/css/quotes.css";
        $script = '<script src="/js/quotes.js"></script>';

        // Displaying Quotes
        include 'quotes.html.php';
        exit();
    } else {
        header("Location: /error");
        exit();
    }
}

// Search Results Here
if (isset($_GET['search']) && !empty($_GET['search'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
    // get the user query
    $search = secure($_GET['search']);
    foreach ($categories as $category) {
        $category = strtolower($category['category']);
        // Search the query in database
        try {
            $sql = "SELECT `quotetext`, `quoteid`, `name` FROM `$category` INNER JOIN `author` on `authorid` = author.id WHERE MATCH (`name`) AGAINST (:search) OR MATCH (`quotetext`) AGAINST (:search)";
            $result = $pdo->prepare($sql);
            $result->bindValue(':search', $search);
            $result->execute();
        } catch (PDOException $e) {
            $error = "Failed to Fetch Categories ";
            include 'error.html.php';
            exit();
        }
        // Build array of authors and their quotes
        foreach ($result as $row) {
            $quotes[] = array(
                'id' => $row['quoteid'],
                'quote' => $row['quotetext'],
                'author' => $row['name']
            );
        }
    }

    // Get Unique records from array
    $quotes = unique_multidim_array($quotes, 'quote');

    // Display heading of the search results
    $count = count($quotes);
    if ($count == 0) {
        $heading = $count . ' Result Found for : ' . '"' . $search . '"';
        $urls = "";
    } elseif ($count <= 1) {
        $heading = $count . ' Result Found for : ' . '"' . $search . '"';
        $urls = displayImages("background+life", count($quotes));
    } else {
        $heading = $count . ' Results Found for : ' . '"' . $search . '"';
        $urls = displayImages("love+background+life+nature", count($quotes));
    }
    // Header content variables
    $title = "Search Results : '$search'";
    $stylesheet = "/css/quotes.css";
    $script = '<script src="/js/quotes.js"></script>';

    // Displaying Quotes on Searched Query
    include 'quotes.html.php';
    exit();
}