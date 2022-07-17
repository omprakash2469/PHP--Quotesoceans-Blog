<?php
// Function Library
require_once $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/functions.php';
// List of Categories
$categories = getCategories();

// List of Authors to display
$authors = getAuthors();

// Display Results by Author
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Get author id
    $id = $_GET['id'];
    // Establish db connection
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
    foreach ($categories as $category) {
        $category = strtolower($category['category']);
        try {
            $sql = "SELECT `quotetext`, `name` FROM `$category` INNER JOIN `author` ON `authorid` = `id` WHERE `authorid` = :id";
            $result = $pdo->prepare($sql);
            $result->bindValue(':id', $id);
            $result->execute();
        } catch (PDOException $e) {
            $error = "Failed to Fetch Authors ";
            include 'includes/error.html.php';
            exit();
        }

        foreach ($result as $row) {
            $quotes[] = array(
                'author' => $row['name'],
                'quote' => $row['quotetext']
            );
        }
    }
    
    // Get Unique records from array
    $quotes = unique_multidim_array($quotes, 'quote');

    // close db connection
    $result = NULL;
    $pdo = NULL;

    $count = count($quotes); // Count fetched quotes
    if ($count == 0) {
        $heading = "Results Not Found..!";
        $urls = "";
    } elseif ($count <= 1) {
        $heading = $count . ' Quote By  : ' . '"' . $quotes[0]['author'] . '"';
        $urls = displayImages("background+nature", count($quotes));
    } else {
        $heading = $count . ' Quotes By  : ' . '"' . $quotes[0]['author'] . '"';
        $urls = displayImages("love+background+life+nature", count($quotes));
    }

    // Header content variables
    $title = "Quotes By " .$quotes[0]['author'];
    $stylesheet = "/css/quotes.css";
    $script = '<script src="/js/quotes.js"></script>';
    // Displaying Quotes By Authors
    include 'quotes/quotes.html.php';
    exit();
}

// Header content variables
$title = "QuotesOceans || Great Quotes on Every Life Aspects";
$stylesheet = "/css/home.css";
$script = "";

// Categories section
include 'includes/categories.html.php';