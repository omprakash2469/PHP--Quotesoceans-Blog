<?php
function userIsLoggedIn()
{
    if (isset($_POST['action']) && $_POST['action'] == "login") {
        // Throw error if the username or password is empty
        if (!isset($_POST['username']) or empty($_POST['username']) or !isset($_POST['password']) or empty($_POST['password'])) {
            $GLOBALS['loginError'] = "Please Fill in both fields";
            return FALSE;
        }
        $password = md5($_POST['password'].'qodb');

        // Login the user if he/she exists in database
        if (databaseContainsAuthor($_POST['username'], $password)) {
            session_start();
            $_SESSION['loggedIn'] = TRUE;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $password;
            return TRUE;
        } else {
            session_start();
            unset($_SESSION['loggedIn']);
            unset($_SESSION['username']);
            unset($_SESSION['password']);
            $GLOBALS['loginError'] = "The Specified username or password was incorrect ";
            return FALSE;
        }
    }

    session_start();
    if (isset($_SESSION['loggedIn'])) {
        return databaseContainsAuthor($_SESSION['username'], $_SESSION['password']);
    }
}

// Check if the Database Contains the submitted author
function databaseContainsAuthor($username, $password)
{
    $user = $username;
    $pass = $password;
    // Establish Database Connection
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';

    try {
        $sql = "SELECT count(*) FROM `admin` WHERE `username` = :user AND `password` = :pass";
        $result = $pdo->prepare($sql);
        $result->bindValue(':user', $user);
        $result->bindValue(':pass', $pass);
        $result->execute();
        // close db connection
        $pdo = NULL;
    } catch (PDOException $e) {
        $error = "Failed to fetch admin " . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    $row = $result->fetch();
    // close db connection
    $result = NULL;
    if ($row[0] > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// Check if the user has Role
function userHasRole($role)
{
    // Establish Database Connection
    include $_SERVER['DOCUMENT_ROOT'] . '/shared_includes/_dbconnect.php';

    try {
        $sql = "SELECT count(*) FROM admin
                INNER JOIN authorrole ON admin.id = authorid
                INNER JOIN role ON roleid = role.id
                WHERE username = :username AND role.id = :roleid";
        $result = $pdo->prepare($sql);
        $result->bindValue(':username', $_SESSION['username']);
        $result->bindValue(':roleid', $role);
        $result->execute();
        $pdo = NULL; // Close db connection
    } catch (PDOException $e) {
        $error = "Error Searching for author roles ";
        include 'error.html.php';
        exit();
    }

    $row = $result->fetch();
    $result = NULL; // close db connection
    if ($row[0] > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}
?>