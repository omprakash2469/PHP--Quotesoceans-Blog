<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/functions.php';
// Check if the User of Loggedin or not
require_once '../includes/check_login.php';
require_once '../includes/access.inc.php';

if (!userHasRole('Account Administrator')) {
    header("Location: /admin");
}

// Deleting Quotes
if (isset($_POST['action']) && $_POST['action'] == "delete") {
    // Establish db connection
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
    $id = $_POST['id'];
    // Deleting the quotes assignment to categories 
    try {
        $sql = "DELETE FROM `contact` WHERE `user_id` = :id";
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $id);
        $s->execute();
        // close db connection
        $pdo = NULL;
        $s = NULL;
    } catch (PDOException $e) {
        $error = "Failed to Delete quote ";
        include 'error.html.php';
        exit();
    }
    header("Location: .");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
// Fetch Contact Page Information
try {
    $sql = "SELECT * FROM `contact`";
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $error = "Error fetching contact information";
    include '../includes/error.html.php';
    exit();
}

foreach ($result as $row) {
    $contacts[] = array(
        'id' => $row['user_id'],
        'firstName' => $row['fname'],
        'lastName' => $row['lname'],
        'locate' => $row['location'],
        'email' => $row['email'],
        'sub' => $row['subject'],
        'msg' => $row['message'],
        'dt' => $row['date']
    );
}

include 'contact.html.php';