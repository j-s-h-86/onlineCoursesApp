<?php
require_once './config/database.php';

$dbContext = new DBContext();
$pdo = $dbContext->getPdo();

if ($pdo) {
    echo "Connection and initialization successful!";
} else {
    echo "Connection failed.";
}

?>