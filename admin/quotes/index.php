<?php
// Check if the user is logged in or not
require_once '../includes/check_login.php';
require_once '../includes/access.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/functions.php';

if (!userHasRole('Content Editor')) {
    header("Location: /admin");
}

// Display Quotes of the given category
if (isset($_GET['cid']) && !empty($_GET['cid'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
    $cid = $_GET['cid'];

    $category = cfromId($cid);
    if (empty($category)) {
        $error = "Category Not Found";
        include 'error.html.php';
        exit();
    }

    // Display quotes if the category exists
    try {
        $sql = "SELECT `quoteid`, `quotetext`, `quoteImg`, `name` FROM `$category` INNER JOIN `author` ON authorid = author.id";
        $result = $pdo->query($sql);
    } catch (PDOException $e) {
        $error = "Failed to select quote of given category ";
        include 'error.html.php';
        exit();
    }
    foreach ($result as $row) {
        $quotes[] = array(
            'id' => $row['quoteid'],
            'text' => $row['quotetext'],
            'image' => $row['quoteImg'],
            'author' => $row['name']
        );
    }
    $pdo = NULL; // close db connection
    include 'quotes.html.php';
    exit();
}

// Display Form to add new Quote
if (isset($_GET['add'])) {
    $pagetitle = "New Quote";
    $action = "addform";
    $cid = ""; // category id
    $qid = ""; // quote id
    $authorid = ""; // author id
    $text = "Type Your Quote here";
    $button = "Add_Quote";
    $name = ""; // category name

    // Build list of authors
    $authors = getAuthors();

    // Build list of categories
    $categories = getCategories();

    include 'form.html.php';
    exit();
}

// Adding New Quote
if (isset($_POST['action']) && $_POST['action'] == "addform") {
    // Check if form fields are empty
    if (empty($_POST['author']) || empty($_POST['text']) || empty($_POST['categories'])) {
        $error = "Please fill the details";
        include 'error.html.php';
        exit();
    }

    // Check if image file is uploaded
    if (empty($_FILES['upload']['tmp_name'])) {
        $error = "Please Upload Image";
        include 'error.html.php';
        exit();
    }

    // Get image details
    $oldFileName = $_FILES['upload']['name'];
    $fileTmp = $_FILES['upload']['tmp_name'];
    $fileSize = $_FILES['upload']['size'];
    $fileExt = pathinfo(strtolower($oldFileName), PATHINFO_EXTENSION);

    // Max File size i.e. 2MB
    $maxSize = 2 * 1024 * 1024;

    // Upload Image File
    if ($fileExt == 'jpg' || $fileExt == 'jpeg') {
        // Upload Image and insert into tables
        if (isset($_POST['categories'])) {
            // Establish db connection
            include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';

            $parentDir = $_SERVER['DOCUMENT_ROOT'] . '/images/';
            $fileName = time() . getUnique(15) . "." . $fileExt;
            try {
                // Insert the quote and author in table
                foreach ($_POST['categories'] as $category) {
                    $category = strtolower($category);
                    $uploadDir = $parentDir . $category . "/";
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir);
                    }

                    // Upload Image file
                    if (!copy($fileTmp, $uploadDir . $fileName)) {
                        $error = "Error uploading file";
                        include 'error.html.php';
                        exit();
                    }

                    // Insert quote
                    $sql = "INSERT INTO `$category` (`quotetext`, `quoteImg`, `authorid`, `quotedate`) VALUES (:text, :img, :id, current_timestamp())";
                    $s = $pdo->prepare($sql);
                    $s->bindValue(':text', $_POST['text']);
                    $s->bindValue(':img', $fileName);
                    $s->bindValue(':id', $_POST['author']);
                    $s->execute();
                }
                // close db connection
                $pdo = NULL;
                $s = NULL;
            } catch (PDOException $e) {
                $error = "Error inserting quotes";
                include 'error.html.php';
                exit();
            }
        }
    } else {
        $error = "File Format not allowed. (Upload jpg Image)";
        include 'error.html.php';
        exit();
    }
    header("location: .");
    exit();
}

// Display Edit Form
if (isset($_POST['action']) && $_POST['action'] == "edit") {
    // category and quoteid
    $cid = $_POST['cid'];
    $qid = $_POST['qid'];
    // Get category name from id
    $category = cfromId($cid);

    // Establish db connection
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';

    // Fetch quote
    try {
        $sql = "SELECT `quoteid`, `quotetext`, `authorid` FROM `$category` WHERE `quoteid` = :id";
        $result = $pdo->prepare($sql);
        $result->bindValue(':id', $qid);
        $result->execute();
    } catch (PDOException $e) {
        $error = "Failed to Display Edit form ";
        include 'error.html.php';
        exit();
    }
    $row = $result->fetch();
    // close db connection
    $result = NULL;
    $pdo = NULL;

    // Edit Form Variables
    $pagetitle = "Edit Quote";
    $action = "editform";
    $id = $row['quoteid'];
    $text = $row['quotetext'];
    $authorid = $row['authorid'];
    $button = "Update Quote";

    // Build list of authors
    $authors = getAuthors();

    // Build list of Categories
    $categories = getCategories();

    include 'form.html.php';
    exit();
}

// Editing the Quotes
if (isset($_POST['action']) && $_POST['action'] == "editform") {
    // Check if form fields are empty
    if (empty($_POST['author']) || empty($_POST['text']) || empty($_POST['categories'])) {
        $error = "Please fill the details";
        include 'error.html.php';
        exit();
    }

    // category and quoteid
    $cid = $_POST['cid'];
    $qid = $_POST['qid'];

    // Get category of quote
    $category = cfromId($cid);
    // Get Image of quote
    $imageName = getQuoteImage($category, $qid);
    
    // Establish db connection
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';

    // Deleting the quotes
    try {
        $sql = "DELETE FROM `$category` WHERE `quoteid` = :quoteid";
        $s = $pdo->prepare($sql);
        $s->bindValue(':quoteid', $qid);
        $s->execute();
        // close db connection
        $s = NULL;
    } catch (PDOException $e) {
        $error = "Failed to Delete quote ";
        include 'error.html.php';
        exit();
    }

    // Delete image associated with quote
    $imagePath = $_SERVER['DOCUMENT_ROOT'] . "/images/$category/$imageName";
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Get image details
    $oldFileName = $_FILES['upload']['name'];
    $fileTmp = $_FILES['upload']['tmp_name'];
    $fileSize = $_FILES['upload']['size'];
    $fileExt = pathinfo(strtolower($oldFileName), PATHINFO_EXTENSION);

    // Upload Image File
    if ($fileExt == 'jpg' || $fileExt == 'jpeg') {
        // Upload Image and insert into tables
        if (isset($_POST['categories'])) {
            $parentDir = $_SERVER['DOCUMENT_ROOT'] . '/images/';
            $fileName = time() . getUnique(15) . "." . $fileExt;
            try {
                // Insert the quote and author in table
                foreach ($_POST['categories'] as $category) {
                    $category = strtolower($category);
                    $uploadDir = $parentDir . $category . "/";
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir);
                    }

                    // Upload Image file
                    if (!copy($fileTmp, $uploadDir . $fileName)) {
                        $error = "Error uploading file";
                        include 'error.html.php';
                        exit();
                    }

                    // Insert quote
                    $sql = "INSERT INTO `$category` (`quotetext`, `quoteImg`, `authorid`, `quotedate`) VALUES (:text, :img, :id, current_timestamp())";
                    $s = $pdo->prepare($sql);
                    $s->bindValue(':text', $_POST['text']);
                    $s->bindValue(':img', $fileName);
                    $s->bindValue(':id', $_POST['author']);
                    $s->execute();
                }
                // close db connection
                $pdo = NULL;
                $s = NULL;
            } catch (PDOException $e) {
                $error = "Error inserting quotes";
                include 'error.html.php';
                exit();
            }
        }
    } else {
        $error = "File Format not allowed. (Upload jpg Image)";
        include 'error.html.php';
        exit();
    }
    header("location: ?cid=$cid");
    exit();
}

// Deleting Quotes
if (isset($_POST['action']) && $_POST['action'] == "delete") {
    // Establish db connection
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
    // category and quoteid
    $cid = $_POST['cid'];
    $qid = $_POST['qid'];

    // Get category of quote
    $category = cfromId($cid);
    // Get Image of quote
    $imageName = getQuoteImage($category, $qid);

    // Deleting the quotes
    try {
        $sql = "DELETE FROM `$category` WHERE `quoteid` = :quoteid";
        $s = $pdo->prepare($sql);
        $s->bindValue(':quoteid', $qid);
        $s->execute();
        // close db connection
        $pdo = NULL;
        $s = NULL;
    } catch (PDOException $e) {
        $error = "Failed to Delete quote ";
        include 'error.html.php';
        exit();
    }

    // Delete image associated with quote
    $imagePath = $_SERVER['DOCUMENT_ROOT'] . "/images/$category/$imageName";
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    header("Location: /admin/quotes/?cid=$cid");
    exit();
}

// Build list of Categories
$categories = getCategories();
include 'category.html.php';