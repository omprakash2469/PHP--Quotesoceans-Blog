<?php
// PHP Functions
require_once $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/functions.php';

// Check if the User of Loggedin or not
require_once '../includes/check_login.php';
require_once '../includes/access.inc.php';

if (!userHasRole('Account Administrator')) {
    header("Location: /admin");
}

// Add new author in the database
if (isset($_GET['addform'])) {
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
        $author = strtolower($_POST['name']);

        // Check if the given name exists
        try {
            $sql = "SELECT `name` FROM `author` WHERE `name` = :name";
            $s = $pdo->prepare($sql);
            $s->bindvalue(':name', $author);
            $s->execute();
        } catch (PDOException $e) {
            $error = "Failed to Insert author";
            include 'error.html.php';
            exit();
        }
        $row = $s->rowCount();
        $s = NULL; // close db connection 
        if ($row == 1) {
            header("Location: .");
            exit();
        } else {
            // Insert Author name if author not exists
            try {
                $sql = "INSERT INTO `author` (`name`) VALUES(:name)";
                $s = $pdo->prepare($sql);
                $s->bindvalue(':name', $author);
                $s->execute();
                // close db connection
                $s = NULL;
            } catch (PDOException $e) {
                $error = "Failed to Insert author ";
                include 'error.html.php';
                exit();
            }
            $authorid = $pdo->lastInsertId();

            // Add Authors professions
            try {
                foreach ($_POST['professions'] as $professionid) {
                    $sql = "INSERT INTO `author_profession` (`authorid`, `professionid`) VALUES(:authorid, :professionid)";
                    $s = $pdo->prepare($sql);
                    $s->bindvalue(':authorid', $authorid);
                    $s->bindvalue(':professionid', $professionid);
                    $s->execute();
                }
                // close db connection
                $pdo = NULL;
                $s = NULL;
            } catch (PDOException $e) {
                $error = "Failed to Insert author's profession ";
                include 'error.html.php';
                exit();
            }
        }
    }
    header("Location: .");
    exit();
}

// Update the author of the database
if (isset($_GET['editform'])) {
    // Establish db connection
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';

    $authorid = $_POST['id'];
    $author = strtolower($_POST['name']);

    // Update the author name
    try {
        $sql = "UPDATE `author` SET `name` = :name WHERE `id` = :id";
        $s = $pdo->prepare($sql);
        $s->bindvalue(':name', $author);
        $s->bindvalue(':id', $authorid);
        $s->execute();
    } catch (PDOException $e) {
        $error = "Failed to Update author ";
        include 'error.html.php';
        exit();
    }

    // Delete older Authors professions
    try {
        $sql = "DELETE FROM `author_profession` WHERE `authorid` = :authorid";
        $s = $pdo->prepare($sql);
        $s->bindvalue(':authorid', $authorid);
        $s->execute();
        // close db connection
        $s = NULL;
    } catch (PDOException $e) {
        $error = "Failed to delete older author's profession ";
        include 'error.html.php';
        exit();
    }

    // Add new Authors professions
    try {
        foreach ($_POST['professions'] as $professionid) {
            $sql = "INSERT INTO `author_profession` (`authorid`, `professionid`) VALUES(:authorid, :professionid)";
            $s = $pdo->prepare($sql);
            $s->bindvalue(':authorid', $authorid);
            $s->bindvalue(':professionid', $professionid);
            $s->execute();
        }
        // close db connection
        $pdo = NULL;
        $s = NULL;
    } catch (PDOException $e) {
        $error = "Failed to Insert author's profession ";
        include 'error.html.php';
        exit();
    }

    header("location: .");
    exit();
}

// Deleting the author and its related quotes in the database
if (isset($_POST['action']) && $_POST['action'] == "delete") {
    // Delete Quotes Belonging to authors from all table
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
    $categories = getCategories();
    foreach ($categories as $category) {
        $category = $category['category'];
        try {
            $sql = "DELETE FROM `$category` WHERE `authorid` = :id";
            $result = $pdo->prepare($sql);
            $result->bindvalue(':id', $_POST['id']);
            $result->execute();
        } catch (PDOException $e) {
            $error = "Failed to delete authorid from categories table";
            include 'error.html.php';
            exit();
        }
    }
    $result = NULL; // close db connection

    // Delete the author
    try {
        $sql = "DELETE FROM `author` WHERE `id` = :id";
        $s = $pdo->prepare($sql);
        $s->bindvalue(':id', $_POST['id']);
        $s->execute();
        $pdo = NULL; // close db connection
    } catch (PDOException $e) {
        $error = "Failed to delete author";
        include 'error.html.php';
        exit();
    }
    $s = NULL; // close db connection
    header("Location: .");
    exit();
}

// Display All Authors
$authors = getAuthors();

// Display Author's professions
$professions = getProfessions();

// Author adding variables
$pagetitle = "Add New Author";
$action = "addform";
$name = "";
$id = "";
$button = "Add Author";

// JS Files
$script = "/admin/assets/js/authors.js";

include 'authors.html.php';
