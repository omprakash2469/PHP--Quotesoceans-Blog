<?php
// Check if the User of Loggedin or not
require_once '../includes/check_login.php';
require_once '../includes/access.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/functions.php';

if (!userHasRole('Site Administrator')) {
    header("Location: /admin");
}

// Add new author in the database
if (isset($_GET['addform'])) {
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    
    // Check if image file is uploaded
    if (empty($_FILES['upload']['tmp_name'])) {
        $error = "Please Upload Image";
        include 'error.html.php';
        exit();
    }

    if (isset($_POST['name']) && !empty($_POST['name'])) {
        // Establish db connection
        include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
        $name = strtolower($_POST['name']);

        // Check if the given category exist
        try {
            $sql = "SELECT `name` FROM `category` WHERE `name` = :name";
            $s = $pdo->prepare($sql);
            $s->bindvalue(':name', $name);
            $s->execute();
        } catch (PDOException $e) {
            $error = "Error fetching category <br>";
            include 'error.html.php';
            exit();
        }
        $exist = $s->rowCount();
        $s = NULL; // close db connection
        // Redirect to categories page if exists
        if ($exist > 0) {
            $pdo = NULL; // close db connection
            header("location: .");
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
        if ($fileExt == 'webp') {
            // Upload Image and insert into tables
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/images/categories/';
            $fileName = time() . getUnique(15) . "." . $fileExt;
            // Upload Image file
            if (!copy($fileTmp, $uploadDir . $fileName)) {
                $error = "Error uploading file";
                include 'error.html.php';
                exit();
            }

            // Add category if category not exists
            try {
                $sql = "INSERT INTO `category` (`name`, `catImage`) VALUES (:name, :img)";
                $s = $pdo->prepare($sql);
                $s->bindvalue(':name', $name);
                $s->bindvalue(':img', $fileName);
                $s->execute();
                $s = NULL; // close db connection
            } catch (PDOException $e) {
                $error = "Error Inserting New Category ";
                include 'error.html.php';
                exit();
            }
        }
    }

    // Create table of the category
    try {
        $sql = "CREATE TABLE IF NOT EXISTS `$name` ( `quoteid` INT NOT NULL AUTO_INCREMENT ,  `quotetext` TEXT NOT NULL ,  `quoteImg` VARCHAR(255) NOT NULL ,  `authorid` INT NOT NULL ,  `quotedate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,    PRIMARY KEY  (`quoteid`), FULLTEXT KEY (`quotetext`), FOREIGN KEY (authorid) REFERENCES author(id)) ENGINE = InnoDB";
        $s = $pdo->query($sql);
        $pdo = NULL; // close db connection
    } catch (PDOException $e) {
        $error = "Error creating category table ";
        include 'error.html.php';
        exit();
    }
    header("location: .");
    exit();
}

// Editing category name and category table name
if (isset($_GET['editform'])) {
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        // Establish db connection
        include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';
        $id = $_POST['id'];

        // fetch category and image name from id
        try {
            $sql = "SELECT `name`, `catImage` FROM `category` WHERE `id` = :id";
            $s = $pdo->prepare($sql);
            $s->bindvalue(':id', $id);
            $s->execute();
        } catch (PDOException $e) {
            $error = "Error fetching category name";
            include 'error.html.php';
            exit();
        }
        $row = $s->fetch();
        $category = strtolower($row['name']);
        $imageName = $row['catImage'];

        $s = NULL; // close db connection

        // Upload image if available
        if (!empty($_FILES['upload']['tmp_name'])) {
            // Get image details
            $oldFileName = $_FILES['upload']['name'];
            $fileTmp = $_FILES['upload']['tmp_name'];
            $fileSize = $_FILES['upload']['size'];
            $fileExt = pathinfo(strtolower($oldFileName), PATHINFO_EXTENSION);

            // Upload Image File
            if ($fileExt == 'webp') {
                // Upload Image and insert into tables
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/images/categories/';
                if (file_exists($uploadDir . $imageName)) {
                    unlink($uploadDir . $imageName);
                }
                $imageName = time() . getUnique(15) . "." . $fileExt;
                // Upload Image file
                if (!copy($fileTmp, $uploadDir . $imageName)) {
                    $error = "Error uploading file";
                    include 'error.html.php';
                    exit();
                }
            }
        }

        $newTable = strtolower($_POST['name']);
        if ($newTable!=$category) {
            // Rename table of the category
            try {
                $sql = "RENAME TABLE `$category` TO `$newTable`";
                $s = $pdo->query($sql);
                $s = NULL; // close db connection
            } catch (PDOException $e) {
                $error = "Failed to Rename category table ";
                include 'error.html.php';
                exit();
            }
        }

        // Edit category table
        try {
            $sql = "UPDATE `category` SET `name` = :name, `catImage` = :cimg WHERE `id` = :id";
            $s = $pdo->prepare($sql);
            $s->bindvalue(':name', $newTable);
            $s->bindvalue(':cimg', $imageName);
            $s->bindvalue(':id', $id);
            $s->execute();
            $s = NULL; // close db connection
        } catch (PDOException $e) {
            $error = "Error updating category name ";
            include 'error.html.php';
            exit();
        }
        $pdo = NULL; // close db connection
    }
    header("location: .");
    exit();
}

// Deleting the author and its related quotes in the database
if (isset($_POST['action']) && $_POST['action'] == "delete") {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Establish db connection
        include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';

        // Get the category name from the id
        try {
            $sql = "SELECT `name` FROM `category` WHERE `id` = :id";
            $s = $pdo->prepare($sql);
            $s->bindvalue(':id', $_POST['id']);
            $s->execute();
        } catch (PDOException $e) {
            $error = "Error fetching category name ";
            include 'error.html.php';
            exit();
        }
        $result = $s->fetch();
        $num = $result['name'];
        $s = NULL; // close db connection instance

        // Delete table of the given category
        if (isset($num) && !empty($num)) {
            try {
                $sql = "DROP TABLE `$num`";
                $result = $pdo->query($sql);
                $result = NULL; // close db connection
            } catch (PDOException $e) {
                $error = "Error deleting category table ";
                include 'error.html.php';
                exit();
            }
        }

        // Delete category name from category table
        try {
            $sql = "DELETE FROM `category` WHERE `id` = :id";
            $s = $pdo->prepare($sql);
            $s->bindvalue(':id', $_POST['id']);
            $s->execute();
            $pdo = NULL; // close db connection
            $s = NULL; // close db connection
        } catch (PDOException $e) {
            $error = "Error deleting category record ";
            include 'error.html.php';
            exit();
        }
    }
    header("Location: .");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';

try {
    $result = $pdo->query("SELECT `id`, `name`, `catImage` FROM `category`");
} catch (PDOException $e) {
    $error = "Error fetching categories " . $e->getMessage();
    include 'error.html.php';
    exit();
}
foreach ($result as $row) {
    $categories[] = array(
        'id' => $row['id'],
        'category' => $row['name'],
        'image' => $row['catImage']
    );
}
// close db connection
$pdo = NULL;
$result = NULL;

$script = "/admin/assets/js/category.js";

// Display All Categories
include 'categories.html.php';
