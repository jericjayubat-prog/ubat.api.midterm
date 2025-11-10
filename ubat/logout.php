<?php
require_once __DIR__ . '/includes/config.php';
session_destroy();

// Use relative path (no leading /) so it works in any folder
header('Location: index.php');
exit;
