<?php
// logout.php — Member 2 | Task 3
// Destroys the full session and redirects to login.php

if (session_status() === PHP_SESSION_NONE) session_start();

// Destroy everything
$_SESSION = [];
session_destroy();

header('Location: login.php');
exit();
