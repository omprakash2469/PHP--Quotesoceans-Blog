<?php
// Logout the user
session_start();
unset($_SESSION['loggedIn']);
unset($_SESSION['username']);
unset($_SESSION['password']);
header("Location: /");
exit();