<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Prevent browser from caching authenticated pages
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect to home page
header("Location: ../index.php");
exit();
