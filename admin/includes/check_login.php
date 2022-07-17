<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['password']) || ($_SESSION['loggedIn'] != TRUE)) {
    header("location: /admin");
}