<?php
require_once 'config/config.php';

// Clear session
$_SESSION = array();
session_destroy();

// Redirect to home
header('Location: ' . url('/'));
exit();
?>