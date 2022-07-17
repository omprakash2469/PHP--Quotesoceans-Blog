<?php
include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/functions.php';
$inserted = FALSE;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['firstName']) && isset($_POST['email'])) {
        // Insert data into table
        include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
        try {
            $sql = "INSERT INTO `contact` (`fname`, `lname`,`location`, `email`, `subject`, `message`, `date`) VALUES (:name, :lastname, :locate, :mail, :title, :msg, CURRENT_TIMESTAMP)";
            $result = $pdo->prepare($sql);
            // Binding values
            $result->bindValue(':name', $_POST['firstName']);
            $result->bindValue(':lastname', $_POST['lastName']);
            $result->bindValue(':locate', $_POST['location']);
            $result->bindValue(':mail', $_POST['email']);
            $result->bindValue(':title', $_POST['subject']);
            $result->bindValue(':msg', $_POST['message']);
            $result->execute(); // execute sql query
        } catch (PDOException $e) {
            $error = "Error Connecting with us";
            include 'error.html.php';
            exit();
        }
        // close db connection
        $result = NULL;
        $pdo = NULL;
        $inserted = TRUE;
    }
}


// Get the list of all categories
$categories = getCategories();

// Header content variables
$title = "QuotesOceans || Contact Us";
$stylesheet = "/css/contact.css";
$script = "";

// Contact Page
include 'contact.html.php';
